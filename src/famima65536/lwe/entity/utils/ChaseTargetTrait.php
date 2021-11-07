<?php

namespace famima65536\lwe\entity\utils;

use pocketmine\block\Transparent;
use pocketmine\entity\Entity;
use pocketmine\world\World;

trait ChaseTargetTrait {

	abstract public function getWorld(): World;
	abstract public function jump(): void;
	abstract public function getMovementSpeed(): float;
	abstract public function isOnGround(): bool;

	public function moveToward(Entity $target){
		$vectorToTarget = $target->getPosition()->subtractVector($this->location);

		$vectorToTarget->y = 0;
		$normalizedVector = $vectorToTarget->normalize();
		if(!$this->getWorld()->getBlock($this->location->addVector($normalizedVector)) instanceof Transparent){
			$this->jump();
		}else{
			$motion = $normalizedVector->multiply($this->getMovementSpeed());
			if(!$this->isOnGround()){
				$motion = $motion->multiply(0.5);
			}
			$this->lastMotion->x = $motion->x;
			$this->lastMotion->z = $motion->z;
			$this->motion = clone $this->lastMotion;
		}
	}

}