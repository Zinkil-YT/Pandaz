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

class WelcomeTask extends Task{
	
	public $player;
	
	private $timer=5;
	
	public function __construct(Core $plugin, Player $player){
		$this->plugin=$plugin;
		$this->player=$player;
	}

	public function onRun(int $currentTick):void{
		$this->timer--;
		if($this->timer==0){
			$this->player->addTitle("§bPandaz", "§fPractice", 20, 60, 40);
			$this->plugin->getScheduler()->cancelTask($this->getTaskId());
		}
	}
}