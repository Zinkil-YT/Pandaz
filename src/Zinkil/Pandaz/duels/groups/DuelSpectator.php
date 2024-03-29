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

namespace Zinkil\Pandaz\duels\groups;

use pocketmine\level\Position;
use pocketmine\Player;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\Utils;

class DuelSpectator{
	
	private $name;
	private $boundingBox;

	public function __construct(Player $player){
		$this->name=$player->getName();
		$this->boundingBox=$player->getBoundingBox();
		$player->boundingBox->contract($player->width, 0, $player->height);
	}

	public function teleport(Position $pos):void{
		if($this->isOnline()){
			$p=$this->getPlayer()->getPlayer();
			$pl=$p->getPlayer();
			$pl->teleport($pos);
		}
	}

	public function resetPlayer(bool $disablePlugin=false):void{
		if($this->isOnline()){
			$p=$this->getPlayer()->getPlayer();
			$p->boundingBox=$this->boundingBox;
			Utils::sendPlayer($p, "lobby", true);
		}
	}

	public function getPlayer(){
		return Utils::getPlayer($this->name);
	}

	public function isOnline():bool{
		$p=$this->getPlayer();
		return !is_null($p) and $p->isOnline();
	}

	public function getPlayerName():string{
		return $this->name;
	}
}