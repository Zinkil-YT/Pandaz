<?php

declare(strict_types=1);

namespace Zinkil\Pandaz\listeners;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\Player;
use Zinkil\Pandaz\Core;

class AntiSwearingListener implements Listener{

    private $plugin;

    private $badwords;

    public function __construct(Core $plugin){
		$this->plugin = $plugin;
        $this->badwords = ["anal", "anus", "ass", "bastard", "bitch", "boob", "cock", "cum", "cunt", "dick", "dildo", "dyke", "fag", "faggot", "fuck", "fuk", "fk", "hoe", "tits", "whore", "handjob", "homo", "jizz", "cunt", "kike", "kunt", "muff", "nigger", "penis", "piss", "poop", "pussy", "queer", "rape", "semen", "sex", "shit", "slut", "titties", "twat", "vagina", "vulva", "wank", "FUCK", "BITCH", "FAGGOT", "DICK", "CUNT", "ASS", "nigger", "nigga", "pus", "puss", "pusy"];
    }

    public function onChat(PlayerChatEvent $event) : void{
        $msg = $event->getMessage();
        $player = $event->getPlayer();
        if(!$player instanceof Player) return;
        if($player->hasPermission("Pandaz.bypass.swearing")){
        }else{
            foreach($this->badwords as $badwords){
                if(strpos($msg, $badwords) !== false){
                    $player->kick("§cDon't be rude\n§fVia Anti-Swearing", false);
                    $event->setCancelled();
                    return;
                }
            }
        }
    }
}