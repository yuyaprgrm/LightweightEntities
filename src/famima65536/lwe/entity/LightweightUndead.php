<?php

namespace famima65536\lwe\entity;

use pocketmine\entity\Entity;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\world\World;

abstract class LightweightUndead extends LightweightMonster {

	public function onUpdate(int $currentTick): bool{
		$timeOfDay = $this->getWorld()->getTimeOfDay();
		if(World::TIME_SUNRISE <= $timeOfDay and $timeOfDay <= World::TIME_SUNSET){
			$this->setOnFire(10);
		}
		return parent::onUpdate($currentTick);
	}
}