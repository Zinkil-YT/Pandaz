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
use Zinkil\Pandaz\Utils;

class MatchedBotGroup{
	
	private $playerName;
	private $botName="Unknown";
	private $bot;
	private $difficulty;

	public function __construct($player, $bot, string $difficulty){
		$this->playerName=Utils::getPlayerName($player);
		if($bot!==null) $this->botName=$bot->getName();
		$this->difficulty=$difficulty;
		$this->bot=$bot;
	}

	public function getPlayerName():string{
		return $this->playerName;
	}

	public function getBotName():string{
		return $this->botName;
	}

	public function getPlayer(){
		return Utils::getPlayer($this->playerName);
	}

	public function getBot(){
		return $this->bot;
	}

    public function isPlayerOnline(){
        $player=$this->getOpponent();
        return !is_null($player) and $player->isOnline();
    }

    public function isBotOnline(){
        $bot=$this->getBot();
        return !is_null($this->bot) and $this->bot->isAlive();
    }

    public function getDifficulty():string{
    	return $this->difficulty;
    }

    public function equals($object):bool{
        return false;
    }
}