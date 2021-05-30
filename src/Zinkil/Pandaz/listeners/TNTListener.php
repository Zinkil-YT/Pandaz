<?php

declare(strict_types=1);

namespace Zinkil\Pandaz\listeners;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\utils\Random;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\math\Vector3;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\CorePlayer;
use Zinkil\Pandaz\Utils;
use Zinkil\Pandaz\entities\TNTEntity;

class TNTListener implements Listener{

  public $plugin;

  public function __construct(){
		$this->plugin=Core::getInstance();
	}

  public function onDamage(EntityDamageEvent $event){
    $player = $event->getEntity();
    if($player instanceof Player){
      if($event->getCause() === EntityDamageEvent::CAUSE_ENTITY_EXPLOSION){
        $event->setCancelled();
      }
    }
  }

  public function ExplosionPrimeEvent(ExplosionPrimeEvent $event){
    $event->setBlockBreaking(false);
  }
}
