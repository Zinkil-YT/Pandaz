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
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\entity\Entity;
use pocketmine\item\Item;
use pocketmine\item\SplashPotion as ItemSplashPotion;
use pocketmine\entity\projectile\SplashPotion as ProjectileSplashPotion;
use pocketmine\item\GoldenApple;
use pocketmine\item\MushroomStew;
use pocketmine\item\Potion;
use pocketmine\item\EnderPearl as ItemEnderPearl;
use pocketmine\entity\projectile\EnderPearl as ProjectileEnderPearl;
use pocketmine\item\Arrow;
use pocketmineentity\projectile\Arrow as ProjectileArrow;
use pocketmine\level\Location;
use pocketmine\level\Position;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\math\Vector3;
use pocketmine\block\Block;
use pocketmine\event\player\PlayerChangeSkinEvent;
use pocketmine\level\particle\CriticalParticle;
use pocketmine\network\mcpe\protocol\LoginPacket;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\network\mcpe\protocol\MovePlayerPacket;
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
use pocketmine\event\entity\EntityDeathEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityRegainHealthEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\event\entity\ProjectileHitEntityEvent;
use pocketmine\event\entity\ProjectileHitEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\EmotePacket;
use pocketmine\network\mcpe\protocol\DisconnectPacket;
use pocketmine\network\mcpe\protocol\types\inventory\UseItemOnEntityTransactionData;
use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\network\mcpe\protocol\PlayerActionPacket;
use pocketmine\network\mcpe\protocol\AnimatePacket;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\network\mcpe\protocol\EventPacket;
use pocketmine\network\mcpe\protocol\ActorEventPacket;
use pocketmine\event\inventory\CraftItemEvent;
use Zinkil\Pandaz\tasks\onetime\ChatCooldownTask;
use Zinkil\Pandaz\tasks\onetime\PearlTask;
use Zinkil\Pandaz\tasks\onetime\WelcomeTask;
use Zinkil\Pandaz\tasks\onetime\CloseEntityTask;
use Zinkil\Pandaz\CorePlayer;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\Kits;
use Zinkil\Pandaz\Utils;
use Zinkil\Pandaz\LevelUtils;
use Zinkil\Pandaz\bossbar\BossBar;
use Zinkil\Pandaz\discord\{Webhook, Message, Embed};
use Zinkil\Pandaz\misc\Math;

class PlayerListener implements Listener{
	
	public $plugin;
	private $gappleCooldown=[];
	
	public function __construct(Core $plugin){
		$this->plugin=$plugin;
	}

	function onCreation(PlayerCreationEvent $event){
		$event->setPlayerClass(CorePlayer::class);
	}

	function onCraft(CraftItemEvent $event){
		$event->setCancelled();
	}

	public function onPreLogin(PlayerPreLoginEvent $event){
		$player=$event->getPlayer();
		if($player instanceof CorePlayer){
			$player->initializeLogin();
		}else{
			$this->plugin->getDatabaseHandler()->rankAdd(Utils::getPlayerName($player));
			$this->plugin->getDatabaseHandler()->levelsAdd(Utils::getPlayerName($player));
			$this->plugin->getDatabaseHandler()->essentialStatsAdd(Utils::getPlayerName($player));
		}
		if($this->plugin->getDatabaseHandler()->isPermanentlyBanned($player->getName())){
			$player->kick("§cYou are permanently banned.\n§fContact us: ".Core::DISCORD, false);
			return;
		}
		$query=$this->plugin->staff->query("SELECT * FROM temporarybans WHERE player='".$player->getName()."';");
		$result=$query->fetchArray(SQLITE3_ASSOC);
		if(!empty($result)){
			$duration=$result['duration'];
			$reason=$result['reason'];
			$now=time();
			if($duration>$now){
				$remainingTime=$duration - $now;
				$day=floor($remainingTime / 86400);
				$hourSeconds=$remainingTime % 86400;
				$hour=floor($hourSeconds / 3600);
				$minuteSec=$hourSeconds % 3600;
				$minute=floor($minuteSec / 60);
				$remainingSec=$minuteSec % 60;
				$second=ceil($remainingSec);
				$player->kick("§cYou are temporarily banned.\n§fReason: ".$reason."\n§fContact us: ".Core::DISCORD."\nD: ".$day." H: ".$hour." M: ".$minute, false);
				return;
			}
		}
		$ip=$player->getAddress();
		$cid=$player->getClientId();
		$contentsip=file_get_contents($this->plugin->getDataFolder()."aliases/".$ip, true);
		$listip=explode(", ", $contentsip);
		foreach($listip as $altaccsip){
			if($this->plugin->getDatabaseHandler()->isTemporarilyBanned($altaccsip) or $this->plugin->getDatabaseHandler()->isPermanentlyBanned($altaccsip)){
				$player->kick("§cYou are banned on another account.\n§fContact us: ".Core::DISCORD, false);
			}
		}
		$contentscid=file_get_contents($this->plugin->getDataFolder()."aliases/".$cid, true);
		$listcid=explode(", ", $contentscid);
		foreach($listcid as $altaccscid){
			if($this->plugin->getDatabaseHandler()->isTemporarilyBanned($altaccscid) or $this->plugin->getDatabaseHandler()->isPermanentlyBanned($altaccscid)){
				$player->kick("§cYou are banned on another account.\n§fContact us: ".Core::DISCORD, false);
			}
		}
	}

