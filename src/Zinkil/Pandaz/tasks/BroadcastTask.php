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
use Zinkil\Pandaz\Core;

class BroadcastTask extends Task{
	
	public function __construct(Core $plugin){
		$this->plugin=$plugin;
		$this->line=-1;
	}

	public function onRun(int $tick):void{
		$cast=[
		$this->plugin->getCastPrefix()."Join our official discord at ".$this->plugin->getDiscord().".",
		$this->plugin->getCastPrefix()."If you want a Youtube rank (300+) or a Famous rank (800+) make a video on server and tell me in discord server ".$this->plugin->getDiscord().".",
		$this->plugin->getCastPrefix()."Check out our twitter, ".$this->plugin->getTwitter().".",
		$this->plugin->getCastPrefix()."Want to rekit you can use /rekit or enable auto rekit in settings.",
		$this->plugin->getCastPrefix()."Don't 2v1, Use glitches or share them, Abuse players and staff To not get banned."
		];
		$this->line++;
		$msg=$cast[$this->line];
		foreach($this->plugin->getServer()->getOnlinePlayers() as $online){
			$online->sendMessage($msg);
		}
		if($this->line===count($cast) - 1) $this->line = -1;
	}
}