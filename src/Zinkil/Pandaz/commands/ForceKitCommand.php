<?php

declare(strict_types=1);

namespace Zinkil\Pandaz\Commands;

use pocketmine\Player;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\Kits;

class ForceKitCommand extends PluginCommand{
	
	private $plugin;
	
	public function __construct(Core $plugin){
		parent::__construct("forcekit", $plugin);
		$this->plugin=$plugin;
		$this->setDescription("§bGive a kit for a player");
		$this->setPermission("Pandaz.command.forcerank");
	}
	public function execute(CommandSender $player, string $commandLabel, array $args){
		if(!$player->hasPermission("Pandaz.command.forcekit")){
			$player->sendMessage("§cYou cannot execute this command.");
			return;
		}
		if(!isset($args[0])){
			$player->sendMessage("§cYou must provide a player.");
			return;
		}
		if($this->plugin->getServer()->getPlayer($args[0])===null){
			$player->sendMessage("§CorePlayer not found.");
			return;
		}
		if(!isset($args[1])){
			$player->sendMessage("§cProvide a kit. (LOWERCASE)");
			$player->sendMessage("§c- NoDebuff");
			$player->sendMessage("§c- Gapple");
			$player->sendMessage("§c- Combo");
			$player->sendMessage("§c- Fist");
			$player->sendMessage("§c- Resistance");
			$player->sendMessage("§c- SumoFFA");
			$player->sendMessage("§c- KnockBackFFA");
			$player->sendMessage("§c- RushFFA");
			return;
		}
		$target=$this->plugin->getServer()->getPlayer($args[0]);
		$kit=$args[1];
		$player->sendMessage("§a".$target->getName()." was given the ".$kit." kit.");
		Kits::sendKit($target, $kit);
	}
}