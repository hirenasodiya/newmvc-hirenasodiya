	var ajax = {
		method : 'post',
		url : 'google.com',
		params : {},
		form : null,

		setForm:function(formId){
			this.form = $("#"+formId);
			this.prepareRequestParams();
			return this;
		},

		getForm:function(){
			return this.form;
		},

		prepareRequestParams: function() {
			this.setUrl(this.getForm().attr("action"));
			this.setMethod(this.getForm().attr("method"));
			this.setParams(this.getForm().serializeArray());
		},

		setMethod:function(method){	
			this.method = method;
			return this;
		},

		getMethod:function(){
			return this.method;
		},

		setUrl:function(url){
			this.url = url;
			return this;
		},

		getUrl:function(){
			return this.url;
		},

		setParams:function(params){
			this.params = params;
			return this;
		},

		getParams:function(){
			
			return this.params;
		},

		call:function(){

			$.ajax({
				url:this.getUrl(),
				type:this.getMethod(),
				dataType : "json", 
				data:this.getParams(),
			}).done(function (response){
				$("#" + response.element).html(response.html);
			});
		}

	};
