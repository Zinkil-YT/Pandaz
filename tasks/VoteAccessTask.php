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

namespace Zinkil\Pandaz\tasks;

use pocketmine\scheduler\Task;
use Zinkil\Pandaz\Core;

class VoteAccessTask extends Task{
	
	public function __construct(Core $plugin){
		$this->plugin=$plugin;
	}

	public function onRun(int $tick):void{
		$query=$this->plugin->main->query("SELECT * FROM voteaccess ORDER BY duration ASC;");
		$result=$query->fetchArray(SQLITE3_ASSOC);
		$now=time();
		if(!empty($result)){
			$players=$result['player'];
			$duration=$result['duration'];
			if($now>=$duration){
				$target=Core::getInstance()->getServer()->getPlayerExact($players);
				if($target!==null){
					$this->plugin->main->query("DELETE FROM voteaccess WHERE player='".$target->getName()."'");
					$target->sendMessage("§cYour voter access has expired, you can vote again at ".$this->plugin->getVote()." to re-claim it as well as your rewards.");
					$this->plugin->getLogger()->notice($target->getName()."'s voter access has expired.");
				}else{
					if(!is_null($players)){
						$this->plugin->main->query("DELETE FROM voteaccess WHERE player='".$players."'");
						$this->plugin->getLogger()->notice($players."'s voter access has expired.");
					}
				}
				$message=$this->plugin->getStaffUtils()->sendStaffNoti("voteraccessexpire");
				$message=str_replace("{target}", $players, $message);
				foreach($this->plugin->getServer()->getOnlinePlayers() as $online){
					if($online->hasPermission("Pandaz.staff.notifications")){
						$online->sendMessage($message);
					}
				}
			}
		}
	}
}