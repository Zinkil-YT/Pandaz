<?php

/**

███████╗ ██╗ ███╗  ██╗ ██╗  ██╗ ██╗ ██╗
╚════██║ ██║ ████╗ ██║ ██║ ██╔╝ ██║ ██║
  ███╔═╝ ██║ ██╔██╗██║ █████═╝  ██║ ██║
██╔══╝   ██║ ██║╚████║ ██╔═██╗  ██║ ██║
███████╗ ██║ ██║ ╚███║ ██║ ╚██╗ ██║ ███████╗
╚══════╝ ╚═╝ ╚═╝  ╚══╝ ╚═╝  ╚═╝ ╚═╝ ╚══════╝

CopyRight : Zinkil-YT :)
Github : https://github.com/Zinkil-YT
Youtube : https://www.youtube.com/channel/UCW1PI028SEe2wi65w3FYCzg
Discord Account : Zinkil#2006
Discord Server : https://discord.gg/2zt7P5EUuN

 */

declare(strict_types=1);

namespace Zinkil\Pandaz\listeners;

use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\BlockBurnEvent;
use pocketmine\event\block\BlockFormEvent;
use pocketmine\event\block\LeavesDecayEvent;
use pocketmine\event\block\BlockSpreadEvent;
use pocketmine\event\inventory\InventoryOpenEvent;
use pocketmine\inventory\ChestInventory;
use pocketmine\event\player\PlayerBucketEmptyEvent;
use pocketmine\event\player\PlayerBucketFillEvent;
use pocketmine\block\Dirt;
use pocketmine\block\Liquid;
use pocketmine\block\Anvil;
use pocketmine\block\Bed;
use pocketmine\block\BrewingStand;
use pocketmine\block\BurningFurnace;
use pocketmine\block\Button;
use pocketmine\block\Chest;
use pocketmine\block\CraftingTable;
use pocketmine\block\Door;
use pocketmine\block\EnchantingTable;
use pocketmine\block\EnderChest;
use pocketmine\block\FenceGate;
use pocketmine\block\Furnace;
use pocketmine\block\IronDoor;
use pocketmine\block\IronTrapDoor;
use pocketmine\block\Lever;
use pocketmine\block\TrapDoor;
use pocketmine\block\TrappedChest;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\inventory\PlayerInventory;
use pocketmine\event\inventory\InventoryTransactionEvent;
use Zinkil\Pandaz\Core;

class WorldListener implements Listener{
	
	public $plugin;
	
	protected $opened;
	
	public function __construct(Core $plugin){
		$this->plugin=$plugin;
		$this->opened=[];
	}

	public function onSlotChange(InventoryTransactionEvent $event){
		$item=null;
		$player=null;
		$transaction=$event->getTransaction();
		$player=$transaction->getSource();
		$level=$player->getLevel()->getName();
		if($level==$this->plugin->getLobby() or $level=="buildffa"){
			$event->setCancelled();
		}
	}

	public function onInteract(PlayerInteractEvent $event){
		$player=$event->getPlayer();
		$block=$event->getBlock();
		$item=$event->getItem();
		if($block instanceof Anvil or $block instanceof Bed or $block instanceof BrewingStand or $block instanceof BurningFurnace or $block instanceof Button or $block instanceof Chest or $block instanceof CraftingTable or $block instanceof Door or $block instanceof EnchantingTable or $block instanceof EnderChest or $block instanceof FenceGate or $block instanceof Furnace or $block instanceof IronDoor or $block instanceof IronTrapDoor or $block instanceof Lever or $block instanceof TrapDoor or $block instanceof TrappedChest){
			$event->setCancelled();
		}
	}

	public function onLevelChange(EntityLevelChangeEvent $event){
		$player=$event->getEntity();
		if(!$player instanceof Player) return;
		if($player->getGamemode()===Player::CREATIVE) return;
		$duel=null;
		if($this->plugin->getDuelHandler()->isInDuel($player)) $duel=$this->plugin->getDuelHandler()->getDuel($player);
		if($this->plugin->getDuelHandler()->isInBotDuel($player)) $duel=$this->plugin->getDuelHandler()->getBotDuel($player);
		if($duel===null) return;
		if($duel->isDuelRunning()){
			$event->setCancelled();
		}
		$level=$player->getLevel()->getName();
		if($level!=="lobby"){
			$player->setFlying(false);
			$player->setAllowFlight(false);
			$player->setScale(1);
		}
	}

