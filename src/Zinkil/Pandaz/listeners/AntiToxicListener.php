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

class AntiToxicListener implements Listener{

    private $plugin;

    private $toxicwords;

    public function __construct(Core $plugin){
		$this->plugin = $plugin;
        $this->toxicwords = ["ez", "noob", "trash", "owned", "clapped", "clown", "stupid", "dumb", "EZ", "NOOB", "TRASH", "OWNED", "CLAPPED", "CLOWN", "STUPID", "DUMB"];
    }

    public function onChat(PlayerChatEvent $event) : void{
        $msg = $event->getMessage();
        $player = $event->getPlayer();
        if($player instanceof Player){
            if($player->hasPermission("Pandaz.bypass.toxic")){
                return;
            }else{
                foreach($this->toxicwords as $toxicwords){
                    if(strpos($msg, $toxicwords) !== false){
                        $event->setCancelled();
                        return;
                    }
                }
            }
        }
    }
}