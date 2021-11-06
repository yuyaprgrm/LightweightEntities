<?php

namespace famima65536\lwe\entity\utils;

use famima65536\lwe\utils\Policy;
use pocketmine\entity\Entity;
use pocketmine\player\Player;

class SearchEntityPolicy implements Policy{

	public function satisfyBy($entity): bool{
		if(!$entity instanceof Entity)
			return false;

		return ($entity->isAlive() and $entity instanceof Player and $entity->isSurvival());

	}
}