<?php

class base {

	public function get($param){
		if(isset($this->$param)){
			return $this->$param;
		}
	}

	public function set($param, $val){
		$this->$param = $val;
	}

}

