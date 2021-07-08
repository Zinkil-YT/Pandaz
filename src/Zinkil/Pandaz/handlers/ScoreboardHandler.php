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

namespace Zinkil\Pandaz\handlers;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\CorePlayer;
use Zinkil\Pandaz\Utils;

class ScoreboardHandler{
	
	private $plugin;
	private $scoreboard=[];
	private $main=[];
	private $duel=[];
	private $spectator=[];
	private $ffa=[];

	public function __construct(){
		$this->plugin=Core::getInstance();
	}

	public function sendMainScoreboard($player, string $title="Pandaz"):void{
		$player=Utils::getPlayer($player);
		if(Utils::isScoreboardEnabled($player)==false){
			return;
		}
		if($this->isPlayerSetScoreboard($player)){
			$this->removeScoreboard($player);
		}
		$this->lineTitle($player, "§l§bPANDAZ§r");
		$this->lineCreate($player, 1, "§7------------------ ");
		$this->lineCreate($player, 2, "    ");
	    $this->lineCreate($player, 3, "§l§bQueued: §r§f".$this->plugin->getDuelHandler()->getNumberOfQueuedPlayers());
        $this->lineCreate($player, 4, "§l§bPlaying: §r§f".$this->plugin->getDuelHandler()->getNumberOfDuelsInProgress());
		$this->lineCreate($player, 5, "        ");
		$this->lineCreate($player, 6, "§7------------------");
		$this->scoreboard[$player->getName()]=$player->getName();
		$this->main[$player->getName()]=$player->getName();
	}

	public function sendFFAScoreboard($player):void{
        $player=Utils::getPlayer($player);
        if(Utils::isScoreboardEnabled($player)==false){
            return;
        }
        if($this->isPlayerSetScoreboard($player)){
            $this->removeScoreboard($player);
        }
        $this->lineTitle($player, "§l§bPANDAZ§r");
		$this->lineCreate($player, 1, "§7------------------ ");
		$this->lineCreate($player, 2, "    ");
		$this->lineCreate($player, 3, "§l§bK: §r§f".$this->plugin->getDatabaseHandler()->getKills($player)." §l§bD: §r§f".$this->plugin->getDatabaseHandler()->getDeaths($player));
        $this->lineCreate($player, 4, "§l§bKDR: §r§f".$this->plugin->getDatabaseHandler()->getKdr($player));
        $this->lineCreate($player, 5, "§l§bKillstreak: §r§f".$this->plugin->getDatabaseHandler()->getKillstreak($player)." §l§7(".$this->plugin->getDatabaseHandler()->getBestKillstreak($player).")");
		$this->lineCreate($player, 6, "        ");
		$this->lineCreate($player, 7, "§7------------------");
	}

	public function sendDuelScoreboard($player, string $type, string $queue, string $opponent):void{
		$player=Utils::getPlayer($player);
		if(Utils::isScoreboardEnabled($player)==false){
			return;
		}
		if($this->isPlayerSetScoreboard($player)){
			$this->removeScoreboard($player);
		}
		$this->lineTitle($player, "§l§bPANDAZ§r");
		$this->lineCreate($player, 1, "§7----------------- ");
		$this->lineCreate($player, 2, "    ");
		$this->lineCreate($player, 3, "§l§cFighting: §r§f".$opponent);
		$this->lineCreate($player, 4, "§l§aDuration: §r§f00:00");
		$this->lineCreate($player, 5, "        ");
		$this->lineCreate($player, 6, "§7-----------------");
		$this->scoreboard[$player->getName()]=$player->getName();
		$this->duel[$player->getName()]=$player->getName();
	}

	public function sendPartyDuelScoreboard($player, string $queue, int $alive, int $playing):void{
		$player=Utils::getPlayer($player);
		if(Utils::isScoreboardEnabled($player)==false){
			return;
		}
		if($this->isPlayerSetScoreboard($player)){
			$this->removeScoreboard($player);
		}
		$this->lineTitle($player, "§l§bPANDAZ§r");
		$this->lineCreate($player, 1, "§7----------------- ");
		$this->lineCreate($player, 2, "    ");
		$this->lineCreate($player, 3, "§l§bMode: §r§f".$queue);
		$this->lineCreate($player, 4, "§l§bAlive: §r§c".$alive."/".$playing);
		$this->lineCreate($player, 5, "§l§aDuration: §r§f00:00");
		$this->lineCreate($player, 6, "        ");
		$this->lineCreate($player, 7, "§7-----------------");
		$this->scoreboard[$player->getName()]=$player->getName();
		$this->duel[$player->getName()]=$player->getName();
	}

