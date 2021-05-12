<?php

namespace Zinkil\pc\managers;

use pocketmine\Server;
use pocketmine\Player;

class PlayerProtectManager{

    public static $infight = [];
    public static $checkfight = [];

    public static function isIn(Player $player){
        if(in_array($player->getName(),self::$infight)){
            return true;
        }else{
            return false;
        }
    }

    public static function getIn(Player $player){
        return self::$infight[$player->getName()];
    }

    public static function setIn(Player $player, Player $damager){
        self::$infight[$player->getName()] = $damager->getName();
        self::$infight[$damager->getName()] = $player->getName();

        self::$checkfight[$player->getName()] =  ["time"=>10, "player"=>$damager->getName()];
        self::$checkfight[$damager->getName()] = ["time"=>10, "player"=>$damager->getName()];
    }

    public static function setTime(Player $player, int $time){
        self::$checkfight[$player->getName()]["time"] = $time;
    }
       
    public static function delIn(Player $player){
        $vktm = self::$infight[$player->getName()];
        unset(self::$infight[$vktm]);
        unset(self::$infight[$player->getName()]);

        unset(self::$checkfight[$vktm]);
        unset(self::$checkfight[$player->getName()]);
    }
}