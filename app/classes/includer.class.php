<?php

class includer {

	public function __construct(){
		return;
	}

	public function includePath($path, $options = array( "debug"=>false, "omit" => array() )){
		global $alerts;

		if(!is_dir($path)){
			die(print_pre("no path: ".$path));
		}

		$glob = glob($path."/*.php");

		if(isset($options["debug"]) && $options["debug"] == true){
			$alerts->alert(array("type"=>"info", "title"=>"includer.class.php", "message"=>"$path"), true);
		}

		foreach ( $glob as $filename) {
			if(file_exists($filename) ){

				if( isset($options["omit"]) ){
					if(in_array($filename, $options["omit"])){
						continue;
					}
					include $filename;
				}else{
					include $filename;
				}

				if(isset($options["debug"]) && $options["debug"] == true){
					global $alerts;
					$alerts->alert(array("type"=>"info", "title"=>"includer.class.php", "message"=>"included $filename"), true);
				}
			}
		}

	}

}