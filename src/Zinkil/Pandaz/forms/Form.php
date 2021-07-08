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

namespace Zinkil\Pandaz\forms;

use pocketmine\form\Form as IForm;
use pocketmine\Player;

abstract class Form implements IForm{

    protected $data = [];
    private $callable;

    public function __construct(?callable $callable){
        $this->callable = $callable;
    }

    public function sendToPlayer(Player $player) : void{
        $player->sendForm($this);
    }

    public function getCallable() : ?callable{
        return $this->callable;
    }

    public function setCallable(?callable $callable){
        $this->callable = $callable;
    }

    public function handleResponse(Player $player, $data) : void{
        $this->processData($data);
        $callable = $this->getCallable();
        if($callable !== null) {
            $callable($player, $data);
        }
    }

    public function processData(&$data) : void{
    }

    public function jsonSerialize(){
        return $this->data;
    }
}
