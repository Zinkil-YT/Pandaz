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

class MotdTask extends Task{
	
	public function __construct(Core $plugin){
		$this->plugin=$plugin;
		$this->line=-1;
	}

	public function onRun(int $tick):void{
		$motd=[
		"§l§bPANDAZ » §r§3Season 1",
		"§l§dNEW » §r§eAnti-Toolbox",
		"§l§cEU » §r§fPractice"
		];
		$this->line++;
		$msg=$motd[$this->line];
		$this->plugin->getServer()->getNetwork()->setName($msg);
		if($this->line===count($motd) - 1) $this->line = -1;
	}
}