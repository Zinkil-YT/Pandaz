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

namespace Zinkil\Pandaz\items;

use pocketmine\entity\Entity;
use pocketmine\item\Durable;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\AnimatePacket;
use pocketmine\Player;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\CorePlayer;
use Zinkil\Pandaz\Utils;

class Rod extends Durable{
	
	public function __construct($meta=0){
		parent::__construct(Item::FISHING_ROD, $meta, "Fishing Rod");
	}

	public function getMaxStackSize():int{
		return 1;
	}

	public function getCooldownTicks():int{
		return 5;
	}

	public function getMaxDurability():int{
		return 355;
	}

	public function onClickAir(Player $player, Vector3 $directionVector):bool{
		if(!$player->hasItemCooldown($this)){
			$player->resetItemCooldown($this);
			
			if($player->getFishing()===null){
				$motion=$player->getDirectionVector();
				$motion=$motion->multiply(0.4);
				$nbt=Entity::createBaseNBT($player->add(0, $player->getEyeHeight(), 0), $motion);
				$hook=Entity::createEntity("FishingHook", $player->level, $nbt, $player);
				$hook->spawnToAll();
			}else{
				$hook=$player->getFishing();
				if(!is_null($hook)) $hook->flagForDespawn();
				$player->stopFishing();
			}
			$player->broadcastEntityEvent(AnimatePacket::ACTION_SWING_ARM);
			return true;
		}
		return false;
	}

	public function getProjectileEntityType():string{
		return "Hook";
	}

	public function getThrowForce():float{
		return 0.9;
	}
}