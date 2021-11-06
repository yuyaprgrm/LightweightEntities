<?php

namespace famima65536\lwe\entity\utils\state;

class WaitingState extends BaseState {

	public function getId(): int{
		return StateIds::WAITING;
	}
}