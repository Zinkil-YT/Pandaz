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
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\LoginPacket;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\level\Location;
use pocketmine\math\Vector3;
use pocketmine\event\entity\EntityDamageEvent;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\CorePlayer;
use Zinkil\Pandaz\Utils;
use Zinkil\Pandaz\discord\{Webhook, Message, Embed};
use Zinkil\Pandaz\tasks\onetime\ToolboxTask;

class AntiCheatListener implements Listener{
	
	private $plugin;
	
	private $reachCooldown=[];
	
	private $cpsCooldown=[];
	
	public function __construct(Core $plugin){
		$this->plugin=$plugin;
	}

	public function onEntityDamageByEntity(EntityDamageEvent $event){
		$player=$event->getEntity();
		$cause=$event->getCause();
		//Discord webhook utils
		$webHook=new Webhook(Core::STAFFWEBHOOK);
		$emessage=new Message();
		$embed=new Embed();
		switch($cause){
			case EntityDamageEvent::CAUSE_ENTITY_ATTACK:
			$damager=$event->getDamager();
			if(!$player instanceof Player) return;
			if(!$damager instanceof Player) return;
			if($damager->isCreative()) return;
			if($damager->isOp()) return;
			$damagerpos=$damager->getPosition() ?? new Vector3(0,0,0);
			$playerpos=$player->getPosition() ?? new Vector3(0,0,0);
			$distance=$damagerpos->distance($playerpos);
			$approxdist=6;
			$maxdist=7;
			if($damager->getPing() >= 230){
				$approxdist=$damager->getPing() / 34;
				if($damager->getPing() >= 500){
					$approxdist=$damager->getPing() / 50;
				}
			}
			if($distance > $maxdist){
				$event->setCancelled();
			}
			if($maxdist >= $distance and $distance >= $approxdist){
				$damager->addReachFlag();
				//Discord webhook event
				$embed->setTitle("Anti-Cheat Alert");
				$embed->setColor(0xFFE500);
				$embed->setDescription("Player name: `".$damager->getDisplayName()."`\nType: `Reach`\nAmount: `".round($distance, 3)."`");
				$embed->setFooter(Utils::getTimeExact(), null);
				$emessage->addEmbed($embed);
				$webHook->sendAsync($emessage); // `
				$message=$this->plugin->getStaffUtils()->sendStaffAlert("reach");
				$message=str_replace("{name}", $damager->getName(), $message);
				$message=str_replace("{details}", round($distance, 3), $message);
				foreach($this->plugin->getServer()->getOnlinePlayers() as $online){
					if($online->hasPermission("Pandaz.staff.cheatalerts")){
						$reach=1;
						if(!isset($this->reachCooldown[$online->getName()])){
							$this->reachCooldown[$online->getName()]=time();
						}else{
							if($reach > time() - $this->reachCooldown[$online->getName()]){
								$time=time() - $this->reachCooldown[$online->getName()];
							}else{
								$this->reachCooldown[$online->getName()]=time();
								if($online->isAntiCheatOn()) $online->sendMessage($message);
							}
						}
					}
				}
			}
			$cps=$this->plugin->getClickHandler()->getCps($damager);
			$approxcps=23;
			$maxcps=35;
			if($damager->getPing() >= 230){
				$approxcps=25;
				if($damager->getPing() >= 500){
					$approxcps=27;
				}
			}
			if(!$damager->isOp()){
				if($cps >= 65){
					$damager->kick("§cYour CPS is too high.\n§fVia Anti-Cheat", false);
				}
			}
			if($cps >= $maxcps){
				$event->setCancelled();
			}
			if($cps >= $approxcps){
				$damager->addCpsFlag();
				//Discord webhook event
				$embed->setTitle("Anti-Cheat Alert");
				$embed->setColor(0xFFE500);
				$embed->setDescription("Player name: `".$damager->getDisplayName()."`\nType: `High CPS`\nAmount: `".$this->plugin->getClickHandler()->getCps($damager)."`");
				$embed->setFooter(Utils::getTimeExact(), null);
				$emessage->addEmbed($embed);
				$webHook->sendAsync($emessage); // `
				$message=$this->plugin->getStaffUtils()->sendStaffAlert("autoclick");
				$message=str_replace("{name}", $damager->getName(), $message);
				$message=str_replace("{details}", $this->plugin->getClickHandler()->getCps($damager), $message);
				foreach($this->plugin->getServer()->getOnlinePlayers() as $online){
					if($online->hasPermission("Pandaz.staff.cheatalerts")){
						$cps=1;
						if(!isset($this->cpsCooldown[$online->getName()])){
							$this->cpsCooldown[$online->getName()]=time();
						}else{
							if($cps > time() - $this->cpsCooldown[$online->getName()]){
								$time=time() - $this->cpsCooldown[$online->getName()];
							}else{
								$this->cpsCooldown[$online->getName()]=time();
								if($online->isAntiCheatOn()) $online->sendMessage($message);
							}
						}
					}
				}
			}
			break;
			default:
			return;
			break;
		}
	}

	public function onRecieve(DataPacketReceiveEvent $event){
        $player=$event->getPlayer();
        $packet=$event->getPacket();
		//Discord webhook utils
		$webHook=new Webhook(Core::STAFFWEBHOOK);
		$emessage=new Message();
		$embed=new Embed();
        if($packet instanceof LoginPacket){
			$clientId = $packet->clientId;
            $deviceOS = (int)$packet->clientData["DeviceOS"];
			$deviceId = (int)$packet->clientData['DeviceId'];
            $deviceModel = (string)$packet->clientData["DeviceModel"];

            if($deviceOS !== 1){ //1 is Android OS
                return;
            }

			if(!$player instanceof Player){
				return;
            }

			if($player->isOp()){
				return;
            }
			
            /**
             * Something about client id check, for example:
             * Original client: -8423610415471
             * Toolbox client: 0
             */

			if($clientId === 0){
				$player->close("", "§l§cToolBox Detected!");
				//Discord webhook event
				$embed->setTitle("Anti-Cheat Alert");
				$embed->setColor(0xFFE500);
				$embed->setDescription("Player name: `".$player->getName()."`\nType: `Toolbox Detected`");
				$embed->setFooter(Utils::getTimeExact(), null);
				$emessage->addEmbed($embed);
				$webHook->sendAsync($emessage);
            }

            /**
             * Something about device model check, for example:
             * Original client: XIAOMI Note 8 Pro
             * Toolbox client: Xiaomi Note 8 Pro
             *
             * For another Example
             * Original client: SAMSUNG SM-A105F
             * Toolbox client: samsung SM-A105F
             */

            $name = explode(" ", $deviceModel);
            if(!isset($name[0])){
                return;
            }
		
            $check = $name[0];
            $check = strtoupper($check);
            if($check !== $name[0]){
				$player->close("", "§l§cToolBox Detected!");
				//Discord webhook event
				$embed->setTitle("Anti-Cheat Alert");
				$embed->setColor(0xFFE500);
				$embed->setDescription("Player name: `".$player->getName()."`\nType: `Toolbox Detected`");
				$embed->setFooter(Utils::getTimeExact(), null);
				$emessage->addEmbed($embed);
				$webHook->sendAsync($emessage);
            }
        }
    }
}