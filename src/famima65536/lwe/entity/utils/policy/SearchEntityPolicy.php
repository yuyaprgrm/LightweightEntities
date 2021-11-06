<?php

namespace famima65536\lwe\entity\utils\policy;

use famima65536\lwe\utils\Policy;
use pocketmine\entity\Entity;
use pocketmine\entity\Living;
use pocketmine\utils\SingletonTrait;

class SearchEntityPolicy implements Policy{

	use SingletonTrait;

	public function satisfyBy($entity): bool{
		if(!$entity instanceof Entity)
			return false;
		return ($entity->isAlive() and $entity instanceof Living);
	}
}