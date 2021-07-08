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
use pocketmine\Server;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use Zinkil\Pandaz\forms\{SimpleForm, CustomForm, ModalForm};
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\Utils;

class InformationCommand extends PluginCommand{
	
	private $plugin;
	
	public function __construct(Core $plugin){
		parent::__construct("information", $plugin);
		$this->plugin=$plugin;
		$this->setDescription("§bGet information about server");
		$this->setAliases(["info","about","server"]);
	}

	public function execute(CommandSender $player, string $commandLabel, array $args){
		$this->informationForm($player);
	}

	public function informationForm(Player $player):void{
		$form=new SimpleForm(function(Player $player, $data=null):void{
			switch($data){
				case "exit":
				$player->sendMessage("§dHave a nice day.");
				break;
			}
		});
		$form->setTitle("§l§eInformation");
		$form->setContent("");
		$form->addButton("Exit", -1, "", "exit");
		$player->sendForm($form);
	}
}