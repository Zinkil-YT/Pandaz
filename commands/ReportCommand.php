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
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\Utils;
use Zinkil\Pandaz\CorePlayer;
use Zinkil\Pandaz\discord\{Webhook, Message, Embed};

class ReportCommand extends PluginCommand{
	
	private $plugin;
	private $pcooldown;
    public $repr;
	
	public function __construct(Core $plugin){
		parent::__construct("report", $plugin);
		$this->plugin=$plugin;
		$this->setDescription("§bReport a player on the server");
	}

	public function execute(CommandSender $player, string $commandLabel, array $args){
        $ccooldown = 2000;
        if (isset($this->pcooldown[$player->getName()]) and time() - $this->pcooldown[$player->getName()] < $ccooldown){
            $time = time() - $this->pcooldown[$player->getName()];
            $message = "§cYou are on cooldown for this command for {cooldown} more seconds.";
            $message = str_replace("{cooldown}", ($ccooldown - $time), $message);
            $player->sendMessage($message);
        }else{
            if(!isset($args[0])){
				$player->sendMessage("§cYou must provide a player.");
				return;
			}
			if($this->plugin->getServer()->getPlayer($args[0])===null){
				$player->sendMessage("§cPlayer not found.");
				return;
			}
			$target=$this->plugin->getServer()->getPlayer(array_shift($args));
			if($target->getName()==$player->getName()){
				$player->sendMessage("§cYou cannot report yourself.");
				return;
			}
			if(count($args) < 2){
				$player->sendMessage("§cYou must provide a reason.");
				return;
			}
			$target=$this->plugin->getServer()->getPlayer(array_shift($args));
			$pn=$player->getName();
			$tn=$target->getName();
			$reason=implode(" ", $args);
			//Discord webhook utils
		    $webHook=new Webhook(Core::STAFFWEBHOOK);
		    $emessage=new Message();
		    $embed=new Embed();
            $this->pcooldown[$player->getName()] = time();
			//Discord webhook event
			$embed->setTitle("Report Alert");
			$embed->setColor(0x38FFFB);
			$embed->setDescription("Reported Player: `".$target->getName()."`\nReason: `".$reason."`");
			$embed->setFooter(Utils::getTimeExact(), null);
			$emessage->addEmbed($embed);
			$webHook->sendAsync($emessage);
            $player->sendMessage("§aReport was sent to Staff, Help is on the way!");
			foreach($this->plugin->getServer()->getOnlinePlayers() as $staff){
				if($staff->isOp()){
					$staff->sendMessage($player->getName()."§r§e Reported §r§c".$target->getName()."\n§r§eReason: §r§b".$reason);
				}
			}
		}
	}
}