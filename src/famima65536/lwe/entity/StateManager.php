<?php

namespace famima65536\lwe\entity;

use famima65536\lwe\entity\utils\state\IState;
use famima65536\lwe\entity\utils\StateManageTrait;

class StateManager {
	use StateManageTrait;

	public function __construct(IState $state){
		$this->state = $state;
	}

	public function ticker(int $tickDiff){
		$this->getState()->decreaseTime($tickDiff);
	}
}