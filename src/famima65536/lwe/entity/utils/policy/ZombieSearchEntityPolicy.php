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

	public function satisfiedBy($object): bool{
		if(!$object instanceof Entity)
			return false;
		return ($object->isAlive() and $object instanceof Living) and
			(
				($object instanceof Player and $object->isSurvival()) or
				$object instanceof Villager
			);
	}
}