<?php

declare(strict_types=1);

namespace Zinkil\Pandaz\tasks;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\scheduler\Task;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\CorePlayer;
use Zinkil\Pandaz\Utils;

class SetDayTask extends Task{
	
	public function __construct(Core $plugin){
		$this->plugin=$plugin;
	}
	public function onRun(int $currentTick):void{
		foreach($this->plugin->getServer()->getLevels() as $level){
			$level->setTime(1000);
			$level->stopTime();
		}
	}
}