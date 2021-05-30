<?php

declare(strict_types=1);

namespace Zinkil\Pandaz\tasks\onetime;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\CorePlayer;

class PearlTask extends Task{
	
	public $player;
	
	private $timer=11; //always set a second higher than what second you want
	
	public function __construct(Core $plugin, Player $player){
		$this->plugin=$plugin;
		$this->player=$player;
	}
	public function onRun(int $currentTick):void{
		$this->timer--;
		if($this->timer==10){
			$this->player->setEnderPearlCooldown(true);
			$this->player->sendPopup("§cPearl Cooldown Started");
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
			$this->player->sendPopup("§aPearl Cooldown Ended");
			$this->plugin->getScheduler()->cancelTask($this->getTaskId());
		}
	}
}