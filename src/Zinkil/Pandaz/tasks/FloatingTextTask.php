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

use pocketmine\math\Vector3;
use pocketmine\scheduler\Task;
use Zinkil\Pandaz\Core;

class FloatingTextTask extends Task{
	
	private $plugin;
	
	public function __construct(Core $plugin){
		$this->plugin=$plugin;
	}

	public function onRun(int $tick):void{
		foreach($this->plugin->getServer()->getOnlinePlayers() as $player){
			foreach($this->plugin->updatingFloatingTexts as $id => $ft){
				$title=$this->plugin->getUpdatingFloatingTexts()->getNested("$id.title");
				$text=$this->plugin->getUpdatingFloatingTexts()->getNested("$id.text");
				$level=$this->plugin->getServer()->getLevelByName($this->plugin->getUpdatingFloatingTexts()->getNested("$id.level"));
				$ft->setTitle($this->plugin->replaceProcess($player, $title));
				$ft->setText($this->plugin->replaceProcess($player, $text));
				$level->addParticle($ft, [$player]);
			}
		}
	}
}