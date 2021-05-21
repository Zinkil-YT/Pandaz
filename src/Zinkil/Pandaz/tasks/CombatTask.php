<?php

declare(strict_types=1);

namespace Zinkil\Pandaz\tasks;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\scheduler\Task;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\CorePlayer;
use Zinkil\Pandaz\Utils;

class CombatTask extends Task{
	
	public function __construct(Core $plugin){
		$this->plugin=$plugin;
	}
	public function onRun(int $currentTick):void{
		foreach($this->plugin->taggedPlayer as $name => $time) {
			$player=$this->plugin->getServer()->getPlayerExact($name);
			$time--;
			if($player->isTagged()){
			}
			if($time<=0){
				$player->setTagged(false);
				return;
			}
			$this->plugin->taggedPlayer[$name]--;
		}
	}
}