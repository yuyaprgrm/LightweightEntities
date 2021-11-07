<?php

namespace famima65536\lwe\entity;

use pocketmine\world\World;

abstract class LightweightUndead extends LightweightMonster {

	public function onUpdate(int $currentTick): bool{
		$timeOfDay = $this->getWorld()->getTimeOfDay();
		if(!$this->isOnFire() and (World::TIME_SUNRISE <= $timeOfDay or $timeOfDay <= World::TIME_SUNSET)){
			$this->setOnFire(3);
		}
		return parent::onUpdate($currentTick);
	}
}