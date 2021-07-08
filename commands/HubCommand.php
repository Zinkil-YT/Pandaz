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

use pocketmine\Player;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\CorePlayer;
use Zinkil\Pandaz\Utils;

class HubCommand extends PluginCommand{
	
	private $plugin;
	
	public function __construct(Core $plugin){
		parent::__construct("hub", $plugin);
		$this->plugin=$plugin;
		$this->setDescription("§bTeleport to spawn");
		$this->setAliases(["lobby","spawn"]);
	}

	public function execute(CommandSender $player, string $commandLabel, array $args){
		if(!$player instanceof Player){
			return;
		}
		if(!$player->isOp()){
			if($player->isTagged()){
				$player->sendMessage("§cYou cannot use this command while in combat.");
				return;
			}
		}
		if($player->isInParty()){
			$player->sendMessage("§cYou cannot use this command while in a party.");
			return;
		}
		if($this->plugin->getDuelHandler()->isInDuel($player) or $this->plugin->getDuelHandler()->isInBotDuel($player)){
			$player->sendMessage("§cYou cannot use this command while in a duel.");
			return;
		}
		$duel=$this->plugin->getDuelHandler()->getDuel($player);
		if(!is_null($duel)) $duel->removeSpectator($player);
		$player->sendTo(0, true);
	}
}