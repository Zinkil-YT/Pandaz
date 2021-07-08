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

namespace Zinkil\Pandaz\listeners;

use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\event\server\QueryRegenerateEvent;
use pocketmine\event\plugin\PluginDisableEvent;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\tasks\onetime\RestartTask;

class ServerListener implements Listener{
	
	public $plugin;
	
	public function __construct(Core $plugin){
		$this->plugin=$plugin;
	}

	public function onQuery(QueryRegenerateEvent $event){
        $event->setMaxPlayerCount(100);
	}

	public function onPluginDisable(PluginDisableEvent $event){
		$plugin=$event->getPlugin();
		if($plugin->getDescription()->getAuthors() !== ["Zinkil"] || $plugin->getDescription()->getName() !== "Pandaz"){
			foreach($this->plugin->getServer()->getOnlinePlayers() as $player){
				if($this->plugin->getDuelHandler()->isInDuel($player)){
					$duel=$this->plugin->getDuelHandler()->getDuel($player);
					$duel->endDuelPrematurely(true);
				}
				if($this->plugin->getDuelHandler()->isInPartyDuel($player)){
					$pduel=$this->plugin->getDuelHandler()->getPartyDuel($player);
					$pduel->endDuelPrematurely(true);
				}
			}
		}
	}
}