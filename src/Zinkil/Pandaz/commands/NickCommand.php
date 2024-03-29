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
use pocketmine\utils\TextFormat as TF;
use pocketmine\entity\Skin;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\PlayerListPacket;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\CorePlayer;
use Zinkil\Pandaz\Utils;

class NickCommand extends PluginCommand{
	
	private $plugin;
	
	public function __construct(Core $plugin){
		parent::__construct("nick", $plugin);
		$this->plugin=$plugin;
		$this->setDescription("§bChange your nickname");
		$this->setPermission("Pandaz.command.nick");
	}

	public function execute(CommandSender $player, string $commandLabel, array $args){
		if(!$player instanceof Player){
			return;
		}
		if(!$player->hasPermission("Pandaz.command.nick")){
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
			$player->sendMessage("§cYou must provide a nick.");
			return;
		}
		switch($args[0]){
			case "off":
			$player->setDisplayName($player->getName());
			$player->sendMessage(TF::GREEN."Your are no longer nicked.");
			break;
			default:
			$nick=$args[0];
			foreach($this->plugin->getServer()->getOnlinePlayers() as $online){
				if(strtolower($nick)==strtolower($online->getDisplayName())){
					$player->sendMessage(TF::RED."You cannot use that nick.");
					return;
				}
			}
			if(strlen($nick) < 3){
				$player->sendMessage(TF::RED."Your nick must have more than 3 characters.");
				return;
			}
			if(strlen($nick) > 12){
				$player->sendMessage(TF::RED."Your nick must not have more than 12 characters.");
				return;
			}
			$player->setDisplayName($nick);
			$player->sendMessage(TF::GREEN."You are now nicked as ".$nick.".");
			break;
		}
	}
}