	public function onJoin(PlayerJoinEvent $event){
		$player=$event->getPlayer();
		$bar = new BossBar();
		//Discord webhook utils
		$webHook=new Webhook(Core::WEBHOOK);
		$emessage=new Message();
		$embed=new Embed();
		if($player instanceof CorePlayer) $player->initializeJoin();
		$event->setJoinMessage("§f(§a+§f) §a".$player->getDisplayName());
		//Good solution for the welcome title that doesn't show for low spec devices
		$this->plugin->getScheduler()->scheduleRepeatingTask(new WelcomeTask($this->plugin, $player), 20);
		$player->addTitle("§bPandaz", "§fPractice", 20, 100, 80);
        $player->sendMessage("§r✅§7----------------------------------------");
        $player->sendMessage("§r");
        $player->sendMessage("§r✅§b§lPandaz §fPractice§r");
		$player->sendMessage("§r✅§7» Welcome, §eSeason 1");
        $player->sendMessage("§r");
        $player->sendMessage("§r✅§7» Discord: discord.gg/2zt7P5EUuN");
        $player->sendMessage("§r✅§7» Instagram: @PandazNetwork");
		$player->sendMessage("§r✅§7» Twitter: @PandazPracticeEU");
        $player->sendMessage("§r");
        $player->sendMessage("§r✅§7----------------------------------------");
		//Discord webhook event
		$embed->setTitle("Pandaz Notifications");
		$embed->setColor(0x86F03D);
		$embed->setDescription("Player joined: `".$player->getDisplayName()."`\nOnline players: `".count($this->plugin->getServer()->getOnlinePlayers())."`");
		$embed->setFooter(Utils::getTimeExact(), null);
		$emessage->addEmbed($embed);
		$webHook->sendAsync($emessage);
		$bar->setTitle("§l§bPandaz §l§fPractice");
		$bar->setSubTitle("§b");
		$bar->setPercentage(1);
		$bar->addPlayer($player);
	}

	public function onQuit(PlayerQuitEvent $event){
		$player=$event->getPlayer();
		$reason=$event->getQuitReason();
		if($player instanceof CorePlayer) $player->initializeQuit();
		//A fix for (Online Players) don't update before sending embed message
		$removeplayer = 1;
		$getplayers = count($this->plugin->getServer()->getOnlinePlayers());
		$allplayers = $getplayers - $removeplayer;
		//Discord webhook utils
		$webHook=new Webhook(Core::WEBHOOK);
		$emessage=new Message();
		$embed=new Embed();
		$event->setQuitMessage("§f(§c-§f) §c".$player->getDisplayName());
		//Discord webhook event
		$embed->setTitle("Pandaz Notifications");
		$embed->setColor(0xF71828);
		$embed->setDescription("Player left: `".$player->getDisplayName()."`\nOnline players: `".$allplayers."`");
		$embed->setFooter(Utils::getTimeExact(), null);
		$emessage->addEmbed($embed);
		$webHook->sendAsync($emessage);
		if($player instanceof CorePlayer and $player->isTagged()){
			if($reason=="client disconnect"){
				Utils::updateStats($player, 2);
				$player->kill();
			}
			$player->setTagged(false);
		}
		if($reason=="timeout"){
			foreach($this->plugin->getServer()->getOnlinePlayers() as $online){
				if($online->hasPermission("Pandaz.staff.notifications")){
					$format=$this->plugin->getStaffUtils()->sendStaffNoti("timeout");
					$format=str_replace("{name}", $player->getName(), $format);
					$online->sendMessage($format);
				}
			}
		}
	}

