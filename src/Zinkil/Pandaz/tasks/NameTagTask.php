<?php

declare(strict_types=1);

namespace Zinkil\Pandaz\tasks;

use pocketmine\scheduler\Task;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\CorePlayer;
use Zinkil\Pandaz\Utils;
use Zinkil\Pandaz\handlers\ClickHandler;

class NameTagTask extends Task{
	
	public function __construct(Core $plugin){
		$this->plugin=$plugin;
	}
	public function onRun(int $tick):void{
		foreach($this->plugin->getServer()->getOnlinePlayers() as $player){
			if($player instanceof CorePlayer){
				$rank=$player->getRank();
			}else{
				$rank=$this->plugin->getDatabaseHandler()->getRank(Utils::getPlayerName($player));
			}
			$health=round($player->getHealth(), 1);
            $maxhealth=round($player->getMaxHealth());
			$ping=round($player->getPing(), 1);
			$os=$this->plugin->getPlayerOs($player);
			$cps=$this->plugin->getClickHandler()->getCps($player);
			$kills=$this->plugin->getDatabaseHandler()->getKills($player);
			if($this->plugin->getDuelHandler()->getDuel($player)===null and $this->plugin->getDuelHandler()->getPartyDuel($player)===null){
				$format=Utils::getNameTagFormat($rank);
				$format=str_replace("{name}", Utils::getPlayerDisplayName($player), $format);
				$format=str_replace("{hp}", $health, $format);
				$format=str_replace("{maxhp}", $maxhealth, $format);
				$format=str_replace("{ping}", $ping, $format);
				$format=str_replace("{os}", $os, $format);
				$format=str_replace("{cps}", $cps, $format);
				$format=str_replace("{kills}", $kills, $format);
				if(!$player->isDisguised()){
					if(!$player->isVanished()){
						$player->setNameTag($format);
					}else{
						$player->setNameTag("§7(V) ".$format);
					}
				}else{
					$default=Utils::getNameTagFormat("Player");
					$default=str_replace("{name}", Utils::getPlayerDisplayName($player), $default);
					$default=str_replace("{hp}", $health, $default);
					$default=str_replace("{maxhp}", $maxhealth, $default);
					$default=str_replace("{ping}", $ping, $default);
					$default=str_replace("{os}", $os, $default);
					$default=str_replace("{cps}", $cps, $default);
					$default=str_replace("{kills}", $kills, $default); 
					$player->setNameTag($default);
				}
			}
		}
	}
}