	public function onLeaveDecay(LeavesDecayEvent $event){
		$block=$event->getBlock();
		$level=$block->getLevel()->getName();
		$event->setCancelled();
	}

	public function onBurn(BlockBurnEvent $event){
		$block=$event->getBlock();
		$level=$block->getLevel()->getName();
		$event->setCancelled();
	}

	public function onPlace(BlockPlaceEvent $event){
		$player=$event->getPlayer();
		$block=$event->getBlock();
		$level=$player->getLevel()->getName();
		if($this->plugin->getDuelHandler()->isInDuel($player)){
			$duel=$this->plugin->getDuelHandler()->getDuel($player);
			if($duel!==null and $duel->isDuelRunning() and $duel->canBuild()){
				$toohigh=$duel->isBlockTooHigh($block->getY());
				if($toohigh===false){
					$duel->addBlock($block->getX(), $block->getY(), $block->getZ());
				}else{
					$event->setCancelled();
				}
			}else{
				$event->setCancelled();
			}
			return;
		}
		if($this->plugin->getDuelHandler()->isInPartyDuel($player)){
			$pduel=$this->plugin->getDuelHandler()->getPartyDuel($player);
			if($pduel!==null and $pduel->isDuelRunning() and $pduel->canBuild()){
				$toohigh=$pduel->isBlockTooHigh($block->getY());
				if($toohigh===false){
					$pduel->addBlock($block->getX(), $block->getY(), $block->getZ());
				}else{
					$event->setCancelled();
				}
			}else{
				$event->setCancelled();
			}
			return;
		}
		if($level!=="buildffa"){
			$event->setCancelled();
		}
	}

	public function onBreak(BlockBreakEvent $event){
		$player=$event->getPlayer();
		$block=$event->getBlock();
		$level=$player->getLevel()->getName();
		$vector3=new Vector3($block->getX(), $block->getY(), $block->getZ());
		if($this->plugin->getDuelHandler()->isInDuel($player)){
			$duel=$this->plugin->getDuelHandler()->getDuel($player);
			if($duel!==null and $duel->isDuelRunning() and $duel->canBuild()){
				if($duel->isBedwars()){
					if($duel->removeBlock($block->getX(), $block->getY(), $block->getZ())===false){
						$event->setCancelled();
					}else{
						if($block instanceof Bed){
							$event->setDrops([]);
							$duel->addBed($vector3);
						}
						if(in_array($vector3, $duel->blocks)) $duel->removeBlock($block->getX(), $block->getY(), $block->getZ());
					}
				}else{
					if($duel->removeBlock($block->getX(), $block->getY(), $block->getZ())===false){
						$event->setCancelled();
					}else{
						if(in_array($vector3, $duel->blocks)) $duel->removeBlock($block->getX(), $block->getY(), $block->getZ());
					}
				}
			}else{
				$event->setCancelled();
			}
			return;
		}
		if($this->plugin->getDuelHandler()->isInPartyDuel($player)){
			$pduel=$this->plugin->getDuelHandler()->getPartyDuel($player);
			if($pduel!==null and $pduel->isDuelRunning() and $pduel->canBuild()){
				if($pduel->removeBlock($block->getX(), $block->getY(), $block->getZ())===false){
					$event->setCancelled();
				}else{
					if(in_array($vector3, $pduel->blocks)) $pduel->removeBlock($block->getX(), $block->getY(), $block->getZ());
				}
			}else{
				$event->setCancelled();
			}
			return;
		}
		if(!$player->hasPermission("Pandaz.can.break") or !$player->isOp()){
			$event->setCancelled();
		}
	}

