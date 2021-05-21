<?php

declare(strict_types=1);

namespace Zinkil\Pandaz\tasks;

use pocketmine\scheduler\Task;
use Zinkil\Pandaz\managers\PlayerProtectManager as PPM;
use Zinkil\Pandaz\Utils;
use Zinkil\Pandaz\Core;
use pocketmine\Player;
use pocketmine\Server;

class CombatCheckTask extends Task
{
    public function __construct(Core $plugin){
        $this->plugin=$plugin;
    }
    public function onRun(int $currentTick)
    {
        foreach (PPM::$checkfight as $chk) {
            $time = $chk["time"];
            $player = $chk["player"];
            $p = Utils::getPlayerName($player);
            if ($time > 0) {
                PPM::setTime($p, $time - 1);
                $p->sendPopup("§7You will be able toss change your opponent in §c".$time."§7 seconds."));
            } else {
                PPM::delIn($p);
            }
        }
    }
}