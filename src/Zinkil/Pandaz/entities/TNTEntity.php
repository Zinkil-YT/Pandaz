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

namespace Zinkil\Pandaz\entities;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\entity\object\PrimedTNT;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\entity\Explosive;
use pocketmine\level\Explosion;
use pocketmine\entity\Entity;
use pocketmine\entity\{EffectInstance, Effect};
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\level\{Position, Level};
use pocketmine\nbt\tag\ShortTag;
use pocketmine\math\AxisAlignedBB;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\level\utils\SubChunkIteratorManager;
use Zinkil\Pandaz\Core;

class TNTEntity extends PrimedTNT{

	public function __construct(){
		$this->plugin = Core::getInstance();
	}

    public function entityBaseTick(int $tickDiff=1):bool{
        $this->setNameTag("§l§c» §b".$this->fuse." §l§c«");
        $this->setNameTagVisible();
        $this->setNameTagAlwaysVisible();
        return parent::entityBaseTick($tickDiff);
    }

	public function explode():void{
	    $ev = new ExplosionPrimeEvent($this, 4);
		$ev->call();
		if(!$ev->isCancelled()){
			$explosion = new Explosion(Position::fromObject($this->add(0, $this->height / 2, 0), $this->level), $ev->getForce(), $this);
			if($ev->isBlockBreaking()){
				$explosion->explodeA();
			}
			$explosion->explodeB();
		}
	}
}