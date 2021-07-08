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
use Zinkil\Pandaz\Utils;

class PingCommand extends PluginCommand{
	
	private $plugin;
	
	public function __construct(Core $plugin){
		parent::__construct("ping", $plugin);
		$this->plugin=$plugin;
		$this->setDescription("§bGet a player ping");
		$this->setAliases(["ms"]);
	}

	public function execute(CommandSender $player, string $commandLabel, array $args){
		if(!isset($args[0]) and $player instanceof Player){
			$player->sendMessage("§l§aPing » §r§2Your ping is ".$player->getPing()."ms.");
			return;
		}
		if(isset($args[0]) and $target=$this->plugin->getServer()->getPlayer($args[0])===null){
			$player->sendMessage("§cPlayer not found.");
			return;
		}
		$target=$this->plugin->getServer()->getPlayer($args[0]);
		if($target instanceof Player){
			$player->sendMessage("§l§aPing » §r§2".$target->getName()."'s ping is ".$target->getPing()."ms.");
		}
	}
}