	public function onDeath(PlayerDeathEvent $event){
		$player=$event->getPlayer();
		$finaldamagecause=$player->getLastDamageCause();
		$event->setDeathMessage("§c".$player->getDisplayName()." Died");
		foreach($event->getDrops() as $item){
			$delay=100;
			$close=21;
			$entity=$player->level->dropItem($player->add(0, 0.2, 0), $item, null, $delay);
			$this->plugin->getScheduler()->scheduleDelayedTask(new CloseEntityTask($this->plugin, $entity), $close);
			$event->setDrops([]);
		}
		if($player instanceof CorePlayer){
			if($player->isTagged()) $player->setTagged(false);
		}
		$this->plugin->getScoreboardHandler()->removeScoreboard($player);
		$specduel=$this->plugin->getDuelHandler()->getDuelFromSpec($player);
		if(!is_null($specduel)) $specduel->removeSpectator($player);
		if($this->plugin->getDuelHandler()->isInDuel($player)){
			$duel=$this->plugin->getDuelHandler()->getDuel($player);
			if($duel->didDuelEnd()) return;
			$event->setDeathMessage("");
			$winner=($duel->isPlayer($player) ? Utils::getPlayerName($duel->getOpponent()):Utils::getPlayerName($duel->getPlayer()));
			$loser=Utils::getPlayerName($player);
			$duelwinner=Utils::getPlayer($winner);
			$duelloser=Utils::getPlayer($loser);
			$duel->setResults($winner, $loser);
			return;
		}
	}

