<?php

namespace famima65536\lwe\entity;

use famima65536\lwe\entity\trait\AttackTrait;
use famima65536\lwe\entity\trait\ChaseTargetTrait;
use famima65536\lwe\entity\trait\TargetSelectorTrait;
use pocketmine\entity\Entity;

abstract class LightweightMonster extends LightweightLiving {
	use ChaseTargetTrait, AttackTrait, TargetSelectorTrait;

	protected float $attackDistance = 1;

	public function onUpdate(int $currentTick): bool{
		$update = parent::onUpdate($currentTick);
		$target = $this->target();

		if($target === null){
			return $update;
		}

		$this->lookAt($target->getLocation()->add(0, 0.7, 0));

		$this->tryActionAttack($target);

		$this->moveToward($target);

		$nearest = $this->getNearestEntityButSelf();
		if($nearest !== null){
			$boundingMotion = $nearest->getPosition()->subtractVector($this->location)->normalize()->multiply(-1);
			$this->addMotion($boundingMotion->x, 0, $boundingMotion->z);
		}

		return $update;
	}

}