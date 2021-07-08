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

namespace Zinkil\Pandaz\Commands;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\AnimatePacket;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\math\Vector3;
use pocketmine\entity\Entity;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\Utils;
use Zinkil\Pandaz\bots\{TestBot, EasyBot, MediumBot, HardBot, HackerBot};

class TestCommand extends PluginCommand{
	
	private $plugin;
	
	public function __construct(Core $plugin){
		parent::__construct("test", $plugin);
		$this->setAliases(["t"]);
		$this->plugin=$plugin;
	}

	public function execute(CommandSender $player, string $commandLabel, array $args){
		if($this->plugin->getDuelHandler()->isInPartyDuel($player)){
			$duel=$this->plugin->getDuelHandler()->getPartyDuel($player);
			foreach($duel->getPlayers() as $players){
				$player->sendMessage("Duel players: ".$players);
			}
			if($duel===null){
				$player->sendMessage("Not in party duel.");
			}else{
				$player->sendMessage("In party duel.");
			}
		}
		$adam=Utils::getPlayer("adam");
		$steve=Utils::getPlayer("steve");
		$joe=Utils::getPlayer("joe");
		$kris=Utils::getPlayer("kris");
		$kaleb=Utils::getPlayer("kaleb");
		$tom=Utils::getPlayer("tom");
		$ab=Utils::getPlayer("abby");
		if(!is_null($adam)) $this->plugin->getDuelHandler()->addPlayerToQueue($adam, "NoDebuff", true);
		if(!is_null($steve)) $this->plugin->getDuelHandler()->addPlayerToQueue($steve, "BuildUHC", true);
		if(!is_null($kris)) $this->plugin->getDuelHandler()->addPlayerToQueue($kris, "NoDebuff", true);
		if(!is_null($kaleb)) $this->plugin->getDuelHandler()->addPlayerToQueue($kaleb, "NoDebuff", true);
		if(!is_null($tom)) $this->plugin->getDuelHandler()->addPlayerToQueue($tom, "Line", false);
		if(!is_null($ab)) $this->plugin->getDuelHandler()->addPlayerToQueue($ab, "Line", false);
	}
}