	public function sendBotDuelScoreboard($player, string $opponent):void{
		$player=Utils::getPlayer($player);
		if(Utils::isScoreboardEnabled($player)==false){
			return;
		}
		if($this->isPlayerSetScoreboard($player)){
			$this->removeScoreboard($player);
		}
		$this->lineTitle($player, "§l§bPANDAZ§r");
		$this->lineCreate($player, 1, "§7----------------- ");
		$this->lineCreate($player, 2, "    ");
		$this->lineCreate($player, 3, "§l§cType: §r§f".$opponent);
		$this->lineCreate($player, 4, "§l§aDuration: §r§f00:00");
		$this->lineCreate($player, 5, "        ");
		$this->lineCreate($player, 6, "§7-----------------");
		$this->scoreboard[$player->getName()]=$player->getName();
		$this->duel[$player->getName()]=$player->getName();
	}

	public function sendDuelSpectateScoreboard($player, string $type, string $queue, string $duelplayer, string $duelopponent):void{
		$player=Utils::getPlayer($player);
		if(Utils::isScoreboardEnabled($player)==false){
			return;
		}
		if($this->isPlayerSetScoreboard($player)){
			$this->removeScoreboard($player);
		}
		$this->lineTitle($player, "§l§bPANDAZ§r");
		$this->lineCreate($player, 1, "§7----------------- ");
		$this->lineCreate($player, 2, "    ");
		$this->lineCreate($player, 3, "§l§a".$type.": §r§f".$queue);
		$this->lineCreate($player, 4, "§l§b".$duelplayer." §r§fvs§c§l ".$duelopponent);
		$this->lineCreate($player, 5, "        ");
		$this->lineCreate($player, 6, "§7-----------------");
		$this->scoreboard[$player->getName()]=$player->getName();
		$this->spectator[$player->getName()]=$player->getName();
	}

	public function sendPartyDuelSpectateScoreboard($player, string $queue, string $leader):void{
		$player=Utils::getPlayer($player);
		if(Utils::isScoreboardEnabled($player)==false){
			return;
		}
		if($this->isPlayerSetScoreboard($player)){
			$this->removeScoreboard($player);
		}
		$this->lineTitle($player, "§l§bPANDAZ§r");
		$this->lineCreate($player, 1, "§7----------------- ");
		$this->lineCreate($player, 2, "    ");
		$this->lineCreate($player, 3, "§l§cMode: §r§f".$queue);
		$this->lineCreate($player, 4, "§l§aLeader: §r§f".$leader);
		$this->lineCreate($player, 5, "        ");
		$this->lineCreate($player, 6, "§7-----------------");
		$this->scoreboard[$player->getName()]=$player->getName();
		$this->spectator[$player->getName()]=$player->getName();
	}

	public function updateFFALineKillsDeaths($player){
		$player=Utils::getPlayer($player);
		if(Utils::isScoreboardEnabled($player)==false){
			return;
		}
		if($this->isPlayerSetScoreboard($player)){
			if($this->isPlayerSetFFA($player)){
				$this->lineRemove($player, 3);
						$this->lineCreate($player, 3, "§l§bK: §r§f".$this->plugin->getDatabaseHandler()->getKills($player)." §l§bD: §r§f".$this->plugin->getDatabaseHandler()->getDeaths($player));
			}
		}
	}

	public function updateFFALineKDR($player){
		$player=Utils::getPlayer($player);
		if(Utils::isScoreboardEnabled($player)==false){
			return;
		}
		if($this->isPlayerSetScoreboard($player)){
			if($this->isPlayerSetFFA($player)){
				$this->lineRemove($player, 4);
				$this->lineCreate($player, 4, "§l§bKDR: §r§f".$this->plugin->getDatabaseHandler()->getKdr($player));
			}
		}
	}

	public function updateFFALineKillstreak($player){
		$player=Utils::getPlayer($player);
		if(Utils::isScoreboardEnabled($player)==false){
			return;
		}
		if($this->isPlayerSetScoreboard($player)){
			if($this->isPlayerSetFFA($player)){
				$this->lineRemove($player, 5);
				$this->lineCreate($player, 5, "§l§bKillstreak: §r§f".$this->plugin->getDatabaseHandler()->getKillstreak($player)." §l§7(".$this->plugin->getDatabaseHandler()->getBestKillstreak($player).")");
			}
		}
	}

