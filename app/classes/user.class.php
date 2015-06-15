<?php

class user extends base {

	protected $id,
			  $username,
			  $password,
			  $firstname,
			  $lastname,
			  $salt,
			  $access,
			  $comments,
			  $permissions
	;

	public function __construct(){
		if(isset($_SESSION['user']) && count($_SESSION['user']) < 0){
			foreach($_SESSION['user'] as $key=>$val){
				$this->$key = $val;
			}
		}
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

	public function login($username, $password){

		global $fpdo;
		$query = $fpdo->from('users')->where("username = '$username' AND password = '" . $password . "'");
		$fetch = $query->fetch();

		if( $fetch ){

			foreach($fetch as $key=>$val){
				$this->$key = $val;
			}

			$_SESSION['user'] = $fetch;

			return true;
		}

		return false;

	}

	public function logout(){
		$_SESSION = array();
		session_destroy();
	}

}

