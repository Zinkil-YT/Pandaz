<?php

declare(strict_types=1);

namespace Zinkil\Pandaz\listeners;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\Player;
use Zinkil\Pandaz\Core;

class AntiAdvertisingListener implements Listener{

    private $plugin;

    private $links;

	public function __construct(Core $plugin){
		$this->plugin = $plugin;
        $this->links = [".leet.cc", ".playmc.pe", ".net", ".com", ".us", ".co", ".co.uk", ".ddns", ".ddns.net", ".cf", ".pe", ".me", ".cc", ".ru", ".eu", ".tk", ".gq", ".ga", ".ml", ".org", ".1", ".2", ".3", ".4", ".5", ".6", ".7", ".8", ".9", "my server", "my sever", "ma server", "mah server", "ma sever", "mah sever", "port", "default port"];
    }

    public function onChat(PlayerChatEvent $event) : void{
        $msg = $event->getMessage();
        $player = $event->getPlayer();
        if(!$player instanceof Player) return;
        if($player->hasPermission("Pandaz.bypass.advertising")){
        }else{
            foreach($this->links as $links){
                if(strpos($msg, $links) !== false){
                    $player->kick("§cDon't advertise servers here\n§fVia Anti-Advertising", false);
                    $event->setCancelled();
                    return;
                }
            }
        }
    }
}