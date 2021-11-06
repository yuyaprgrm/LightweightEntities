<?php

namespace famima65536\lwe\entity\utils\policy;

use pocketmine\entity\Villager;
use pocketmine\player\Player;

class ZombieSearchEntityPolicy extends SearchEntityPolicy {
	public function satisfyBy($entity): bool{
		return parent::satisfyBy($entity) and
			(
				($entity instanceof Player and $entity->isSurvival()) or
				$entity instanceof Villager
			);
	}
}