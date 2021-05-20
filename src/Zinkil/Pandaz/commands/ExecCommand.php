<?php

declare(strict_types=1);

namespace Zinkil\Pandaz\Commands;

use pocketmine\Player;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\Utils;

class ExecCommand extends PluginCommand{
	
	private $plugin;
	
	public function __construct(Core $plugin){
		parent::__construct("exec", $plugin);
		$this->plugin=$plugin;
		$this->setDescription("§bExecute database commands");
		$this->setPermission("Pandaz.command.exec");
	}
	public function execute(CommandSender $player, string $commandLabel, array $args){
		if($player instanceof Player){
			return;
		}
		if(!$player->hasPermission("Pandaz.command.exec")){
			return;
		}
		Utils::offerVoteRewards(implode(" ", $args));
	}
}