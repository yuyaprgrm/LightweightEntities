<?php

namespace famima65536\lwe\entity;

use famima65536\lwe\entity\trait\ChaseTargetTrait;
use pocketmine\block\Transparent;
use pocketmine\entity\Entity;
use pocketmine\entity\Living;
use pocketmine\entity\Location;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;
use pocketmine\world\format\Chunk;

abstract class LightweightLiving extends Living {

	use ChaseTargetTrait;

	# code for search
	private int $searchCooldown = 100;
	protected int $searchTime = 0;

	protected float $boundingRadius = 0.5;
	protected $jumpVelocity = 0.5;

	public function __construct(Location $location, ?CompoundTag $nbt = null){
		parent::__construct($location, $nbt);
		$this->moveSpeedAttr->setValue(0.3);
	}

	protected function getNearestEntityButSelf(): ?Entity{
		$world = $this->getWorld();
		$pos = $this->location;
		$maxDistance = $this->boundingRadius;
		$minX = ((int) floor($pos->x - $maxDistance)) >> Chunk::COORD_BIT_SIZE;
		$maxX = ((int) floor($pos->x + $maxDistance)) >> Chunk::COORD_BIT_SIZE;
		$minZ = ((int) floor($pos->z - $maxDistance)) >> Chunk::COORD_BIT_SIZE;
		$maxZ = ((int) floor($pos->z + $maxDistance)) >> Chunk::COORD_BIT_SIZE;

		$currentTargetDistSq = $maxDistance ** 2;

		/**
		 * @var Entity|null $currentTarget
		 * @phpstan-var TEntity|null $currentTarget
		 */
		$currentTarget = null;

		for($x = $minX; $x <= $maxX; ++$x){
			for($z = $minZ; $z <= $maxZ; ++$z){
				if(!$world->isChunkLoaded($x, $z)){
					continue;
				}
				foreach($world->getChunkEntities($x, $z) as $entity){
					if($entity === $this or !($entity instanceof Living) or $entity->isFlaggedForDespawn() or !$entity->isAlive()){
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



}