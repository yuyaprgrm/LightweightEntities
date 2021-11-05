<?php

namespace famima65536\lwe\entity\trait;

use pocketmine\entity\Entity;

trait AttackTrait {

	protected int $actionAttackTime = 0;
	protected float $attackDistance = 1;


	abstract public function actionAttack(Entity $target): void;

	public function tryActionAttack(Entity $entity): bool{
		if($this->actionAttackTime > 0 or $entity->getPosition()->distanceSquared($this->location) > $this->attackDistance**2){
			return false;
		}
		$this->actionAttack($entity);
		return true;
	}

	/**
	 * should be called in entityBaseTick()
	 * @param int $tickDiff
	 */
	public function attackTicker(int $tickDiff): void{
		if($this->actionAttackTime > 0){
			$this->actionAttackTime -= $tickDiff;
			if($this->actionAttackTime < 0){
				$this->actionAttackTime = 0;
			}
		}
	}

	public function isTargetInAttackDistance(?Entity $target){
	}

}