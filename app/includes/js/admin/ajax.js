(function($){
	"use strict";

	var steel = window.Steel;

	var ajaxCalls = [
		function(){ //Login Form
			var loginForm = $('.login-form');

			loginForm.find('button').click(function(e){

				var usernameFieldVal = loginForm.find('.inputUsername').val();
				var passwordFieldVal = loginForm.find('.inputPassword').val();

				$.ajax({
					url: "/login",
					method: 'post',
					data: {
						"username": $.trim(usernameFieldVal),
						"password": $.trim(passwordFieldVal)
					},
					dataType: 'json',
					cache: false
				}).done(function(data){

					var feedback_text = data['feedback'];
					var feedback = $('.login-feedback-text');

					if(data['passed'] === true){
						feedback.addClass('text-success').removeClass('hidden text-danger');

						steel.replacePage('/admin');

					} else {
						feedback.addClass('text-danger').removeClass('hidden text-success');
					}

					if(feedback_text !== undefined){
						feedback.html(feedback_text);
					}else{
						feedback.addClass('hidden');
					}

				});

				e.preventDefault();

			});

		},

		function(){ //Login Form
			var logout = $('.logout');

			logout.click(function(e){

				$.ajax({
					url: "/logout",
					method: 'get',
					cache: false
				}).done(function(data){
					steel.replacePage('/admin');
				});

				e.preventDefault();

			});

		},
	]

	//fire ajax calls
	$.each(ajaxCalls, function(k,v){
		v.call(this,[]);
	});


})(jQuery)