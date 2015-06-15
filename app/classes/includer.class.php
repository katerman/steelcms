<?php

class includer {

	public function __construct(){

	}

	public function includePath($path, $omit = array(), $debug = false){
		$path = "$path/*.php";
		$glob = glob($path);

		foreach ( $glob as $filename) {
			if(!in_array($filename, $omit)){
				include $filename;

				if($debug){
					global $alerts;
					$alerts->alert(array("type"=>"info", "title"=>"includer.class.php", "message"=>"included $filename"), true);
				}
			}
		}

	}

}