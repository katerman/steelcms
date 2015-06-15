<?php

/*
<div class="panel panel-primary">...</div>
<div class="panel panel-success">...</div>
<div class="panel panel-info">...</div>
<div class="panel panel-warning">...</div>
<div class="panel panel-danger">...</div>
*/

class alerts {

	public $alertArray;

	public function __construct(){
		$this->alertArray = array();
	}

	public function alert($opts = array("type"=>"primary", "title"=>"Title", "message"=>"message"), $dismissable = true){

		$type = isset($opts['type']) ? $opts['type'] : 'primary' ;
		$title = isset($opts['title']) ? $opts['title'] : false ;
		$message =  isset($opts['message']) ? $opts['message'] : '' ;

		array_push($this->alertArray, array("type"=>$type, "title" => $title, "message" => $message, "dismissable" => $dismissable));
	}

	public function displayAll(){
		global $app;

		foreach($this->alertArray as $alert){
			$app->render('elements/alert.view.php', array( "type" => $alert['type'], "title" => $alert['title'], "message" => $alert['message'], "dismissable" => $alert['dismissable'] ));
		}
	}

}