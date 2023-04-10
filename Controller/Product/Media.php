<?php

class Controller_Product_Media extends Controller_Core_Action
{

	public function gridAction()
	{
		try {
			$productId = Ccc::getModel('Core_Request')->getParam('product_id');
			if (!$productId) {
				throw new Exception("Id not found", 1);
			}
			Ccc::register('product_id',$productId);

			$layout = $this->getLayout();
			$grid = $layout->createBlock('Product_Media_Grid');
			$medias = $grid->getMedias()->getData();
			$layout->getChild('content')->addChild('grid',$grid);
			$layout->render();

		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
	}

	public function addAction()
	{
		try {
			Ccc::getModel('Core_Session')->start();
			$productId = Ccc::getModel('Core_Request')->getParam('product_id');
			Ccc::register('product_id',$productId);
			$layout = $this->getLayout();
			$add = new Block_Product_Media_Edit();
			$layout->getChild('content')->addChild('add',$add);
			$layout->render();

		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
	}	
	
	public function saveAction()
	{
		try {
			Ccc::getModel('Core_Session')->start();
			if (!Ccc::getModel('Core_Request')->isPost()) {
				throw new Exception("Invalid Request", 1);
			}

			$productId = Ccc::getModel('Core_Request')->getParam('product_id');
			if (!$productId) {
				throw new Exception("ID not found.", 1);
			}

			$mediaPostData = Ccc::getModel('Core_Request')->getPost();
			if (array_key_exists('submit', $mediaPostData)) {

				$productMedia = Ccc::getModel('Core_Request')->getPost();
				$smallId = $productMedia['small'];
				$thumbnailId = $productMedia['thumbnail'];
				$baseId = $productMedia['base'];
				$galleryId = $productMedia['gallery'];

				$mediaIds['base'] = 0;
				$mediaIds['small'] = 0;
				$mediaIds['thumbnail'] = 0;
				$mediaIds['gallery'] = 0;

				$mediaPost = Ccc::getModel('Product_Media');
				$sql = "SELECT `media_id` FROM `media` WHERE `product_id` = {$productId}";
				$id = $mediaPost->fetchAll($sql);
				
				foreach($id as $key => $value)
				{	
					$ids[] = $value->getData('media_id');
				}

				foreach($ids as $key => $value)
				{
					$mediaIds['media_id'] = $value;
					$mediaPost->setData($mediaIds);
					$result = $mediaPost->save();
					$mediaPost->removeData();
					if ($result) {
						$this->getView()->getMessage()->addMessages('Product media saved Successfully.');
					}
				}

				$small['small'] = 1;
				$small['media_id'] = $smallId;
				$mediaPost->setData($small);
				$productMedia = $mediaPost->save();
				$mediaPost->removeData();			
				if ($productMedia) {
					$this->getView()->getMessage()->addMessages('Product media saved Successfully.');
				}

				$thumbnail['thumbnail'] = 1;
				$thumbnail['media_id'] = $thumbnailId;
				$mediaPost->setData($thumbnail);
				$productMedia = $mediaPost->save();
				$mediaPost->removeData();
				if ($productMedia) {
					$this->getView()->getMessage()->addMessages('Product media saved Successfully.');
				}

				$base['base'] = 1;
				$base['media_id'] = $baseId;
				$mediaPost->setData($base);
				$productMedia = $mediaPost->save();
				$mediaPost->removeData();
				if ($productMedia) {
					$this->getView()->getMessage()->addMessages('Product media saved Successfully.');
				}

				$gallery['gallery'] = 1;
				foreach ($galleryId as $key => $value) {
					$gallery['media_id'] = $value;
					$mediaPost->setData($gallery);
					$productMedia = $mediaPost->save();
					$mediaPost->removeData();
				}

				if ($productMedia) {
					$this->getView()->getMessage()->addMessages('Product media saved Successfully.');
				}
				
			} else {
				$mediaPost = Ccc::getModel('Product_Media');
				$mediaPost->setData($mediaPostData['media']);
				$mediaPost->create_at = date('Y-m-d h-i-sA');
				$mediaPost->product_id = $productId;

				$result = $mediaPost->save();
				$mediaId = $mediaPost->media_id;

				$fileName = $_FILES['media']['name']['image'];
				$tmpName = $_FILES['media']['tmp_name']['image'];

				$stringArray = explode('.', $fileName);
				$extension = $stringArray[1];

				$fileName = $mediaId.'.'.$extension;
				$destination = 'view/product/media/upload/'.$fileName;
				$result = move_uploaded_file($tmpName, $destination);

				$mediaPost->image = $fileName;
				$mediaPost->media_id = $mediaId;
				$productMedia = $mediaPost->save();
				if (!$productMedia) {
					throw new Exception("Product Media not saved Successfully.", 1);
				}else{
					$this->getView()->getMessage()->addMessages('Product Media saved Successfully.');
				}
			}

		} catch (Exception $e) {
			$this->getView()->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);			
		}
		$this->redirect('grid', null);

	}


	public function deleteAction()
	{
		try {
			$this->getMessage()->getSession()->start();
			$productId = $this->getRequest()->getParam('product_id');
			$mediaId = $this->getRequest()->getParam('media_id');
			if (!$mediaId) {
				throw new Exception("Id not found", 1);
			}

			$condition['product_id'] = $productId;
			$condition['media_id'] = $mediaId;

			$result = $this->getMediaModel()->delete($condition);
			$this->getMessage()->addMessages('Data deleted', Model_Core_Message::SUCCESS);
			
		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
		
		$this->redirect('product_media','grid', ['product_id' => $productId, 'media_id' => null]);

	}

}


?>