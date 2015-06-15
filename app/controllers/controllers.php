<?php

//Ctrls

$app->controllers()->add('loginCtrl', function(){
	global $app, $user;

	$data = array();
	$data['passed'] = false;

	if($app->request()->ajax){
		$username = $_POST['username'];
		$password = $_POST['password'];

		if( strlen($username) === 0){
			$data['feedback'] = 'please enter a username';
		}elseif( strlen($password) === 0){
			$data['feedback'] = 'please enter a password';
		}else{

			if($user->login($username, $password)){
				$data['passed'] = true;
				$data['feedback'] = 'logging in <i class="fa fa-cog fa-spin"></i>';
			}else{
				$data['feedback'] = 'password or username is wrong.';
			}

		}
	}

	$app->json( $data );

});

$app->controllers()->add('logoutCtrl', function(){
	global $user, $app;
	$user->logout();
});
