<?php

namespace Zinkil\Pandaz\commands;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\CorePlayer;
use Zinkil\Pandaz\Utils;

class AntiCheatCommand extends PluginCommand{
	
	private $plugin;
	
	public function __construct(Core $plugin){
		parent::__construct("anticheat", $plugin);
		$this->plugin=$plugin;
		$this->setDescription("§bEnable or disable anticheat messages");
        $this->setPermission("Pandaz.command.anticheat");
        $this->setAliases(["ac"]);
	}
	public function execute(CommandSender $player, string $commandLabel, array $args){
		if(!$player instanceof Player){
			return;
		}
		if(!$player->hasPermission("Pandaz.command.anticheat")){
			$player->sendMessage("§cYou can't execute this command.");
			return;
		}
		if(!$player->isAntiCheatOn()){
            $this->plugin->getStaffUtils()->anticheat($player, true);
		}else{
			$this->plugin->getStaffUtils()->anticheat($player, false);
		}
	}
}