    public function onFFADeath(EntityDamageEvent $event){
        if ($event instanceof EntityDamageByEntityEvent){
            if ($event->getEntity() instanceof Player){
                if ($event->getDamager() instanceof Player){
                    $player = $event->getEntity();
                    $killer = $event->getDamager();
					if ($this->plugin->getDuelHandler()->isInDuel($player)) return;
					if ($this->plugin->getDuelHandler()->isInDuel($killer)) return;
					if ($this->plugin->getDuelHandler()->isInPartyDuel($player)) return;
					if ($this->plugin->getDuelHandler()->isInPartyDuel($killer)) return;
                    if ($player->getHealth() - $event->getFinalDamage() <= 0){
						Utils::spawnPrivateLightning($player, [$killer]);
						Utils::spawnPrivateimpact($player, [$killer]);
						if($player->isTagged()) $player->setTagged(false);
						if($killer->isTagged()) $killer->setTagged(false);
						if($player instanceof CorePlayer) $player->sendTo(0, true);
						$rank=$killer->getRank();
						$finalhealth=round($killer->getHealth(), 1);
						$weapon=$killer->getInventory()->getItemInHand()->getName();
						$playername=$player->getDisplayName();
						$killername=$killer->getDisplayName();
						$messages=["quickied", "railed", "ezed", "clapped", "given an L", "smashed", "botted", "utterly defeated", "swept off their feet", "sent to the heavens", "killed", "owned", "kicked to hell", "UwUed", "OwOed", "Clowned", "360ed"];
						$potsA=0;
						$potsB=0;
						foreach($player->getInventory()->getContents() as $pots){
							if($pots instanceof ItemSplashPotion) $potsA++;
						}
						foreach($killer->getInventory()->getContents() as $pots){
							if($pots instanceof ItemSplashPotion) $potsB++;
						}
						if($killer->getLevel()->getName()=="nodebuff"){
							$dm="§l§9Nodebuff §7» §r§b".$player->getDisplayName()." §6[".$potsA." Pots] §7Was ".$messages[array_rand($messages)]." §7By§b ".$killer->getDisplayName()." §6[".$potsB." Pots - ".$finalhealth." HP]";
						}else{
							$dm="§l§cPvP §7» §r§b".$player->getDisplayName()." §7Was ".$messages[array_rand($messages)]." §7By§b ".$killer->getDisplayName()." §6[".$finalhealth." HP]";
						}
						foreach($this->plugin->getServer()->getOnlinePlayers() as $online){
							$online->sendMessage($dm);
						}
						$killer->setHealth($killer->getMaxHealth());
						if($killer instanceof CorePlayer) Utils::updateStats($killer, 0);
						if($killer instanceof CorePlayer) LevelUtils::increaseCurrentXp($killer, "kill", false);
						if($killer instanceof CorePlayer) LevelUtils::checkXp($killer);
						if($player instanceof CorePlayer) Utils::updateStats($player, 1);
						if($player instanceof CorePlayer) LevelUtils::checkXp($player);
						if(Utils::isAutoRekitEnabled($killer)==true) Kits::sendKit($killer, $killer->getLevel()->getName());
						if(Core::getInstance()->getDatabaseHandler()->getKillstreak($killer) >= 5 and Core::getInstance()->getDatabaseHandler()->getKillstreak($killer) < 10){
							$this->plugin->getServer()->broadcastMessage("§l§eKillStreak §r» §a".$killer->getDisplayName()." §7just got a killstreak of §b".Core::getInstance()->getDatabaseHandler()->getKillstreak($killer));
						}
						if(Core::getInstance()->getDatabaseHandler()->getKillstreak($killer) >= 10 and Core::getInstance()->getDatabaseHandler()->getKillstreak($killer) < 20){
							$this->plugin->getServer()->broadcastMessage("§l§eKillStreak §r» §a".$killer->getDisplayName()." §7just got a killstreak of §a".Core::getInstance()->getDatabaseHandler()->getKillstreak($killer));
						}
						if(Core::getInstance()->getDatabaseHandler()->getKillstreak($killer) >= 20 and Core::getInstance()->getDatabaseHandler()->getKillstreak($killer) < 30){
							$this->plugin->getServer()->broadcastMessage("§l§eKillStreak §r» §a".$killer->getDisplayName()." §7just got a killstreak of §6".Core::getInstance()->getDatabaseHandler()->getKillstreak($killer));
						}
						if(Core::getInstance()->getDatabaseHandler()->getKillstreak($killer) >= 30 and Core::getInstance()->getDatabaseHandler()->getKillstreak($killer) < 50){
							$this->plugin->getServer()->broadcastMessage("§l§eKillStreak §r» §a".$killer->getDisplayName()." §7just got a killstreak of §c".Core::getInstance()->getDatabaseHandler()->getKillstreak($killer));
						}
						if(Core::getInstance()->getDatabaseHandler()->getKillstreak($killer) >= 50 and Core::getInstance()->getDatabaseHandler()->getKillstreak($killer) < 75){
							$this->plugin->getServer()->broadcastMessage("§l§eKillStreak §r» §a".$killer->getDisplayName()." §7just got a killstreak of §d".Core::getInstance()->getDatabaseHandler()->getKillstreak($killer));
						}
						if(Core::getInstance()->getDatabaseHandler()->getKillstreak($killer) >= 100){
							$this->plugin->getServer()->broadcastMessage("§l§eKillStreak §r» §a".$killer->getDisplayName()." §7just got a killstreak of §0".Core::getInstance()->getDatabaseHandler()->getKillstreak($killer));
						}
					} 
                }
            }
        }
    }

	public function onRegainHealth(EntityRegainHealthEvent $event){
		$entity=$event->getEntity();
		$reason=$event->getRegainReason();
		$amount=$event->getAmount();
		if($reason===2){
		}
	}

	public function onLevelChange(EntityLevelChangeEvent $event){
		$player=$event->getEntity();
		if(!$player instanceof Player) return;
		$level=$event->getTarget()->getName();
		if($level=="lobby") $player->setPlayerLocation(0);
		if($level=="nodebuff") $player->setPlayerLocation(1);
		if($level=="gapple") $player->setPlayerLocation(2);
		if($level=="opgapple") $player->setPlayerLocation(3);
		if($level=="combo") $player->setPlayerLocation(4);
		if($level=="fist") $player->setPlayerLocation(5);
		if($level=="tournament") $player->setPlayerLocation(6);
		if($level=="nodebuff-low") $player->setPlayerLocation(7);
		if($level=="nodebuff-java") $player->setPlayerLocation(8);
		if($level=="resistance") $player->setPlayerLocation(9);
		if($level=="sumoffa") $player->setPlayerLocation(11);
		if($level=="knockbackffa") $player->setPlayerLocation(12);
		if($level=="buildffa") $player->setPlayerLocation(13);
	}

