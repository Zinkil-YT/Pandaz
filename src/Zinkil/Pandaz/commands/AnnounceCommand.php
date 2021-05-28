<?php

declare(strict_types=1);

namespace Zinkil\Pandaz\Commands;

use pocketmine\Player;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use Zinkil\Pandaz\Core;

class AnnounceCommand extends PluginCommand{
	
	private $plugin;
	
	public function __construct(Core $plugin){
		parent::__construct("announce", $plugin);
		$this->plugin=$plugin;
		$this->setDescription("§bSend an announcment to all players");
		$this->setPermission("Pandaz.command.announce");
		$this->setAliases(["ano"]);
	}
	public function execute(CommandSender $player, string $commandLabel, array $args){
		if(!$player->hasPermission("Pandaz.command.announce")){
			$player->sendMessage("§cYou cannot execute this command.");
			return;
		}
		if($this->plugin->getDatabaseHandler()->isMuted($player->getName())){
			$player->sendMessage("§cYou are muted.");
			return;
		}
		$message=implode(" ", $args);
		$this->plugin->getServer()->broadcastMessage("§l§bPandaz » §r§c" . $message);
	}
}