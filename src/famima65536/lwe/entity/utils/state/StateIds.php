<?php

namespace famima65536\lwe\entity\utils\state;

final class StateIds {
	private function __construct(){
	}

	public const WAITING = 0;
	public const RANDOM_WALKING = 1;
	public const ATTACKING_TARGET = 2;
}