	public function onRespawn(PlayerRespawnEvent $event){
		$player=$event->getPlayer();
		$position=new Position(258, 69, 234, $this->plugin->getServer()->getLevelByName(Core::LOBBY));
		$event->setRespawnPosition($position);
		if($player instanceof CorePlayer) $player->sendTo(0, true);
	}

	public function onChat(PlayerChatEvent $event){
		$player=$event->getPlayer();
		if(Utils::getGlobalMute()===true){
			if(!$player->hasPermission("Pandaz.bypass.chatsilence")){
				$event->setCancelled();
				$player->sendMessage("§cChat is silenced.");
				return;
			}
		}
		if($this->plugin->getDatabaseHandler()->isMuted($player->getName())){
			$event->setCancelled();
			$player->sendMessage("§cYou are muted.");
			return;
		}
		$rank=$player->getRank();
		$ffaelo=$this->plugin->getDatabaseHandler()->getElo($player->getName());
		if(!$player->hasPermission("Pandaz.bypass.chatcooldown")){
			if(!$player->isChatCooldown()){
				$this->plugin->getScheduler()->scheduleRepeatingTask(new ChatCooldownTask($this->plugin, $player), 20);
			}else{
				$event->setCancelled();
				$player->sendMessage("§cYou cannot chat that quick.");
				return;
			}
		}
		
		$message=$event->getMessage();
		
		$format=Utils::getChatFormat($rank);
		$format=str_replace("{clan}", $player->getClanTag(), $format);
		$format=str_replace("{kills}", $this->plugin->getDatabaseHandler()->getKills($player), $format);
		$format=str_replace("{name}", $player->getDisplayName(), $format);
		$format=str_replace("{message}", $message, $format);
		if(!$player->isDisguised()){
			$event->setFormat($format);
		}else{
			$default=Utils::getChatFormat("Player");
			$default=str_replace("{clan}", "", $default);
			$default=str_replace("{kills}", $this->plugin->getDatabaseHandler()->getKills($player), $default);
			$default=str_replace("{name}", $player->getDisplayName(), $default);
			$default=str_replace("{message}", $message, $default);
			$event->setFormat($default);
		}
		if($player->hasPermission("Pandaz.access.staffchat") and $message[0]=="!"){
			$event->setCancelled();
			foreach($this->plugin->getServer()->getOnlinePlayers() as $online){
				if($online->hasPermission("Pandaz.access.staffchat")){
					$msg=str_replace("!", "", $message);
					$level=$online->getLevel()->getName();
					$online->sendMessage("§8[STAFF] ".$player->getName().": §f".$msg);
				}
			}
		}
		if($player->isInParty() and $message[0]=="*"){
			$event->setCancelled();
			$msg=str_replace("*", "", $message);
			$player->getParty()->sendMessage($player->getDisplayName().": ".$msg);
		}
	}

	public function onCommand(PlayerCommandPreprocessEvent $event){
		$player=$event->getPlayer();
		$message=$event->getMessage();
		if($player instanceof CorePlayer and $player->isFrozen() and $message[0]==="/"){
			$event->setCancelled();
		}
	}

	public function onExhaust(PlayerExhaustEvent $event) : void{
		$event->setCancelled();
		$player = $event->getPlayer();
		if($player instanceof Player){
			$player->setFood($player->getMaxFood());
		}
	}

	public function onInteract(PlayerInteractEvent $event){
		$player=$event->getPlayer();
		$os=$this->plugin->getPlayerOs($player);
		$controls=$this->plugin->getPlayerControls($player);
		$action=$event->getAction();
		$item=$event->getItem();
		$itemInHand=$player->getInventory()->getItemInHand();
		$id=$item->getId();
		$meta=$item->getDamage();
		if($itemInHand->getId()===Item::SPLASH_POTION){
			$event->setCancelled();
			Utils::createPotion($player);
		}
		if($itemInHand->getId()===Item::ENDER_PEARL){
			if($player->isFrozen() or $player->isEnderPearlCooldown()){
				$event->setCancelled();
			}
		}
		if($action===PlayerInteractEvent::RIGHT_CLICK_BLOCK or $action===PlayerInteractEvent::RIGHT_CLICK_AIR){
			if($item->getId()===Item::MUSHROOM_STEW){
				Utils::consumeItem($itemInHand, $player);
			}
		}
	}