	public function updateBotDuelDuration($player, $duration){
		$player=Utils::getPlayer($player);
		if(Utils::isScoreboardEnabled($player)==false){
			return;
		}
		if($this->isPlayerSetScoreboard($player)){
			if($this->isPlayerSetDuel($player)){
				$this->lineRemove($player, 4);
				$this->lineCreate($player, 4, "§l§aDuration: §r§f".$duration);
			}
		}
	}

	public function updateDuelDuration($player, $duration){
		$player=Utils::getPlayer($player);
		if(Utils::isScoreboardEnabled($player)==false){
			return;
		}
		if($this->isPlayerSetScoreboard($player)){
			if($this->isPlayerSetDuel($player)){
				$this->lineRemove($player, 4);
				$this->lineCreate($player, 4, "§l§aDuration: §r§f".$duration);
			}
		}
	}

	public function updatePartyDuelAlive($player, $alive, $playing){
		$player=Utils::getPlayer($player);
		if(Utils::isScoreboardEnabled($player)==false){
			return;
		}
		if($this->isPlayerSetScoreboard($player)){
			if($this->isPlayerSetDuel($player)){
				$this->lineRemove($player, 4);
				$this->lineCreate($player, 4, "§l§bAlive: §r§c".$alive."/".$playing);
			}
		}
	}

	public function isPlayerSetScoreboard($player):bool{
		$name=Utils::getPlayerName($player);
		return ($name !== null) and isset($this->scoreboard[$name]);
	}

	public function isPlayerSetMain($player):bool{
		$name=Utils::getPlayerName($player);
		return ($name !== null) and isset($this->main[$name]);
	}

	public function isPlayerSetDuel($player):bool{
		$name=Utils::getPlayerName($player);
		return ($name !== null) and isset($this->duel[$name]);
	}

	public function isPlayerSetSpectator($player):bool{
		$name=Utils::getPlayerName($player);
		return ($name !== null) and isset($this->spectator[$name]);
	}

	public function isPlayerSetFFA($player):bool{
        $name=Utils::getPlayerName($player);
        return ($name !== null) and isset($this->ffa[$name]);
    }

	public function lineTitle($player, string $title){
		$player=Utils::getPlayer($player);
		if(Utils::isScoreboardEnabled($player)==false){
			return;
		}
		$packet=new SetDisplayObjectivePacket();
		$packet->displaySlot="sidebar";
		$packet->objectiveName="objective";
		$packet->displayName=$title;
		$packet->criteriaName="dummy";
		$packet->sortOrder=0;
		$player->sendDataPacket($packet);
	}

	public function removeScoreboard($player){
		$player=Utils::getPlayer($player);
		$packet=new RemoveObjectivePacket();
		$packet->objectiveName="objective";
		$player->sendDataPacket($packet);
		unset($this->scoreboard[$player->getName()]);
		unset($this->main[$player->getName()]);
		unset($this->duel[$player->getName()]);
		unset($this->spectator[$player->getName()]);
		unset($this->ffa[$player->getName()]);
	}

	public function lineCreate($player, int $line, string $content){
		$player=Utils::getPlayer($player);
		if(Utils::isScoreboardEnabled($player)==false){
			return;
		}
		$packetline=new ScorePacketEntry();
		$packetline->objectiveName="objective";
		$packetline->type=ScorePacketEntry::TYPE_FAKE_PLAYER;
		$packetline->customName=" ".$content;
		$packetline->score=$line;
		$packetline->scoreboardId=$line;
		$packet=new SetScorePacket();
		$packet->type=SetScorePacket::TYPE_CHANGE;
		$packet->entries[]=$packetline;
		$player->sendDataPacket($packet);
	}

	public function lineRemove($player, int $line){
		$player=Utils::getPlayer($player);
		if(Utils::isScoreboardEnabled($player)==false){
			return;
		}
		$entry=new ScorePacketEntry();
		$entry->objectiveName="objective";
		$entry->score=$line;
		$entry->scoreboardId=$line;
		$packet=new SetScorePacket();
		$packet->type=SetScorePacket::TYPE_REMOVE;
		$packet->entries[]=$entry;
		$player->sendDataPacket($packet);
	}
}