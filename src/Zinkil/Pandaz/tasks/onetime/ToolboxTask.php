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

namespace Zinkil\Pandaz\tasks\onetime;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\CorePlayer;
use Zinkil\Pandaz\discord\{Webhook, Message, Embed};

class ToolboxTask extends Task{
	
	public $player;

	public function __construct(Core $plugin, Player $player){
		$this->plugin=$plugin;
		$this->player=$player;
	}

	public function onRun(int $currentTick):void{
		//Discord webhook utils
		$webHook=new Webhook(Core::STAFFWEBHOOK);
		$emessage=new Message();
		$embed=new Embed();
		//Discord webhook event
		$embed->setTitle("Anti-Cheat Alert");
		$embed->setColor(0xFFE500);
		$embed->setDescription("Player name: `".$this->player->getName()."`\nType: `Toolbox Detected`");
		$embed->setFooter(Utils::getTimeExact(), null);
		$emessage->addEmbed($embed);
		$webHook->sendAsync($emessage);
		$this->plugin->getScheduler()->cancelTask($this->getTaskId());
		}
	}
}