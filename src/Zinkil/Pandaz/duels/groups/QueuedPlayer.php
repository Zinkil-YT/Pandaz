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

use pocketmine\Player;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\Utils;

class QueuedPlayer{
	
	private $name;
	private $queue;
	private $ranked;
	private $pe;
	
	public function __construct(string $name, string $queue, bool $ranked=false, bool $pe=false){
		$this->name=$name;
		$this->queue=$queue;
		$this->ranked=$ranked;
		$this->pe=$pe;
	}

	public function getPlayerName():string{
		return $this->name;
	}

	public function getQueue():string{
		return $this->queue;
	}

	public function isRanked():bool{
		return $this->ranked;
	}

	public function isPe():bool{
		return $this->pe;
	}

	public function getPlayer(){
		return Utils::getPlayer($this->name);
	}

	public function isPlayerOnline():bool{
		return !is_null($this->getPlayer()) and $this->getPlayer()->isOnline();
	}

	public function hasSameQueue(QueuedPlayer $player):bool{
		$result=false;
		if($player->getQueue()===$this->queue){
			$ranked=$player->isRanked();
			$result=$this->ranked===$ranked;
		}
		return $result;
	}

	public function equals($object):bool{
		$result=false;
		if($object instanceof QueuedPlayer){
			if($object->getPlayerName()===$this->name){
				$result=true;
			}
		}
		return $result;
	}
}