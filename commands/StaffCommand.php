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

class StaffCommand extends PluginCommand{
	
	private $plugin;
	
	public function __construct(Core $plugin){
		parent::__construct("staff", $plugin);
		$this->plugin=$plugin;
		$this->setDescription("§bEnable or disable staff mode");
		$this->setPermission("Pandaz.command.staff");
		$this->setAliases(["staffmode"]);
	}

	public function execute(CommandSender $player, string $commandLabel, array $args){
		if(!$player instanceof Player){
			return;
		}
		if(!$player->hasPermission("Pandaz.command.staff")){
			$player->sendMessage("§cYou cannot execute this command.");
			return;
		}
		if($this->plugin->getDuelHandler()->isInDuel($player) or $this->plugin->getDuelHandler()->isInBotDuel($player)){
			$player->sendMessage("§cYou cannot use this command while in a duel.");
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
		if(!$player->isStaffMode()){
			$this->plugin->getStaffUtils()->staffMode($player, true);
		}else{
			$this->plugin->getStaffUtils()->staffMode($player, false);
		}
	}
}