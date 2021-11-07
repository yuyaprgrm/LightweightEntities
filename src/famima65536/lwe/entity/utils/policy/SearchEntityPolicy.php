<?php

namespace famima65536\lwe\entity\utils\policy;

use famima65536\lwe\utils\Policy;
use pocketmine\entity\Entity;
use pocketmine\entity\Living;
use pocketmine\utils\SingletonTrait;

class SearchEntityPolicy implements Policy{

	use SingletonTrait;

	public function satisfiedBy($object): bool{
		if(!$object instanceof Entity)
			return false;
		return ($object->isAlive() and $object instanceof Living);
	}
}