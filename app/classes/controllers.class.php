<?php

class controllers {

	public $controllers = array();

	public function add($name, $func){
		$this->controllers[$name] = $func;
	}

	public function remove($name){
		if(isset($this->controllers[$name])){
			unset($this->controllers[$name]);
		}
	}

	public function fire($name){
		if(isset($this->controllers[$name])){
			$this->controllers[$name]();
		}
	}

}