	public function onBlockSpread(BlockSpreadEvent $event):void{
		$state=$event->getNewState();
		$block=$event->getBlock();
		$arena=$this->plugin->getArenaHandler()->getArenaClosestTo($block);
		if($arena===null){
			$event->setCancelled();
			return;
		}
		$this->plugin->getDuelHandler()->isArenaInUse($arena->getName());
		$duel=$this->plugin->getDuelHandler()->getDuel($arena->getName(), true);
		$pduel=$this->plugin->getDuelHandler()->getPartyDuel($arena->getName(), true);
		if($duel!==null){
			if($duel->isDuelRunning()){
				$duel->addBlock($block->getX(), $block->getY(), $block->getZ());
			}else{
				$event->setCancelled();
			}
		}
		if($pduel!==null){
			if($pduel->isDuelRunning()){
				$pduel->addBlock($block->getX(), $block->getY(), $block->getZ());
			}else{
				$event->setCancelled();
			}
		}
	}

	public function onBlockForm(BlockFormEvent $event):void{
		$state=$event->getNewState();
		$block=$event->getBlock();
		$arena=$this->plugin->getArenaHandler()->getArenaClosestTo($block);
		if($state instanceof Dirt){
			$event->setCancelled();
			return;
		}
		if($arena===null){
			$event->setCancelled();
			return;
		}
		$this->plugin->getDuelHandler()->isArenaInUse($arena->getName());
		$duel=$this->plugin->getDuelHandler()->getDuel($arena->getName(), true);
		$pduel=$this->plugin->getDuelHandler()->getPartyDuel($arena->getName(), true);
		if($duel!==null){
			if($duel->isDuelRunning()){
				$duel->addBlock($block->getX(), $block->getY(), $block->getZ());
			}else{
				$event->setCancelled();
			}
		}
		if($pduel!==null){
			if($pduel->isDuelRunning()){
				$pduel->addBlock($block->getX(), $block->getY(), $block->getZ());
			}else{
				$event->setCancelled();
			}
		}
	}

	public function onBucketFill(PlayerBucketFillEvent $event):void{
		$player=$event->getPlayer();
		$block=$event->getBlockClicked();
		$item=$event->getItem();
		$level=$player->getLevel()->getName();
		if($level==$this->plugin->getLobby()){
			if(!$player->isCreative()){
				$event->setCancelled();
			}
		}
		if($this->plugin->getDuelHandler()->isInDuel($player)){
			$duel=$this->plugin->getDuelHandler()->getDuel($player);
			if($duel!==null and $duel->isDuelRunning() and $duel->canBuild()){
					$duel->removeBlock($block->getX(), $block->getY(), $block->getZ());
			}else{
				$event->setCancelled();
			}
			return;
		}
		if($this->plugin->getDuelHandler()->isInPartyDuel($player)){
			$pduel=$this->plugin->getDuelHandler()->getPartyDuel($player);
			if($pduel!==null and $pduel->isDuelRunning() and $pduel->canBuild()){
				$pduel->removeBlock($block->getX(), $block->getY(), $block->getZ());
			}else{
				$event->setCancelled();
			}
			return;
		}
	}

	public function onBucketEmpty(PlayerBucketEmptyEvent $event):void{
		$player=$event->getPlayer();
		$block=$event->getBlockClicked();
		$item=$event->getItem();
		$level=$player->getLevel()->getName();
		if($level==$this->plugin->getLobby()){
			if(!$player->isCreative()){
				$event->setCancelled();
			}
		}
		if($this->plugin->getDuelHandler()->isInDuel($player)){
			$duel=$this->plugin->getDuelHandler()->getDuel($player);
			if($duel!==null and $duel->isDuelRunning() and $duel->canBuild()){
				$toohigh=$duel->isBlockTooHigh($block->getY());
				if($toohigh===false){
					$duel->addBlock($block->getX(), $block->getY(), $block->getZ());
				}else{
					$event->setCancelled();
				}
			}else{
				$event->setCancelled();
			}
			return;
		}
		if($this->plugin->getDuelHandler()->isInPartyDuel($player)){
			$pduel=$this->plugin->getDuelHandler()->getPartyDuel($player);
			if($pduel!==null and $pduel->isDuelRunning() and $pduel->canBuild()){
				$toohigh=$pduel->isBlockTooHigh($block->getY());
				if($toohigh===false){
					$pduel->addBlock($block->getX(), $block->getY(), $block->getZ());
				}else{
					$event->setCancelled();
				}
			}else{
				$event->setCancelled();
			}
			return;
		}
	}
}