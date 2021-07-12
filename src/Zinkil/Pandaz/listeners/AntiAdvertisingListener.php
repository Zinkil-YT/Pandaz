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
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\Player;
use Zinkil\Pandaz\Core;

class AntiAdvertisingListener implements Listener{

    private $plugin;

    private $links;

	public function __construct(Core $plugin){
		$this->plugin = $plugin;
        $this->links = [".leet.cc", ".playmc.pe", ".net", ".com", "play.", ".us", ".co", ".co.uk", ".ddns", ".ddns.net", ".cf", ".pe", ".me", ".cc", ".ru", ".eu", ".tk", ".gq", ".ga", ".ml", ".org", ".club", ".pro", "com", "net", "ddns", "org", "19132"];
    }

    public function onChat(PlayerChatEvent $event) : void{
        $msg = $event->getMessage();
        $player = $event->getPlayer();
        if($player instanceof Player){
            if($player->hasPermission("Pandaz.bypass.advertising")){
                return;
            }else{
                foreach($this->links as $links){
                    if(strpos($msg, $links) !== false){
                        $event->setCancelled();
                        return;
                    }
                }
            }
        }
    }
}