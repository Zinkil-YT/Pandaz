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
use pocketmine\level\Position;
use Zinkil\Pandaz\Core;

class TpallCommand extends PluginCommand{
	
	private $plugin;
	
	public function __construct(Core $plugin){
		parent::__construct("tpall", $plugin);
		$this->plugin=$plugin;
		$this->setDescription("§bTeleport all players on the server to you");
		$this->setPermission("Pandaz.command.tpall");
	}

	public function execute(CommandSender $player, string $commandLabel, array $args){
		if(!$player->hasPermission("Pandaz.command.tpall")){
			$player->sendMessage("§cYou cannot execute this command.");
			return;
		}
		foreach($this->plugin->getServer()->getOnlinePlayers() as $online){
			if($online->getName()!=$player->getName() and count($this->plugin->getServer()->getOnlinePlayers()) > 1){
				$online->teleport(new Position($player->getX(), $player->getY(), $player->getZ(), $player->getLevel()));
			}
		}
		$player->sendMessage("§aAll players have been teleported to you.");
		$message=$this->plugin->getStaffUtils()->sendStaffNoti("tpall");
		$message=str_replace("{name}", $player->getName(), $message);
		foreach($this->plugin->getServer()->getOnlinePlayers() as $online){
			if($online->hasPermission("Pandaz.staff.notifications")){
				$online->sendMessage($message);
			}
		}
	}
}