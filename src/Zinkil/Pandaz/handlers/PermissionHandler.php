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

namespace Zinkil\Pandaz\handlers;

use pocketmine\Player;
use pocketmine\Server;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\Utils;

class PermissionHandler{
	
	private $plugin;

	public function __construct(){
		$this->plugin=Core::getInstance();
	}

	public function addPermission(Player $player, string $rank){
		switch($rank){
			case "Player":
			return;
			break;
			case "Voter":
			$player->addAttachment($this->plugin, "Pandaz.command.fly", true);
			break;
			case "VIP":
			$player->addAttachment($this->plugin, "Pandaz.command.fly", true);
			break;
			case "Elite":
			$player->addAttachment($this->plugin, "Pandaz.command.fly", true);
			break;
			case "Premium":
			$player->addAttachment($this->plugin, "Pandaz.command.fly", true);
			break;
			case "Booster":
			$player->addAttachment($this->plugin, "Pandaz.command.fly", true);
			break;
			case "YouTube":
			$player->addAttachment($this->plugin, "Pandaz.command.disguise", true);
			$player->addAttachment($this->plugin, "Pandaz.command.fly", true);
			break;
			case "Famous":
			$player->addAttachment($this->plugin, "Pandaz.command.disguise", true);
			$player->addAttachment($this->plugin, "Pandaz.command.fly", true);
			break;
			case "Builder":
			$player->addAttachment($this->plugin, "Pandaz.access.staffchat", true);
			$player->addAttachment($this->plugin, "Pandaz.command.gm", true);
			$player->addAttachment($this->plugin, "Pandaz.can.build", true);
			$player->addAttachment($this->plugin, "Pandaz.can.break", true);
			break;
			case "Trainee":
			$player->addAttachment($this->plugin, "Pandaz.command.staff", true);
			$player->addAttachment($this->plugin, "Pandaz.access.staffchat", true);
			$player->addAttachment($this->plugin, "Pandaz.command.vanish", true);
			$player->addAttachment($this->plugin, "Pandaz.command.tban", true);
			$player->addAttachment($this->plugin, "Pandaz.command.mute", true);
			$player->addAttachment($this->plugin, "Pandaz.command.freeze", true);
			$player->addAttachment($this->plugin, "Pandaz.staff.cheatalerts", true);
			$player->addAttachment($this->plugin, "Pandaz.bypass.toxic", true);
			break;
			case "Helper":
			$player->addAttachment($this->plugin, "Pandaz.command.staff", true);
			$player->addAttachment($this->plugin, "Pandaz.access.staffchat", true);
			$player->addAttachment($this->plugin, "Pandaz.command.vanish", true);
			$player->addAttachment($this->plugin, "Pandaz.command.tban", true);
			$player->addAttachment($this->plugin, "Pandaz.command.mute", true);
			$player->addAttachment($this->plugin, "Pandaz.command.who", true);
			$player->addAttachment($this->plugin, "Pandaz.command.freeze", true);
			$player->addAttachment($this->plugin, "Pandaz.staff.cheatalerts", true);
			$player->addAttachment($this->plugin, "Pandaz.command.alias", true);
			$player->addAttachment($this->plugin, "pocketmine.command.teleport", true);
			$player->addAttachment($this->plugin, "Pandaz.bypass.advertising", true);
			$player->addAttachment($this->plugin, "Pandaz.bypass.swearing", true);
			$player->addAttachment($this->plugin, "Pandaz.bypass.toxic", true);
			$player->addAttachment($this->plugin, "Pandaz.command.kick", true);
			break;
			case "Mod":
			$player->addAttachment($this->plugin, "Pandaz.command.alias", true);
			$player->addAttachment($this->plugin, "Pandaz.command.staff", true);
			$player->addAttachment($this->plugin, "Pandaz.access.staffchat", true);
			$player->addAttachment($this->plugin, "Pandaz.command.online", true);
			$player->addAttachment($this->plugin, "Pandaz.command.disguise", true);
			$player->addAttachment($this->plugin, "Pandaz.command.tban", true);
			$player->addAttachment($this->plugin, "Pandaz.command.mute", true);
			$player->addAttachment($this->plugin, "Pandaz.command.freeze", true);
			$player->addAttachment($this->plugin, "Pandaz.command.who", true);
			$player->addAttachment($this->plugin, "Pandaz.command.gm", true);
			$player->addAttachment($this->plugin, "Pandaz.command.vanish", true);
			$player->addAttachment($this->plugin, "Pandaz.staff.cheatalerts", true);
			$player->addAttachment($this->plugin, "pocketmine.command.teleport", true);
			$player->addAttachment($this->plugin, "pocketmine.command.kick", true);
			$player->addAttachment($this->plugin, "Pandaz.bypass.advertising", true);
			$player->addAttachment($this->plugin, "Pandaz.bypass.swearing", true);
			$player->addAttachment($this->plugin, "Pandaz.bypass.toxic", true);
			$player->addAttachment($this->plugin, "Pandaz.command.kick", true);
			break;
			case "HeadMod":
			$player->addAttachment($this->plugin, "Pandaz.command.alias", true);
			$player->addAttachment($this->plugin, "Pandaz.command.staff", true);
			$player->addAttachment($this->plugin, "Pandaz.access.staffchat", true);
			$player->addAttachment($this->plugin, "Pandaz.command.online", true);
			$player->addAttachment($this->plugin, "Pandaz.command.disguise", true);
			$player->addAttachment($this->plugin, "Pandaz.command.messages", true);
			$player->addAttachment($this->plugin, "Pandaz.command.tban", true);
			$player->addAttachment($this->plugin, "Pandaz.command.online", true);
			$player->addAttachment($this->plugin, "Pandaz.command.mute", true);
			$player->addAttachment($this->plugin, "Pandaz.command.freeze", true);
			$player->addAttachment($this->plugin, "Pandaz.command.who", true);
			$player->addAttachment($this->plugin, "Pandaz.command.gm", true);
			$player->addAttachment($this->plugin, "pocketmine.command.time", true);
			$player->addAttachment($this->plugin, "Pandaz.bypass.vanishsee", true);
			$player->addAttachment($this->plugin, "Pandaz.command.vanish", true);
			$player->addAttachment($this->plugin, "Pandaz.staff.cheatalerts", true);
			$player->addAttachment($this->plugin, "pocketmine.command.teleport", true);
			$player->addAttachment($this->plugin, "pocketmine.command.kick", true);
			$player->addAttachment($this->plugin, "Pandaz.bypass.advertising", true);
			$player->addAttachment($this->plugin, "Pandaz.bypass.swearing", true);
			$player->addAttachment($this->plugin, "Pandaz.bypass.toxic", true);
			$player->addAttachment($this->plugin, "Pandaz.command.kick", true);
			break;
			case "Admin":
			$player->addAttachment($this->plugin, "Pandaz.command.alias", true);
			$player->addAttachment($this->plugin, "Pandaz.command.staff", true);
			$player->addAttachment($this->plugin, "Pandaz.access.staffchat", true);
			$player->addAttachment($this->plugin, "Pandaz.command.online", true);
			$player->addAttachment($this->plugin, "Pandaz.command.disguise", true);
			$player->addAttachment($this->plugin, "Pandaz.command.messages", true);
			$player->addAttachment($this->plugin, "Pandaz.command.who", true);
			$player->addAttachment($this->plugin, "Pandaz.command.freeze", true);
			$player->addAttachment($this->plugin, "Pandaz.command.gm", true);
			$player->addAttachment($this->plugin, "Pandaz.command.gmother", true);
			$player->addAttachment($this->plugin, "Pandaz.command.rank", true);
			$player->addAttachment($this->plugin, "Pandaz.command.tban", true);
			$player->addAttachment($this->plugin, "Pandaz.command.mute", true);
			$player->addAttachment($this->plugin, "Pandaz.command.vanish", true);
			$player->addAttachment($this->plugin, "Pandaz.bypass.vanishsee", true);
			$player->addAttachment($this->plugin, "Pandaz.staff.cheatalerts", true);
			$player->addAttachment($this->plugin, "Pandaz.staff.notifications", true);
			$player->addAttachment($this->plugin, "Pandaz.bypass.chatcooldown", true);
			$player->addAttachment($this->plugin, "Pandaz.bypass.chatsilence", true);
			$player->addAttachment($this->plugin, "Pandaz.bypass.combatcommand", true);
			$player->addAttachment($this->plugin, "pocketmine.command.teleport", true);
			$player->addAttachment($this->plugin, "pocketmine.command.give", true);
			$player->addAttachment($this->plugin, "pocketmine.command.kick", true);
			$player->addAttachment($this->plugin, "pocketmine.command.ban", true);
			$player->addAttachment($this->plugin, "pocketmine.command.pardon", true);
			$player->addAttachment($this->plugin, "pocketmine.command.time", true);
			$player->addAttachment($this->plugin, "Pandaz.bypass.advertising", true);
			$player->addAttachment($this->plugin, "Pandaz.bypass.swearing", true);
			$player->addAttachment($this->plugin, "Pandaz.bypass.toxic", true);
			$player->addAttachment($this->plugin, "Pandaz.command.kick", true);
			$player->addAttachment($this->plugin, "Pandaz.command.restart", true);
			break;
			case "Manager":
			$player->addAttachment($this->plugin, "Pandaz.command.mutechat", true);
			$player->addAttachment($this->plugin, "Pandaz.command.alias", true);
			$player->addAttachment($this->plugin, "Pandaz.command.staff", true);
			$player->addAttachment($this->plugin, "Pandaz.access.staffchat", true);
			$player->addAttachment($this->plugin, "Pandaz.command.online", true);
			$player->addAttachment($this->plugin, "Pandaz.command.disguise", true);
			$player->addAttachment($this->plugin, "Pandaz.command.messages", true);
			$player->addAttachment($this->plugin, "Pandaz.command.who", true);
			$player->addAttachment($this->plugin, "Pandaz.command.announce", true);
			$player->addAttachment($this->plugin, "Pandaz.command.pban", true);
			$player->addAttachment($this->plugin, "Pandaz.command.tban", true);
			$player->addAttachment($this->plugin, "Pandaz.command.mute", true);
			$player->addAttachment($this->plugin, "Pandaz.command.coords", true);
			$player->addAttachment($this->plugin, "Pandaz.command.freeze", true);
			$player->addAttachment($this->plugin, "Pandaz.command.gm", true);
			$player->addAttachment($this->plugin, "Pandaz.command.gmother", true);
			$player->addAttachment($this->plugin, "Pandaz.command.rank", true);
			$player->addAttachment($this->plugin, "Pandaz.command.tban", true);
			$player->addAttachment($this->plugin, "Pandaz.command.vanish", true);
			$player->addAttachment($this->plugin, "Pandaz.bypass.vanishsee", true);
			$player->addAttachment($this->plugin, "Pandaz.staff.cheatalerts", true);
			$player->addAttachment($this->plugin, "Pandaz.staff.notifications", true);
			$player->addAttachment($this->plugin, "Pandaz.bypass.chatcooldown", true);
			$player->addAttachment($this->plugin, "Pandaz.bypass.chatsilence", true);
			$player->addAttachment($this->plugin, "Pandaz.bypass.combatcommand", true);
			$player->addAttachment($this->plugin, "pocketmine.command.teleport", true);
			$player->addAttachment($this->plugin, "pocketmine.command.give", true);
			$player->addAttachment($this->plugin, "pocketmine.command.kick", true);
			$player->addAttachment($this->plugin, "pocketmine.command.ban", true);
			$player->addAttachment($this->plugin, "pocketmine.command.pardon", true);
			$player->addAttachment($this->plugin, "pocketmine.command.time", true);
			$player->addAttachment($this->plugin, "Pandaz.bypass.advertising", true);
			$player->addAttachment($this->plugin, "Pandaz.bypass.swearing", true);
			$player->addAttachment($this->plugin, "Pandaz.bypass.toxic", true);
			$player->addAttachment($this->plugin, "Pandaz.command.kick", true);
			$player->addAttachment($this->plugin, "Pandaz.command.restart", true);
			break;
			case "Owner":
			return;
			break;
		}
	}
}
