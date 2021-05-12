<?php

declare(strict_types=1);

namespace Zinkil\pc\tasks;

use pocketmine\scheduler\Task;
use Zinkil\pc\managers\PlayerProtectManager as PPM;
use Zinkil\pc\Utils;
use Zinkil\pc\Core;
use pocketmine\Player;
use pocketmine\Server;

class CombatCheckTask extends Task
{
    public function onRun(int $currentTick)
    {
        foreach (PPM::$checkfight as $lol) {
            $time = $lol["time"];
            $player = $lol["player"];
            $p = Utils::getPlayer($player);
            if ($time > 0) {
                PPM::setTime($p, $time - 1);
            } else {
                PPM::delIn($p);
            }
        }
    }
}