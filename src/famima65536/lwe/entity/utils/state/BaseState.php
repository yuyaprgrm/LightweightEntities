<?php

namespace famima65536\lwe\entity\utils\state;

abstract class BaseState implements IState {

	const DEFAULT_TIME = 20;
	private int $time = 0;

	public function __construct(?int $time=null){
		$this->time = $time ?? static::DEFAULT_TIME;
	}

	public function isFinished(): bool{
		return $this->time === 0;
	}

	public function decreaseTime(int $tick): void{
		if($this->time > 0){
			$this->time -= $tick;
			if($this->time < 0){
				$this->time = 0;
			}
		}
	}
}