<?php

namespace famima65536\lwe\entity\utils;

use famima65536\lwe\entity\utils\state\IState;

trait StateManageTrait {

	private IState $state;
	public function setState(IState $state){
		$this->state = $state;
	}

	public function getState(): IState{
		return $this->state;
	}
}