<?php

declare(strict_types=1);

namespace Zinkil\Pandaz\tasks;

use pocketmine\scheduler\Task;
use Zinkil\Pandaz\Core;

class OnlineTask extends Task{
	
	public function __construct(Core $plugin){
		$this->plugin=$plugin;
	}
	public function onRun(int $tick):void{
		foreach($this->plugin->getServer()->getOnlinePlayers() as $online){
			$this->plugin->getScoreboardHandler()->updateMainLineOnline($online);
		}
	}
}