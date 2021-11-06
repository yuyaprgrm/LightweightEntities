<?php

namespace famima65536\lwe;

use famima65536\lwe\entity\LightweightCow;
use famima65536\lwe\entity\LightweightGuardian;
use famima65536\lwe\entity\LightweightSkeleton;
use famima65536\lwe\entity\LightweightZombie;
use pocketmine\data\bedrock\EntityLegacyIds;
use pocketmine\entity\Entity;
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\EntityFactory;
use pocketmine\entity\Location;
use pocketmine\entity\Zombie;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemIds;
use pocketmine\item\SpawnEgg;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\plugin\PluginBase;
use pocketmine\world\World;

class Loader extends PluginBase {
	public function onLoad(): void{
		/** @var EntityFactory $factory */
		$factory = EntityFactory::getInstance();
		$factory->register(LightweightZombie::class, function(World $world, CompoundTag $nbt) : LightweightZombie{
			return new LightweightZombie(EntityDataHelper::parseLocation($nbt, $world), $nbt);
		}, ['Custom Zombie', 'minecraft:zombie'], EntityLegacyIds::ZOMBIE);
		$factory->register(LightweightSkeleton::class, function(World $world, CompoundTag $nbt) : LightweightSkeleton{
			return new LightweightSkeleton(EntityDataHelper::parseLocation($nbt, $world), $nbt);
		}, ['Custom Skeleton', 'minecraft:skeleton'], EntityLegacyIds::SKELETON);
		$factory->register(LightweightCow::class, function(World $world, CompoundTag $nbt) : LightweightCow{
			return new LightweightCow(EntityDataHelper::parseLocation($nbt, $world), $nbt);
		}, ['Custom Cow', 'minecraft:cow'], EntityLegacyIds::COW);
		$factory->register(LightweightGuardian::class, function(World $world, CompoundTag $nbt) : LightweightGuardian{
			return new LightweightGuardian(EntityDataHelper::parseLocation($nbt, $world), $nbt);
		}, ['Custom Guardian', 'minecraft:guardian'], EntityLegacyIds::GUARDIAN);

		/** @var ItemFactory $factory */
		$factory = ItemFactory::getInstance();
		$factory->register(new class(new ItemIdentifier(ItemIds::SPAWN_EGG, EntityLegacyIds::ZOMBIE), "Custom Zombie Spawn Egg") extends SpawnEgg{
			protected function createEntity(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
				return new LightweightZombie(Location::fromObject($pos, $world, $yaw, $pitch));
			}
		}, true);
		$factory->register(new class(new ItemIdentifier(ItemIds::SPAWN_EGG, EntityLegacyIds::SKELETON), "Custom Zombie Spawn Egg") extends SpawnEgg{
			protected function createEntity(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
				return new LightweightSkeleton(Location::fromObject($pos, $world, $yaw, $pitch));
			}
		}, true);
		$factory->register(new class(new ItemIdentifier(ItemIds::SPAWN_EGG, EntityLegacyIds::COW), "Custom Zombie Spawn Egg") extends SpawnEgg{
			protected function createEntity(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
				return new LightweightCow(Location::fromObject($pos, $world, $yaw, $pitch));
			}
		}, true);
		$factory->register(new class(new ItemIdentifier(ItemIds::SPAWN_EGG, EntityLegacyIds::GUARDIAN), "Custom Zombie Spawn Egg") extends SpawnEgg{
			protected function createEntity(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
				return new LightweightGuardian(Location::fromObject($pos, $world, $yaw, $pitch));
			}
		}, true);
	}
}