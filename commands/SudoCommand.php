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
use Zinkil\Pandaz\StaffUtils;

class SudoCommand extends PluginCommand{
	
	private $plugin;

	public function __construct(Core $plugin){
		parent::__construct("sudo", $plugin);
		$this->plugin=$plugin;
		$this->setDescription("§bExcute commands or send messages as another player");
		$this->setPermission("Pandaz.command.sudo");
	}

	public function execute(CommandSender $player, string $commandLabel, array $args){
		if(!$player->isOp() or !$player->hasPermission("Pandaz.command.sudo")){
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
	    if(count($args) < 2){
			$player->sendMessage("§cYou must provide a command or a message.");
			return;
		}
		$target=$this->plugin->getServer()->getPlayer(array_shift($args));
		if($target->isOp() or $target->hasPermission("Pandaz.command.sudo")){
			$player->sendMessage("§cYou cannot sudo this player.");
			return;
	    }
		$target=$this->plugin->getServer()->getPlayer(array_shift($args));
		$pn=$player->getName();
		$tn=$target->getName();
		$cmd=implode(" ", $args); //or the message
        if($target instanceof Player){
            $target->chat(trim(implode(" ", $args)));
            return;
        }
		$message=$this->plugin->getStaffUtils()->sendStaffNoti("sudo");
		$message=str_replace("{name}", $player->getName(), $message);
		$message=str_replace("{target}", $target->getName(), $message);
		foreach($this->plugin->getServer()->getOnlinePlayers() as $online){
			if($online->hasPermission("Pandaz.staff.notifications")){
				$online->sendMessage($message);
			}
		}
	}
}