<?php

namespace famima65536\lwe\entity\utils\state;

use pocketmine\entity\Entity;

class AttackingTargetState extends BaseState {

	const DEFAULT_TIME = 600;

	public function __construct(private Entity $target){
		parent::__construct();
	}

	public function getId(): int{
		return StateIds::ATTACKING_TARGET;
	}

	public function isFinished(): bool{
		return $this->target->isClosed() or !$this->target->isAlive() or parent::isFinished();
	}

	public function getTarget(): Entity{
		return $this->target;
	}

}