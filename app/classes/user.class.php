<?php

class user extends base {

	public $id,
			  $username,
			  $password,
			  $firstname,
			  $lastname,
			  $salt,
			  $access,
			  $comments,
			  $permissions,
			  $nickname,
			  $banned,
			  $last_ip
	;

	public function __construct(){

		if(isset($_SESSION['user']) && count($_SESSION['user']) > 0){
			foreach($_SESSION['user'] as $key=>$val){
				$this->$key = $val;
			}
		}

		return $this;
	}

	/**
	 * loggedIn function.
	 *
	 * @access public
	 * @return bool
	 */
	public function loggedIn(){
		return (bool)isset($_SESSION['user']);
	}

	public function getUserById($id){
		global $fpdo;
		$query = $fpdo->from('users')->where('id',$id);
		return $query->fetch();
	}

	public function getUserSalt($username){
		global $fpdo;
		$query = $fpdo->from('`users`')->where("`username` =  ?", $username);
		$query = $query->fetch();
		return $query['salt'];
	}

	public function login($username, $password){

		global $fpdo, $_config;

		if( isset($_config->password_hash_alg) ){ //check if we have a hash if we do hash the login!
			$salt = $this->getUserSalt($username);
			$query = $fpdo->from('users')->where("username = ? AND password = ?", $username,  hash($_config->password_hash_alg, $password.$salt));
		}else{
			$query = $fpdo->from('users')->where("username = ? AND password = ?", $username, $password);
		}

		$fetch = $query->fetch();

		if( $fetch ){
			$banned_fetch = $fpdo->from('banned_ips')->where('ip = ?', getRealIpAddr());
			$banned_count = count($banned_fetch->fetchAll());
			if($fetch['banned'] == 1 || $banned_count > 0){
				return false;
			}else{
				$update_ip = $fpdo->update('`users`')->set(array('`last_ip`' => getRealIpAddr() ))->where('`id` = ?', $fetch['id']);
				$update_ip->execute();

			}

			foreach($fetch as $key=>$val){
				$this->$key = $val;
			}

			$_SESSION['user'] = $fetch;

			return true;
		}

		return false;

	}

	public function isUsernameTaken($username){
		global $fpdo;
		$query = $fpdo->from('`users`')->where("`username` = ?", $username);
		$query = $query->fetch();
		return $query['username'] === $username;
	}

	public function register($userinfo = array()){
		if(is_array($userinfo)){
			global $fpdo, $_config;

			//basic clean
			foreach($userinfo as $k=>$v){
				 $userinfo[$k] = filter_var($v, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
			}

			if(!$this->isUsernameTaken($userinfo['username'])){
				//generate the salt and concat the password
				$userinfo['salt'] = $this->generateSalt();
				$userinfo['password'] = hash($_config->password_hash_alg, $userinfo['password'].$userinfo['salt']);

				//prepare to insert into db
				$query = $fpdo->insertInto('users', $userinfo);
				if($query->execute()){ //if we insert
					return true;
				}
			}else{
				return array('error' => 'this email is already taken', 'error_code' => "USERNAME_TAKEN");
			}
		}
		return false;

	}

	public function changePassword($user_id, $password){
		global $fpdo, $_config;
		$new_salt = $this->generateSalt();//get this id a new salt
		$query = $fpdo->update('`users`')->set(array('`password`' => hash($_config->password_hash_alg, $password.$new_salt), '`salt`' => $new_salt ))->where('`id` = ?', $user_id);
		if($query->execute()){
			return true;
		}
		return false;
	}

	public function generateSalt($length = 16){
		return base64_encode(mcrypt_create_iv(ceil(0.75*$length), MCRYPT_DEV_URANDOM));
	}

	public function logout(){
		$_SESSION = array();
		session_destroy();
	}

	public function isAdmin($level = 1){
		return $this->loggedIn() && $this->access > $level;
	}

	public function isBanned($query = true){
		global $fpdo;

		if($query){
			if($this->banned == 1){
				error_log(print_r(headers_list(), true));
				setcookie("timeout", 1, 86400 * 7);
				return true;
			}else{
				$check_banned = $fpdo->from('users')->where('id = ?', $this->get('id'));
				$check_banned = $check_banned->fetch();

				if($check_banned['banned'] === 1){
					error_log(print_r(headers_list(), true));
					setcookie("timeout", 1, 86400 * 7);
					$this->set('banned', true);
					return true;
				}
			}
		}

		return $this->banned == 1;

	}

	public function hasAccessAbove($level = 0){
		return $this->loggedIn() && $this->access > $level;
	}

}

