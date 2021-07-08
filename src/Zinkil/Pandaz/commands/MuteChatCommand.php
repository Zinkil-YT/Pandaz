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

namespace Zinkil\Pandaz\commands;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\Utils;

class MuteChatCommand extends PluginCommand{
	
	private $plugin;
	
	public function __construct(Core $plugin){
		parent::__construct("mutechat", $plugin);
		$this->plugin=$plugin;
		$this->setDescription("§bMute the server global chat");
		$this->setPermission("Pandaz.command.mutechat");
		$this->setAliases(["muteall", "silence"]);
	}

	public function execute(CommandSender $player, string $commandLabel, array $args){
		if(!$player->hasPermission("Pandaz.command.mutechat")){
			$player->sendMessage("§cYou cannot execute this command.");
			return;
		}
		if(!isset($args[0])){
			$player->sendMessage("§cProvide an argument: on:off");
			return true;
		}
		if(isset($args[0])){
			switch($args[0]){
				case "on":
				if(Utils::getGlobalMute()===true){
					$player->sendMessage("§cChat is already silenced.");
					return;
				}
				Utils::setGlobalMute(true);
				$this->plugin->getServer()->broadcastMessage("§b".$player->getName()." silenced chat.");
				break;
				case "off":
				if(Utils::getGlobalMute()===false){
					$player->sendMessage("§cChat is not silenced.");
					return;
				}
				Utils::setGlobalMute(false);
				$this->plugin->getServer()->broadcastMessage("§b".$player->getName()." unsilenced chat.");
				break;
				default:
				$player->sendMessage("§cProvide a valid argument: on:off");
			}
		}
	}
}