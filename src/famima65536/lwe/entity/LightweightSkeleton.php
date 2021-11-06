<?php

namespace famima65536\lwe\entity;

use pocketmine\entity\animation\Animation;
use pocketmine\entity\animation\ArmSwingAnimation;
use pocketmine\entity\animation\ArrowShakeAnimation;
use pocketmine\entity\Entity;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\entity\Location;
use pocketmine\entity\projectile\Arrow as ArrowEntity;
use pocketmine\entity\projectile\Projectile;
use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\Item;
use pocketmine\item\ItemUseResult;
use pocketmine\item\VanillaItems;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\convert\TypeConverter;
use pocketmine\network\mcpe\protocol\MobEquipmentPacket;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataFlags;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataProperties;
use pocketmine\network\mcpe\protocol\types\inventory\ContainerIds;
use pocketmine\network\mcpe\protocol\types\inventory\ItemStackWrapper;
use pocketmine\player\Player;
use pocketmine\world\sound\BowShootSound;

class LightweightSkeleton extends LightweightUndead {

	private int $bowChargeTime = 0;

	protected float $attackDistance = 10;
	private MobEquipmentPacket $itemInHandPacket;

	public function __construct(Location $location, ?CompoundTag $nbt = null){
		parent::__construct($location, $nbt);
		$this->itemInHandPacket = MobEquipmentPacket::create($this->getId(), ItemStackWrapper::legacy(TypeConverter::getInstance()->coreItemStackToNet(VanillaItems::BOW())), 0, 0, ContainerIds::INVENTORY);
	}

	public function spawnTo(Player $player): void{
		parent::spawnTo($player);
		$player->getNetworkSession()->sendDataPacket($this->itemInHandPacket);
	}

	public static function getNetworkTypeId() : string{ return EntityIds::SKELETON; }

	protected function getInitialSizeInfo() : EntitySizeInfo{
		return new EntitySizeInfo(1.8, 0.6, 1.7); //TODO: eye height ??
	}

	public function getName() : string{
		return "Skeleton";
	}

	public function entityBaseTick(int $tickDiff = 1): bool{
		$this->attackTicker($tickDiff);
		return parent::entityBaseTick($tickDiff);
	}

	public function actionAttack(Entity $target): void{
		$this->actionAttackTime = 60;

		$this->bowCharged = false;
		$this->getNetworkProperties()->setGenericFlag(EntityMetadataFlags::TEMPTED, false);

		$baseForce = 0.7;
		$entity = new ArrowEntity(Location::fromObject(
			$this->getEyePos(),
			$this->getWorld(),
			($this->location->yaw > 180 ? 360 : 0) - $this->location->yaw,
			-$this->location->pitch
		), $this, $baseForce >= 1);
		$entity->setMotion($this->getDirectionVector());


		$ev = new EntityShootBowEvent($this, VanillaItems::BOW(), $entity, $baseForce * 3);

		$ev->call();

		$entity = $ev->getProjectile(); //This might have been changed by plugins

		if($ev->isCancelled()){
			$entity->flagForDespawn();
			return;
		}

		$entity->setMotion($entity->getMotion()->multiply($ev->getForce()));

		if($entity instanceof Projectile){
			$projectileEv = new ProjectileLaunchEvent($entity);
			$projectileEv->call();
			if($projectileEv->isCancelled()){
				$ev->getProjectile()->flagForDespawn();
				return;
			}

			$ev->getProjectile()->spawnToAll();
			$this->location->getWorld()->addSound($this->location, new BowShootSound());
		}else{
			$entity->spawnToAll();
		}
	}

}