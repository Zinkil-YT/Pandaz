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
use pocketmine\entity\Skin;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\CorePlayer;
use Zinkil\Pandaz\Utils;

class DisguiseCommand extends PluginCommand{
	
	private $plugin;
	
	public function __construct(Core $plugin){
		parent::__construct("disguise", $plugin);
		$this->plugin=$plugin;
		$this->setPermission("Pandaz.command.disguise");
		$this->setAliases(["disg"]);
	}

	public function execute(CommandSender $player, string $commandLabel, array $args){
		if(!$player instanceof Player){
			return;
		}
		if(!$player->hasPermission("Pandaz.command.disguise")){
			$player->sendMessage("§cYou cannot execute this command.");
			return;
		}
		if(!$player->isOp()){
			if($player->isTagged()){
				$player->sendMessage("§cYou cannot use this command while in combat.");
				return;
			}
		}
		if(!isset($args[0])){
			if($player->isDisguised()){
				$player->setDisguised(false);
			}
			$names=Utils::getFakeNames();
			$randname=$names[array_rand($names)];
			foreach($this->plugin->getServer()->getOnlinePlayers() as $online){
				if(Utils::getPlayerDisplayName($online)==$randname or Utils::getPlayerName($online)==$randname){
					$player->sendMessage("§cDisguise failed, name already in use.");
					return;
				}
			}
			$player->setDisguised(true);
			$player->sendMessage("§aYou have been disguised as ".$randname."!");
			$player->setDisplayName($randname);
			foreach($this->plugin->getServer()->getOnlinePlayers() as $online){
				$message=$this->plugin->getStaffUtils()->sendStaffNoti("disguiseon");
				$message=str_replace("{name}", $player->getName(), $message);
				$message=str_replace("{disguise}", $randname, $message);
				if($online->hasPermission("Pandaz.staff.notifications")){
					$online->sendMessage($message);
				}
			}
		}
		if(isset($args[0])){
			switch($args[0]){
				case "off":
				if(!$player->isDisguised()){
					$player->sendMessage("§cYou are not in disguise.");
					return;
				}
				$before=$player->getDisplayName();
				$player->setDisguised(false);
				$player->setDisplayName($player->getName());
				foreach($this->plugin->getServer()->getOnlinePlayers() as $online){
					$message=$this->plugin->getStaffUtils()->sendStaffNoti("disguiseoff");
					$message=str_replace("{name}", $player->getName(), $message);
					$message=str_replace("{disguise}", $before, $message);
					if($online->hasPermission("Pandaz.staff.notifications")){
						$online->sendMessage($message);
					}
				}
				$player->sendMessage("§aDisguise disabled.");
				break;
				default:
				$player->sendMessage("§cYou must provide a valid argument: off");
			}
		}
	}
}