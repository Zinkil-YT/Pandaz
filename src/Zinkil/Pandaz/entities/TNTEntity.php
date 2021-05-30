<?php

declare(strict_types=1);

namespace Zinkil\Pandaz\entities;

use pocketmine\entity\object\PrimedTNT;
use pocketmine\entity\Entity;
use Zinkil\Pandaz\Core;
use core\level\Explosion;
use pocketmine\event\entity\ExplosionPrimeEvent;

class TNTEntity extends PrimedTNT{

    public function entityBaseTick(int $tickDiff=1):bool{
        $this->setNameTag("§l§4Time: ".$this->fuse);
        $this->setNameTagVisible();
        $this->setNameTagAlwaysVisible();
        return parent::entityBaseTick($tickDiff);
    }
}