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

class ReplyCommand extends PluginCommand{
	
	private $plugin;
	
	public function __construct(Core $plugin){
		parent::__construct("reply", $plugin);
		$this->plugin=$plugin;
		$this->setDescription("§bReply to someone message");
		$this->setAliases(["r"]);
	}

	public function execute(CommandSender $player, string $commandLabel, array $args){
		if(!$player instanceof Player){
			return;
		}
		if(!$player->hasRe()){
			$player->sendMessage("§cYou have no one to reply to.");
			return;
		}
		if(count($args) < 1){
			$player->sendMessage("§cYou must provide a message.");
			return;
		}
		$target=$player->getRe();
		$message=implode(" ", $args);
		$sn=$player->getDisplayName();
		$tn=$target->getDisplayName();
		if($target instanceof Player){
			$player->sendMessage("§7(To §f".$tn."§7) ".$message);
			$target->sendMessage("§7(From §f".$sn."§7) ".$message);
			$target->setRe($player);
		}
		foreach($this->plugin->getServer()->getOnlinePlayers() as $online){
			if($online->isMessages()){
				$online->sendMessage("§8[STAFF] §7(From §f".$sn." §7To §f".$tn."§7) ".$message);
			}
		}
	}
}