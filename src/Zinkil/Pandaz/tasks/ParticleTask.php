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
use pocketmine\level\particle\FlameParticle;
use Zinkil\Pandaz\Core;

class ParticleTask extends Task{
	
	public function __construct(Core $plugin){
		$this->plugin=$plugin;
	}

	public function onRun(int $tick):void{
		$players=$this->plugin->getServer()->getOnlinePlayers();
		foreach($players as $player){
			$player->getlevel()->addParticle(new FlameParticle($player->asVector3()->add(0, 0, 0)), $player->getLevel()->getPlayers());
			$player->getlevel()->addParticle(new FlameParticle($player->asVector3()->add(0, 0.8, 0)), $player->getLevel()->getPlayers());
			$player->getlevel()->addParticle(new FlameParticle($player->asVector3()->add(0, 1.8, 0)), $player->getLevel()->getPlayers());
		}
		$this->plugin->getScheduler()->cancelTask($this->getTaskId());
	}
}