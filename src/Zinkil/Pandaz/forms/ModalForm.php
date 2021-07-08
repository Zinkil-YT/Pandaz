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

class ModalForm extends Form {

    private $content = "";

    public function __construct(?callable $callable){
        parent::__construct($callable);
        $this->data["type"] = "modal";
        $this->data["title"] = "";
        $this->data["content"] = $this->content;
        $this->data["button1"] = "";
        $this->data["button2"] = "";
    }

    public function setTitle(string $title) : void{
        $this->data["title"] = $title;
    }

    public function getTitle() : string{
        return $this->data["title"];
    }

    public function getContent() : string{
        return $this->data["content"];
    }

    public function setContent(string $content) : void{
        $this->data["content"] = $content;
    }

    public function setButton1(string $text) : void{
        $this->data["button1"] = $text;
    }

    public function getButton1() : string{
        return $this->data["button1"];
    }

    public function setButton2(string $text) : void{
        $this->data["button2"] = $text;
    }

    public function getButton2() : string{
        return $this->data["button2"];
    }
}
