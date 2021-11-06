<?php

namespace famima65536\lwe\entity\utils\policy;

use famima65536\lwe\utils\Policy;
use pocketmine\entity\Entity;
use pocketmine\entity\Living;
use pocketmine\entity\Villager;
use pocketmine\player\Player;
use pocketmine\utils\SingletonTrait;

class ZombieSearchEntityPolicy implements Policy {
	use SingletonTrait;

	public function satisfyBy($entity): bool{
		if(!$entity instanceof Entity)
			return false;
		return ($entity->isAlive() and $entity instanceof Living) and
			(
				($entity instanceof Player and $entity->isSurvival()) or
				$entity instanceof Villager
			);
	}
}