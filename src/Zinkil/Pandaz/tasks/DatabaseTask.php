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

namespace Zinkil\Pandaz\tasks;

use pocketmine\scheduler\Task;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\Utils;

class DatabaseTask extends Task{
	
	public function __construct(Core $plugin){
		$this->plugin=$plugin;
	}

	public function onRun(int $tick):void{
		if(Utils::getTimeByHour()=="19:00"){
			$queryA=Core::getInstance()->main->query("SELECT * FROM temporary ORDER BY dailykills DESC LIMIT 10;");
			$iA=0;
			while($resultArr=$queryA->fetchArray(SQLITE3_ASSOC)){
				$jA=$iA + 1;
				$player=$resultArr['player'];
				$valA=$this->plugin->getDatabaseHandler()->getDailyKills($player);
				$online=Utils::getPlayer($player);
				if($jA===1){
					$this->plugin->getLogger()->notice($player." has come in first with ".$valA." kills.");
					if($online!==null){
						$online->sendMessage("§aYou came in first on top daily kills.");
					}
				}
				if($jA===2){
					$this->plugin->getLogger()->notice($player." has come in second with ".$valA." kills.");
					if($online!==null){
						$online->sendMessage("§aYou came in second on top daily kills.");
					}
				}
				if($jA===3){
					$this->plugin->getLogger()->notice($player." has come in third with ".$valA." kills.");
					if($online!==null){
						$online->sendMessage("§aYou came in third on top daily kills.");
					}
				}
				++$iA;
			}
			$queryB=Core::getInstance()->main->query("SELECT * FROM temporary ORDER BY dailydeaths DESC LIMIT 10;");
			$iB=0;
			while($resultArr=$queryB->fetchArray(SQLITE3_ASSOC)){
				$jB=$iB + 1;
				$player=$resultArr['player'];
				$valB=$this->plugin->getDatabaseHandler()->getDailyDeaths($player);
				$online=Utils::getPlayer($player);
				if($jB===1){
					$this->plugin->getLogger()->notice($player." has come in first with ".$valB." deaths.");
					if($online!==null){
						$online->sendMessage("§aYou came in first on top daily deaths.");
					}
				}
				if($jB===2){
					$this->plugin->getLogger()->notice($player." has come in second with ".$valB." deaths.");
					if($online!==null){
						$online->sendMessage("§aYou came in second on top daily deaths.");
					}
				}
				if($jB===3){
					$this->plugin->getLogger()->notice($player." has come in third with ".$valB." deaths.");
					if($online!==null){
						$online->sendMessage("§aYou came in third on top daily deaths.");
					}
				}
				++$iB;
			}
			$this->plugin->main->query("DELETE FROM temporary;");
			$this->plugin->getLogger()->notice("Daily leaderboards have been reset, rewards were sent.");
		}
	}
}