	public function onEntityDamage(EntityDamageEvent $event){
		$player=$event->getEntity();
		$cause=$event->getCause();
		$damage=$event->getBaseDamage();
		if($cause===EntityDamageEvent::CAUSE_FALL){
			$event->setCancelled();
			return;
		}
		if($player instanceof Player){
			if($player instanceof CorePlayer){
				if($player->isFrozen()) $event->setCancelled();
			}
			$level=$player->getLevel()->getName();
			if($level==Core::LOBBY){
				$event->setCancelled();
			}
			if($player->getY() >= 128){
				if($level!=="lobby"){
					$event->setCancelled();
				}
			}
			if($this->plugin->getDuelHandler()->isInDuel($player)){
				$duel=$this->plugin->getDuelHandler()->getDuel($player);
				if($duel->isLoadingDuel() or $duel->didDuelEnd()){
					$event->setCancelled();
					return;
				}
				if($event->getFinalDamage()>=$player->getHealth()){
					if(!$player->isCreative()){
						$event->setCancelled();
						$drops=$player->getInventory()->getContents();
						foreach($drops as $item){
							$delay=120;
							$close=120;
							$entity=$player->level->dropItem($player->add(0, 1, 0), $item, null, $delay);
							$this->plugin->getScheduler()->scheduleDelayedTask(new CloseEntityTask($this->plugin, $entity), $close);
						}
					}
					$winner=($duel->isPlayer($player) ? Utils::getPlayerName($duel->getOpponent()):Utils::getPlayerName($duel->getPlayer()));
					$loser=Utils::getPlayerName($player);
					$duelwinner=Utils::getPlayer($winner);
					$duelloser=Utils::getPlayer($loser);
					$duel->setResults($winner, $loser);
					return;
				}
			}
			if($this->plugin->getDuelHandler()->isInPartyDuel($player)){
				$partyduel=$this->plugin->getDuelHandler()->getPartyDuel($player);
				if($partyduel->isLoadingDuel() or $partyduel->didDuelEnd()){
					$event->setCancelled();
					return;
				}
				if($event->getFinalDamage()>=$player->getHealth()){
					if(!$player->isCreative()){
						$event->setCancelled();
						$drops=$player->getInventory()->getContents();
						foreach($drops as $item){
							$delay=120;
							$close=120;
							$entity=$player->level->dropItem($player->add(0, 1, 0), $item, null, $delay);
							$this->plugin->getScheduler()->scheduleDelayedTask(new CloseEntityTask($this->plugin, $entity), $close);
						}
					}
					$partyduel->initializeLoss($player);
					return;
				}
			}
			if($this->plugin->getDuelHandler()->isInBotDuel($player)){
				$botduel=$this->plugin->getDuelHandler()->getBotDuel($player);
				if($botduel->isLoadingDuel() or $botduel->didDuelEnd()){
					$event->setCancelled();
					return;
				}
				$check=$player->getHealth() - $event->getFinalDamage();
				if($event->getFinalDamage() - $check >= $player->getHealth()){
					if(!$player->isCreative()){
						$event->setCancelled();
						$winner=($botduel->isPlayer($player) ? $botduel->getBotName():Utils::getPlayerName($duel->getPlayer()));
						$loser=Utils::getPlayerName($player);
						$duelwinner=Utils::getPlayer($winner);
						$duelloser=Utils::getPlayer($loser);
						$botduel->setResults($winner, $loser);
						if($player instanceof CorePlayer) Utils::spawnPublicLightning($player);
					}
				}
				return;
			}
		}
		if($event instanceof EntityDamageByEntityEvent){
			$damager=$event->getDamager();
			if($player instanceof Player and $damager instanceof Player){
				if(Utils::particleMod($damager)!="off"){
					if(Utils::particleMod($damager)=="x1") Utils::sendExtraParticles($damager, $player, 1);
					if(Utils::particleMod($damager)=="x2") Utils::sendExtraParticles($damager, $player, 2);
					if(Utils::particleMod($damager)=="x4") Utils::sendExtraParticles($damager, $player, 4);
					if(Utils::particleMod($damager)=="x8") Utils::sendExtraParticles($damager, $player, 8);
				}
				foreach([$player, $damager] as $players){
					if(!$event->isCancelled()){
						if($players instanceof CorePlayer) $players->setTagged(true);
					}
					$level=$players->getLevel()->getName();
					if($level==Core::LOBBY){
						$event->setCancelled();
					}
				}
				if($player instanceof CorePlayer and $player->isFrozen()){
					$event->setCancelled();
					$damager->sendMessage("§cYou cannot damage a frozen player.");
				}
				if($player instanceof CorePlayer and $player->isVanished()){
					$event->setCancelled();
				}
				if($damager->isFrozen()){
					$event->setCancelled();
					$damager->sendMessage("§cYou cannot damage other players while frozen.");
				}
				if($damager->isVanished()){
					$event->setCancelled();
					$damager->sendMessage("§cYou cannot damage other players while vanished.");
				}
			}
		}
	}

