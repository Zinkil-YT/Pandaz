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
use Zinkil\Pandaz\tasks\onetime\RestartTask;

class RestartCommand extends PluginCommand{
	
	private $plugin;
	
	public function __construct(Core $plugin){
		parent::__construct("restart", $plugin);
		$this->plugin=$plugin;
		$this->setDescription("§bRestart server command");
		$this->setPermission("Pandaz.command.restart");
	}

	public function execute(CommandSender $player, string $commandLabel, array $args){
		if(!$player->isOp() or !$player->hasPermission("Pandaz.command.restart")){
			$player->sendMessage("§cYou cannot execute this command.");
			return;
		}
		$this->plugin->getServer()->broadcastMessage("§l§bPandaz »§r§a The server will preform a restart (5s) !");
		$this->plugin->getScheduler()->scheduleDelayedRepeatingTask(new RestartTask($this->plugin), 100, 1);
	}
}