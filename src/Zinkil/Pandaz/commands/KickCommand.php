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

class KickCommand extends PluginCommand{
	
	private $plugin;
	
	public function __construct(Core $plugin){
		parent::__construct("kick", $plugin);
		$this->plugin=$plugin;
		$this->setDescription("§bKick a player from the server");
		$this->setPermission("Pandaz.command.kick");
	}

	public function execute(CommandSender $player, string $commandLabel, array $args){
		if(!$player->isOp() or !$player->hasPermission("Pandaz.command.kick")){
			$player->sendMessage("§cYou cannot execute this command.");
			return;
        }
		if(!isset($args[0])){
			$player->sendMessage("§cYou must provide a player.");
			return;
		}
		if($this->plugin->getServer()->getPlayer($args[0])===null){
			$player->sendMessage("§cPlayer not found.");
			return;
		}
		$target=$this->plugin->getServer()->getPlayer($args[0]);
		if($target->getName()==$player->getName()){
			$player->sendMessage("§cYou cannot kick yourself.");
			return;
		}
		if(count($args) < 2){
			$player->sendMessage("§cYou must provide a reason.");
			return;
		}
		if($target->isOp() or $target->hasPermission("Pandaz.command.kick")){
			$player->sendMessage("§cYou cannot kick this player.");
			return;
	    }
		$target=$this->plugin->getServer()->getPlayer($args[0]);
		$reason=implode(" ", $args);
		if(!$target->isOp()){
			$target->kick("§r§cYou were kicked by §r§e".$player->getName()."\n§r§cReason: §r§e".$reason, false);
		    $this->plugin->getServer()->broadcastMessage("§r§c".$target->getName()." §r§ewas kicked by §r§a".$player->getName()."\n§r§cReason: §r§e".$reason);
	    }
		$message=$this->plugin->getStaffUtils()->sendStaffNoti("kick");
		$message=str_replace("{name}", $player->getName(), $message);
		$message=str_replace("{target}", $target->getName(), $message);
		$message=str_replace("{reason}", $args[1], $message);
		foreach($this->plugin->getServer()->getOnlinePlayers() as $online){
			if($online->hasPermission("Pandaz.staff.notifications")){
				$online->sendMessage($message);
			}
		}
	}
}