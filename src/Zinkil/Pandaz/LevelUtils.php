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

namespace Zinkil\Pandaz;

use pocketmine\Player;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\CorePlayer;
use Zinkil\Pandaz\Utils;

class LevelUtils{
	
	public static function increaseLevel($player){
		if(!$player instanceof CorePlayer) return;
		Core::getInstance()->getDatabaseHandler()->setLevel(Utils::getPlayerName($player), Core::getInstance()->getDatabaseHandler()->getLevel(Utils::getPlayerName($player)) + 1);
		$level=Core::getInstance()->getDatabaseHandler()->getLevel(Utils::getPlayerName($player));
		$player=Utils::getPlayer($player);
		if($player instanceof Player){
			$player->sendMessage("§3You are now level §b".$level."§3!");
		}
	}
	public static function increaseCurrentXp($player, $reason, $ranked=false, $xpday=false){
		if(!$player instanceof CorePlayer) return;
		$rank=Core::getInstance()->getDatabaseHandler()->getRank(Utils::getPlayerName($player));
		switch($reason){
			case "kill":
			$rand=mt_rand(20, 30);
			$kill=$rand;
			$boost=0;
			$rankedbonus=0;
			if($rank=="Voter" or Core::getInstance()->getDatabaseHandler()->voteAccessExists($player)){
				$boost=6;
			}
			if($rank=="VIP"){
				$boost=8;
			}
			if($rank=="Elite"){
				$boost=10;
			}
			if($rank=="Premium"){
				$boost=13;
			}
			if($rank=="Booster"){
				$boost=11;
			}
			if($rank=="Youtube" or $rank=="Famous"){
				$boost=4;
			}
			if($rank=="Trainee" or $rank=="Helper" or $rank=="Mod" or $rank=="HeadMod"){
				$boost=8;
			}
			if($rank=="Admin" or $rank=="Manager" or $rank=="Owner"){
				$boost=12;
			}
			if($ranked===true){
				$rankedbonus=mt_rand(12, 18);
			}else{
				$rankedbonus=0;
			}
			if($xpday===true){
				$kill=$rand * 2;
			}else{
				$kill=$rand;
			}
			$total=$kill + $boost + $rankedbonus;
			$level=Core::getInstance()->getDatabaseHandler()->getLevel(Utils::getPlayerName($player));
			$neededxp=Core::getInstance()->getDatabaseHandler()->getNeededXp(Utils::getPlayerName($player));
			$currentxp=Core::getInstance()->getDatabaseHandler()->getCurrentXp(Utils::getPlayerName($player));
			$totalxp=Core::getInstance()->getDatabaseHandler()->getTotalXp(Utils::getPlayerName($player));
			if($level>=246){
				Core::getInstance()->getDatabaseHandler()->setTotalXp(Utils::getPlayerName($player), $totalxp + $total);
			}else{
				Core::getInstance()->getDatabaseHandler()->setCurrentXp(Utils::getPlayerName($player), $currentxp + $total);
				Core::getInstance()->getDatabaseHandler()->setTotalXp(Utils::getPlayerName($player), $totalxp + $total);
			}
			$currentxpnew=Core::getInstance()->getDatabaseHandler()->getCurrentXp(Utils::getPlayerName($player));
			$progress=round($currentxpnew / $neededxp * 100, 1);
			$pc='%';
			$player=Utils::getPlayer($player);
			if($player instanceof Player){
				if($level>=246){
					$player->sendMessage("§aLevel Progress: ".Utils::formatLevel($level)." §7- MAX");
					return;
				}
				if($currentxpnew>=$neededxp){
					$player->sendMessage("§aLevel Progress: ".Utils::formatLevel($level)." §7- ".$neededxp."/".$neededxp." (100".$pc.")");
				}else{
					$player->sendMessage("§aLevel Progress: ".Utils::formatLevel($level)." §7- ".$currentxpnew."/".$neededxp." (".$progress.$pc.")");
				}
			}
			break;
			case "death":
			$rand=mt_rand(10, 20);
			$death=$rand;
			$boost=0;
			$rankedbonus=0;
			if($rank=="Voter" or Core::getInstance()->getDatabaseHandler()->voteAccessExists($player)){
				$boost=3;
			}
			if($rank=="VIP"){
				$boost=4;
			}
			if($rank=="Elite"){
				$boost=5;
			}
			if($rank=="Premium"){
				$boost=6;
			}
			if($rank=="Booster"){
				$boost=5;
			}
			if($rank=="Youtube" or $rank=="Famous"){
				$boost=4;
			}
			if($rank=="Trainee" or $rank=="Helper" or $rank=="Mod" or $rank=="HeadMod"){
				$boost=4;
			}
			if($rank=="Admin" or $rank=="Manager" or $rank=="Owner"){
				$boost=6;
			}
			if($ranked===true){
				$rankedbonus=mt_rand(3, 10);
			}else{
				$rankedbonus=0;
			}
			if($xpday===true){
				$death=$rand * 2;
			}else{
				$death=$rand;
			}
			$total=$death + $boost + $rankedbonus;
			$level=Core::getInstance()->getDatabaseHandler()->getLevel(Utils::getPlayerName($player));
			$neededxp=Core::getInstance()->getDatabaseHandler()->getNeededXp(Utils::getPlayerName($player));
			$currentxp=Core::getInstance()->getDatabaseHandler()->getCurrentXp(Utils::getPlayerName($player));
			$totalxp=Core::getInstance()->getDatabaseHandler()->getTotalXp(Utils::getPlayerName($player));
			if($level>=146){
				Core::getInstance()->getDatabaseHandler()->setTotalXp(Utils::getPlayerName($player), $totalxp - $total);
			}else{
				Core::getInstance()->getDatabaseHandler()->setCurrentXp(Utils::getPlayerName($player), $currentxp - $total);
				Core::getInstance()->getDatabaseHandler()->setTotalXp(Utils::getPlayerName($player), $totalxp - $total);
			}
			$currentxpnew=Core::getInstance()->getDatabaseHandler()->getCurrentXp(Utils::getPlayerName($player));
			$progress=round($currentxpnew / $neededxp * 100, 1);
			$pc='%';
			$player=Utils::getPlayer($player);
			if($player instanceof Player){
				if($level>=246){
					$player->sendMessage("§cLevel Progress: ".Utils::formatLevel($level)." §7- MAX");
					return;
				}
				if($currentxpnew>=$neededxp){
					$player->sendMessage("§cLevel Progress: ".Utils::formatLevel($level)." §7- ".$neededxp."/".$neededxp." (100".$pc.")");
				}else{
					$player->sendMessage("§cLevel Progress: ".Utils::formatLevel($level)." §7- ".$currentxpnew."/".$neededxp." (".$progress.$pc.")");
				}
			}
			break;
			default:
			return;
		}
	}
	public static function handleXp($player){
		if(!$player instanceof CorePlayer) return;
		$level=Core::getInstance()->getDatabaseHandler()->getLevel(Utils::getPlayerName($player));
		$neededxp=Core::getInstance()->getDatabaseHandler()->getNeededXp(Utils::getPlayerName($player));
		if($level>=1){
			$mby=1.05;
			Core::getInstance()->getDatabaseHandler()->setNeededXp(Utils::getPlayerName($player), round($neededxp * $mby, 0));
			Core::getInstance()->getDatabaseHandler()->setCurrentXp(Utils::getPlayerName($player), 0);
		}
		if($level>=146){
			$mby=1.05;
			Core::getInstance()->getDatabaseHandler()->setNeededXp(Utils::getPlayerName($player), round($neededxp * $mby, 0));
			Core::getInstance()->getDatabaseHandler()->setCurrentXp(Utils::getPlayerName($player), 0);
		}
	}
	public static function checkXp($player){
		if(!$player instanceof CorePlayer) return;
		$leveledup=false;
		$currentxp=Core::getInstance()->getDatabaseHandler()->getCurrentXp(Utils::getPlayerName($player));
		$neededxp=Core::getInstance()->getDatabaseHandler()->getNeededXp(Utils::getPlayerName($player));
		if($currentxp>=$neededxp){
			self::increaseLevel($player);
			self::handleXp($player);
		}else{
			return;
		}
	}
}