	public function onEntityDeath(EntityDeathEvent $event){
		$entity=$event->getEntity();
		if(!$entity instanceof Player){
			Utils::spawnPublicLightning($entity);
			$event->setDrops([]);
		}
	}

	public function onDisconnectPacket(DataPacketSendEvent $event){
		$packet=$event->getPacket();
		$player=$event->getPlayer();
		if($packet instanceof DisconnectPacket and $packet->message==="Internal server error"){
			$packet->message=("§cYou have encountered a bug.\n§fContact us: ".Core::DISCORD);
			foreach($this->plugin->getServer()->getOnlinePlayers() as $online){
				if($online->hasPermission("Pandaz.staff.notifications")){
					$format=$this->plugin->getStaffUtils()->sendStaffNoti("internalerror");
					$format=str_replace("{name}", $player->getName(), $format);
					$online->sendMessage($format);
				}
			}
		}
		if($packet instanceof DisconnectPacket and $packet->message==="Server is white-listed"){
			$packet->message=("§cWe are currently whitelisted, check back shortly.\n§fDiscord: ".Core::DISCORD);
		}
		if($packet instanceof DisconnectPacket and $packet->message==="generic reason"){
			$packet->message=("§bServer is restarting...");
		}
	}

	public function onPacketReceived(DataPacketReceiveEvent $event){
		$packet=$event->getPacket();
		$player=$event->getPlayer();
		$os=$this->plugin->getPlayerOs($player);
		$controls=$this->plugin->getPlayerControls($player);
		if($packet instanceof LoginPacket and $player instanceof Player){
			if($packet->clientData["CurrentInputMode"]!==null and $packet->clientData["DeviceOS"]!==null and $packet->clientData["DeviceModel"]!==null){
				$this->plugin->controls[$packet->username ?? "unavailable"]=$packet->clientData["CurrentInputMode"];
				$this->plugin->os[$packet->username ?? "unavailable"]=$packet->clientData["DeviceOS"];
				$this->plugin->device[$packet->username ?? "unavailable"]=$packet->clientData["DeviceModel"];
			}
		}
		if($this->plugin->getClickHandler()->isInArray($player)){
			if($packet instanceof InventoryTransactionPacket and $packet->trData->getTypeId()===InventoryTransactionPacket::TYPE_USE_ITEM_ON_ENTITY){
				$this->plugin->getClickHandler()->addClick($player);
			}
		}
		if($packet::NETWORK_ID===LevelSoundEventPacket::NETWORK_ID and $packet->sound===LevelSoundEventPacket::SOUND_ATTACK_NODAMAGE){
			$itemInHand=$player->getInventory()->getItemInHand();
			if($this->plugin->getClickHandler()->isInArray($player)){
				$this->plugin->getClickHandler()->addClick($player);
			}
			if($itemInHand->getId()===Item::MUSHROOM_STEW) Utils::consumeItem($itemInHand, $player);
		}
		if($packet instanceof EmotePacket){
			$emoteId=$packet->getEmoteId();
			$this->plugin->getServer()->broadcastPacket($player->getViewers(), EmotePacket::create($player->getId(), $emoteId, 1 << 0));
		}
	}

