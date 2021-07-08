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

namespace Zinkil\Pandaz\tasks;

use pocketmine\scheduler\Task;
use pocketmine\Player;
use pocketmine\entity\Creature;
use pocketmine\entity\projectile\Arrow;
use pocketmine\entity\projectile\EnderPearl;
use pocketmine\entity\projectile\SplashPotion;
use Zinkil\Pandaz\entities\{FastPotion, DefaultPotion, Pearl, Hook};
use Zinkil\Pandaz\bots\{EasyBot, MediumBot, HardBot, HackerBot};
use Zinkil\Pandaz\Core;

class DropsTask extends Task{
	
	public function __construct(Core $plugin){
		$this->plugin=$plugin;
	}

	public function onRun(int $tick):void{
		foreach($this->plugin->getServer()->getLevels() as $levels){
			foreach($levels->getEntities() as $entity){
				if(!$entity instanceof Player and !$entity instanceof Creature and !$entity instanceof EasyBot and !$entity instanceof MediumBot and !$entity instanceof HardBot and !$entity instanceof HackerBot and !$entity instanceof Arrow and !$entity instanceof EnderPearl and !$entity instanceof SplashPotion and !$entity instanceof Pearl and !$entity instanceof FastPotion and !$entity instanceof DefaultPotion and !$entity instanceof Hook){
					$entity->close();
				}
			}
		}
	}
}