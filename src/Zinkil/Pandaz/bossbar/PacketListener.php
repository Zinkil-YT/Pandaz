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

namespace Zinkil\Pandaz\bossbar;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\BossEventPacket;
use pocketmine\plugin\Plugin;
use pocketmine\Server;

class PacketListener implements Listener{

    private static $registrant;

    public static function isRegistered(): bool{
        return self::$registrant instanceof Plugin;
    }

    public static function getRegistrant(): Plugin{
        return self::$registrant;
    }

    public static function unregister(): void{
        self::$registrant = null;
    }

    public static function register(Plugin $plugin): void{
        if (self::isRegistered()) {
            return;
        }

        self::$registrant = $plugin;
        $plugin->getServer()->getPluginManager()->registerEvents(new self, $plugin);
    }

    public function onDataPacketReceiveEvent(DataPacketReceiveEvent $e){
        if ($e->getPacket() instanceof BossEventPacket) $this->onBossEventPacket($e);
    }

    private function onBossEventPacket(DataPacketReceiveEvent $e){
        if (!($pk = $e->getPacket()) instanceof BossEventPacket) throw new \InvalidArgumentException(get_class($e->getPacket()) . " is not a " . BossEventPacket::class);
        switch ($pk->eventType) {
            case BossEventPacket::TYPE_REGISTER_PLAYER:
            case BossEventPacket::TYPE_UNREGISTER_PLAYER:
                Server::getInstance()->getLogger()->debug("Got BossEventPacket " . ($pk->eventType === BossEventPacket::TYPE_REGISTER_PLAYER ? "" : "un") . "register by client for player id " . $pk->playerEid);
                break;
                default:
                $e->getPlayer()->kick("Invalid packet received", false);
        }
    }

}