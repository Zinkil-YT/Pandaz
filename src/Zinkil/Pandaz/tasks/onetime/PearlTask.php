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

namespace Zinkil\Pandaz\tasks\onetime;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\CorePlayer;

class PearlTask extends Task{
	
	public $player;
	
	private $timer=11;
	
	public function __construct(Core $plugin, Player $player){
		$this->plugin=$plugin;
		$this->player=$player;
	}

	public function onRun(int $currentTick):void{
		$this->timer--;
		if($this->timer==10){
			$this->player->setEnderPearlCooldown(true);
			$this->player->sendPopup("§cCooldown Started");
			$percent=floatval($this->timer / 10);
			$this->player->setXpProgress($percent);
		}
		if($this->timer<10){
			$percent=floatval($this->timer / 10);
			$this->player->setXpProgress($percent);
		}
		if($this->timer==0){
			$this->player->setXpProgress(0.0);
			$this->player->setEnderPearlCooldown(false);
			$this->player->sendPopup("§aCooldown Ended");
			$this->plugin->getScheduler()->cancelTask($this->getTaskId());
		}
	}
}