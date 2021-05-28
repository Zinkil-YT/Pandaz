<?php

declare(strict_types=1);

namespace Zinkil\Pandaz\tasks;

use pocketmine\scheduler\Task;
use Zinkil\Pandaz\Core;

class MotdTask extends Task{
	
	public function __construct(Core $plugin){
		$this->plugin=$plugin;
		$this->line=-1;
	}
	public function onRun(int $tick):void{
		$motd=[
		"§l§bPANDAZ » §3On Top",
		"§l§eNEW » §aRushFFA",
		"§l§cEU » §fPractice"
		];
		$this->line++;
		$msg=$motd[$this->line];
		$this->plugin->getServer()->getNetwork()->setName($msg);
		if($this->line===count($motd) - 1){
			$this->line = -1;
		}
	}
}