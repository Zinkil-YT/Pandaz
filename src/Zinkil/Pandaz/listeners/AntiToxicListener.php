<?php

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
        $this->toxicwords = ["l", "ez", "noob", "trash", "owned", "L", "EZ", "NOOB", "TRASH", "OWNED"];
    }

    public function onChat(PlayerChatEvent $event) : void{
        $msg = $event->getMessage();
        $player = $event->getPlayer();
        if(!$player instanceof Player) return;
        if($player->hasPermission("Pandaz.bypass.toxic")){
        }else{
            foreach($this->toxicwords as $toxicwords){
                if(strpos($msg, $toxicwords) !== false){
                    $player->kick("§cDon't be toxic\n§fVia Anti-Toxic", false);
                    $event->setCancelled();
                    return;
                }
            }
        }
    }
}