	public function onDrop(PlayerDropItemEvent $event){
		$player=$event->getPlayer();
		$item=$event->getItem();
		$level=$player->getLevel()->getName();
		$event->setCancelled();
		Utils::cancelSound($player);
	}

	public function onConsume(PlayerItemConsumeEvent $event){
		$player=$event->getPlayer();
		$item=$event->getItem();
		$name=$item->getName();
		$inventory=$player->getInventory();
		$itemInHand=$player->getInventory()->getItemInHand();
		$effects=$item->getAdditionalEffects();
		if($item instanceof GoldenApple and $name!=Core::GOLDEN_HEAD){
			$cooldown=2;
			if(!isset($this->gappleCooldown[$player->getName()])){
				$this->gappleCooldown[$player->getName()]=time();
			}else{
				if($cooldown > time() - $this->gappleCooldown[$player->getName()]){
					$time=time() - $this->gappleCooldown[$player->getName()];
					$event->setCancelled();
					$player->sendMessage("§cYou cannot eat golden apples that quick.");
				}else{
					$this->gappleCooldown[$player->getName()]=time();
				}
			}
		}
		if($item instanceof Potion){
			$inventory->setItem($inventory->getHeldItemIndex(), Item::get(0));
			foreach($effects as $effect){
				if($effect instanceof EffectInstance){
					$player->addEffect($effect);
				}
			}
		}
		if($item instanceof MushroomStew) $event->setCancelled();
		if($name==Core::GOLDEN_HEAD){
			$player->addEffect(new EffectInstance(Effect::getEffect(10), 20 * 9, 1, false));//add 5 seconds of regen
		}
		if($itemInHand->getId()===Item::POTION){
			$inventory->setItem($inventory->getHeldItemIndex(), Item::get(0));
		}
	}

	public function onProjectileHit(ProjectileHitEvent $event){
		$projectile=$event->getEntity();
		$damager=$projectile->getOwningEntity();
		if($event instanceof ProjectileHitEntityEvent){
			$player=$event->getEntityHit();
			if($player instanceof Player and $damager instanceof Player){
				if($player->getName()!=$damager->getName()){
					foreach([$player, $damager] as $players){
						if($players instanceof CorePlayer) $players->setTagged(true);
					}
				}
			}
		}
	}

	public function onLaunch(ProjectileLaunchEvent $event){
		$projectile=$event->getEntity();
		$player=$projectile->getOwningEntity();
		$itemInHand=$player->getInventory()->getItemInHand();
		if($projectile instanceof ProjectileSplashPotion){
			$event->setCancelled();
			Utils::createPotion($player);
		}
		if($projectile instanceof ProjectileEnderPearl){
			$event->setCancelled();
			if(!$player->isEnderPearlCooldown()){
				Utils::createPearl($player);
				$this->plugin->getScheduler()->scheduleRepeatingTask(new PearlTask($this->plugin, $player), 20);
			}
		}
	}

	public function onMove(PlayerMoveEvent $event){
		$player=$event->getPlayer();
		$block=$player->getLevel()->getBlock($player->getSide(0));
		$from=$event->getFrom();
		$to=$event->getTo();
		if($player->getLevel()->getName()==Core::LOBBY and $player->getY() <= 0){
			if($player instanceof CorePlayer) $player->sendTo(0, true);
		}
		if($player->getY() <=-5){
			if(!$this->plugin->getDuelHandler()->isInDuel($player)){
				$player->setHealth(0);
			}
		}
		if(Utils::isAutoSprintEnabled($player)==true){
			// Gets the difference between the two vectors.
			$difference = $event->getTo()->subtract($event->getFrom());
			$distance = $difference->length();
			$lookDirection = $player->getDirectionVector()->normalize();
			$dotProductResult = Math::dot($lookDirection, $difference->normalize());
			// Result of dot product:
			// if result is 1 in this case, player is moving forward
			// if result is 0 in this case, player is moving side to side
			// if result is -1 in this case, player is moving backward
			// TODO: Change 0.5 for dot product result to some threshold for
			//       determining if player is moving forward
			$player->setSprinting($distance > 0 && $dotProductResult >= 0.5);
		}
	}
}