<?php

declare(strict_types=1);

namespace Zinkil\pc\listeners;

use pocketmine\event\Listener;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\level\Location;
use pocketmine\math\Vector3;
use pocketmine\utils\Config;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDeathEvent;
use Zinkil\pc\Core;
use Zinkil\pc\CPlayer;
use Zinkil\pc\Utils;

class DistanceListener implements Listener{
	
	public $plugin;
	
	public $combo;
	
	public function __construct(){
		$this->plugin=Core::getInstance();
		$this->combo = new Config($this->plugin->getDataFolder() . "combo.yml", Config::YAML);
	}
	/**
	* @priority LOW
	*/
    public function onJoin(PlayerJoinEvent $event)
    {
        $player = $event->getPlayer();
        /* Register Player */
        $this->combo->set($player->getName(), 0);
    }
    
    public function onPlayerDeath(PlayerDeathEvent $event)
    {
    	$player = $event->getPlayer();
    	/* If player has more than 0 combos */
        if ($this->combo->get($player->getName()) >= 1)
        {
            /* Reset combo on quit */
            $this->combo->set($player->getName(), 0);
        }
    }
	/**
	* @priority HIGH
	*/
	public function onEntityDamageByEntity(EntityDamageEvent $event){
		$player=$event->getEntity();
		$cause=$event->getCause();
		$level=$player->getLevel()->getName();
		switch($cause){
			case EntityDamageEvent::CAUSE_ENTITY_ATTACK:
			$damager=$event->getDamager();
			$dlevel=$damager->getLevel()->getName();
			if(!$player instanceof Player) return;
			if(!$damager instanceof Player) return;
			if($damager->isCreative()) return;
			if($level==Core::LOBBY) return;
			if($dlevel==Core::LOBBY) return;
			$damagerpos=$damager->getPosition() ?? new Vector3(0,0,0);
			$playerpos=$player->getPosition() ?? new Vector3(0,0,0);
			$distance=$damagerpos->distance($playerpos);
			$health=round($player->getHealth(), 1);
			$playername=$player->getDisplayName();
			$damagername=$damager->getDisplayName();
			$this->combo->set($damager->getName(), $this->combo->get($damager->getName()) + 1);
			$this->combo->set($player->getName(), 0);
			$player->sendPopup("§e".$damagername."§e: §7".$distance);
			$damager->sendPopup("§r§bDistance: §7".$distance." §7| §bCombo: §7".$this->combo->get($damager->getName()));
		}
	}
}