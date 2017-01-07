<?php

global $app;

$user = $app->get('user');
$user = $app->get('alerts');
$fpdo = $app->get('fpdo');

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

		$app->json( $data );

	}else{
		send_404();
	}

});

$app->controllers()->add('logoutCtrl', function(){
	global $app, $user;
	$user->logout();
});

$app->controllers()->add('registerCtrl', function(){
	global $app, $user;

	$data = array();
	$data['passed'] = false;

	if(isset($_COOKIE["timeout"]) && $_COOKIE["timeout"] == 1) {
		$data['error'] = "Nah, you're done here.";
		$data['error_code'] = 'IP_BANNED';
		return $app->json( $data );
	}

	if($app->request()->ajax  && !$user->loggedIn() && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['nickname']) ){

		$register_info = array(
			"username" => $_POST['username'],
			"password" => $_POST['password'],
			"nickname" => $_POST['nickname'],
			"access" => 0
		);

		$banned_fetch = $fpdo->from('banned_ips')->where('ip = ?', getRealIpAddr());
		$banned_count = count($banned_fetch->fetchAll());

		if($banned_count === 0){ //if ip is not banned
			$register = $user->register($register_info);

			if($register === true){
				$data['passed'] = true;
			}else if( is_array( $register) ){
				$data['error'] = $register['error'];
				$data['error_code'] = $register['error_code'];
			}
		}else{
			$data['error'] = 'You are not permitted to register a new account';
			$data['error_code'] = 'IP_BANNED';
		}

		$app->json( $data );
	}else{
		send_404();
	}

});

$app->controllers()->add('bannedIpCtrl', function(){
	global $app, $user;

	$data = array();
	$data['passed'] = false;

	if($app->request()->ajax  && $user->loggedIn() && $user->isAdmin() ){

		$ban_info = array(
			"ip" => $_POST['ip'],
		);

		$query = $fpdo->insertInto('`banned_ips`', $ban_info);

		if($query->execute()){
			$data['passed'] = true;
		}

		$app->json( $data );
	}else{
		send_404();
	}

});


