<?php

namespace famima65536\lwe\entity\trait;

use pocketmine\entity\Entity;
use pocketmine\player\Player;
use pocketmine\world\World;

trait TargetSelectorTrait {
	protected ?Entity $currentTarget = null;
	protected int $searchTargetTick = 0;
	protected int $targetSearchDistance = 30;


	public function target(): ?Entity{
		if($this->currentTarget !== null and !$this->currentTarget->isClosed()){
			return $this->currentTarget;
		}
		if($this->searchTargetTick > 0){
			return null;
		}
		$this->currentTarget = $this->searchTarget();
		if($this->currentTarget !== null){
			$this->onTargetSelect($this->currentTarget);
		}
		return $this->currentTarget;
	}

	public function searchTarget(): ?Entity{
		return $this->getWorld()->getNearestEntity($this->location, $this->targetSearchDistance, Player::class);
	}

	abstract public function getWorld(): World;

	protected function onTargetSelect(?Entity $currentTarget): void{
	}

}