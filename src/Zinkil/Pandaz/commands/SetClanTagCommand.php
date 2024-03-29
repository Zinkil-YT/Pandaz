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

class SetClanTagCommand extends PluginCommand{
	
	private $plugin;
	
	public function __construct(Core $plugin){
		parent::__construct("setclantag", $plugin);
		$this->plugin=$plugin;
		$this->setDescription("§bSet a clan tag beside a player name");
		$this->setPermission("Pandaz.command.setclantag");
	}

	public function execute(CommandSender $player, string $commandLabel, array $args){
		if(!$player->hasPermission("Pandaz.command.announce")){
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
			$player->sendMessage("§cYou must provide a clan tag.");
			return;
		}
		$target=$this->plugin->getServer()->getPlayer(array_shift($args));
		$message=implode(" ", $args);
		$sn=$player->getDisplayName();
		$tn=$target->getDisplayName();
		if($target instanceof Player){
			if($message=="off"){
				$player->sendMessage("§aYou cleared ".$tn."'s clan tag.");
				$target->sendMessage("§aYour clan tag was cleared.");
				$target->setClanTag("");
			}else{
				$player->sendMessage("§aYou set ".$tn."'s clan tag to ".$message.".");
				$target->sendMessage("§aYour clan tag was set to ".$message.".");
				$target->setClanTag($message." ");
			}
		}
	}
}