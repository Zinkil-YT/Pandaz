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

class KickAllCommand extends PluginCommand{
	
	private $plugin;
	
	public function __construct(Core $plugin){
		parent::__construct("kickall", $plugin);
		$this->plugin=$plugin;
		$this->setDescription("§bKick all players on the server");
		$this->setPermission("Pandaz.command.kickall");
	}

	public function execute(CommandSender $player, string $commandLabel, array $args){
		if(!$player->isOp()){
			$player->sendMessage("§cYou cannot execute this command.");
			return;
        }
        foreach($this->plugin->getServer()->getOnlinePlayers() as $online){
            if(!$online->isOp()){
                $online->kick("§6Everyone has been kicked, you may rejoin soon.", false);
            }
        }
	}
}