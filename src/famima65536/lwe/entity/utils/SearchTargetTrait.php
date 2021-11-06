<?php

namespace famima65536\lwe\entity\utils;

use famima65536\lwe\entity\utils\policy\SearchEntityPolicy;
use pocketmine\entity\Entity;
use pocketmine\world\format\Chunk;
use pocketmine\world\World;

trait SearchTargetTrait {

	protected int $searchTargetTick = 0;
	protected int $targetSearchDistance = 30;
	private SearchEntityPolicy $searchPolicy;


	public function target(): ?Entity{
		if($this->searchTargetTick > 0){
			return null;
		}
		$target =  $this->getNearestEntityMatchPolicy($this->targetSearchDistance, $this->searchPolicy);
		if($target !== null){
			$this->onTargetSelect($target);
		}
		return $target;
	}

	public function getNearestEntityMatchPolicy(float $maxDistance, SearchEntityPolicy $policy) : ?Entity{
		$pos = $this->getPosition();
		$minX = ((int) floor($pos->x - $maxDistance)) >> Chunk::COORD_BIT_SIZE;
		$maxX = ((int) floor($pos->x + $maxDistance)) >> Chunk::COORD_BIT_SIZE;
		$minZ = ((int) floor($pos->z - $maxDistance)) >> Chunk::COORD_BIT_SIZE;
		$maxZ = ((int) floor($pos->z + $maxDistance)) >> Chunk::COORD_BIT_SIZE;

		$currentTargetDistSq = $maxDistance ** 2;

		/**
		 * @var Entity|null $currentTarget
		 */
		$currentTarget = null;
		$world = $this->getWorld();
		for($x = $minX; $x <= $maxX; ++$x){
			for($z = $minZ; $z <= $maxZ; ++$z){
				if(!$world->isChunkLoaded($x, $z)){
					continue;
				}
				foreach($world->getChunkEntities($x, $z) as $entity){
					if(!$policy->satisfyBy($entity)){
						continue;
					}
					$distSq = $entity->getPosition()->distanceSquared($pos);
					if($distSq < $currentTargetDistSq){
						$currentTargetDistSq = $distSq;
						$currentTarget = $entity;
					}
				}
			}
		}

		return $currentTarget;
	}

	abstract public function getWorld(): World;

	protected function onTargetSelect(?Entity $target): void{
	}

}