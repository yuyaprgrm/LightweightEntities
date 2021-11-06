<?php

namespace famima65536\lwe\entity\utils\state;

class RandomWalkingState extends BaseState {

	public const DEFAULT_TIME = 60;
	public function getId(): int{
		return StateIds::RANDOM_WALKING;
	}
}