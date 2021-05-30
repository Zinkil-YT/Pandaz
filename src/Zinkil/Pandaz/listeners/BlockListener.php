<?php

declare(strict_types=1);

namespace Zinkil\Pandaz\listeners;

use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\item\Item;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\entity\EntityDeathEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityRegainHealthEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\tasks\BlockResetRedstoneTask;
use Zinkil\Pandaz\tasks\BlockResetAirTask;

class BlockListener implements Listener{

	public function __construct(Core $plugin){
		$this->plugin=$plugin;
    }

    public function onPlace(BlockPlaceEvent $event){
        $block = $event->getBlock();

        $x = $block->getX();
        $y = $block->getY();
        $z = $block->getZ();
        $blockID = $event->getBlock()->getID();
        if($blockID == 24){
            if ($event->getPlayer()->getGamemode() == 0){
                $sandstone=Item::get(24, 0, 64);
                $event->getPlayer()->getInventory()->setItem(1, $sandstone);
                $this->plugin->getScheduler()->scheduleDelayedTask(new BlockResetRedstoneTask($block, $x, $y, $z), 100);
                $this->plugin->getScheduler()->scheduleDelayedTask(new BlockResetAirTask($block, $x, $y, $z), 200);
            }
        }
    }
}