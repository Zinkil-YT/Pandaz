<?php

declare(strict_types=1);

namespace Zinkil\Pandaz\tasks\onetime;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\CorePlayer;

class RestartTask extends Task{
	
	private $plugin;
	
	public function __construct(Core $plugin){
		$this->plugin=$plugin;
	}
	public function onRun(int $currentTick):void{
		$count=count($this->plugin->getServer()->getOnlinePlayers());
		if($count > 0){
			foreach($this->plugin->getServer()->getOnlinePlayers() as $player){
				if($this->plugin->getDuelHandler()->isInDuel($player)){
					$duel=$this->plugin->getDuelHandler()->getDuel($player);
					$duel->endDuelPrematurely(true);
				}
				$player->kick("§bServer is restarting.", false);
			}
		}else{
			$this->plugin->getServer()->shutdown();
		}
	}
}