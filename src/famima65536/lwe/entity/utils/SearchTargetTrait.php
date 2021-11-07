<?php

namespace famima65536\lwe\entity\utils;

use famima65536\lwe\entity\utils\policy\SearchEntityPolicy;
use famima65536\lwe\utils\Policy;
use pocketmine\entity\Entity;
use pocketmine\world\format\Chunk;
use pocketmine\world\World;

trait SearchTargetTrait {

	protected int $searchTargetTime = 0;
	protected int $targetSearchDistance = 15;

	protected ?Policy $searchPolicy = null;

	public function findTarget(): ?Entity{
		if($this->searchTargetTime > 0){
			return null;
		}
		$this->searchTargetTime = 200;
		$target =  $this->getNearestEntityMatchPolicy($this->targetSearchDistance, $this->searchPolicy ?? SearchEntityPolicy::getInstance());
		if($target !== null){
			$this->onTargetSelect($target);
		}
		return $target;
	}

	public function getNearestEntityMatchPolicy(float $maxDistance, Policy $policy) : ?Entity{
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
					if($this === $entity or !$policy->satisfiedBy($entity)){
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