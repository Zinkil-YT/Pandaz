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

namespace Zinkil\Pandaz\discord\Embed;


class EmbedField extends EmbedMember{

    private $name;
    private $content;
    private $inline;

    public function __construct(string $name, string $content, bool $inline = false) {
        $this->name = $name;
        $this->content = $content;
        $this->inline = $inline;
    }

    public function Marshal(){
        $this["name"] = $this->name;
        $this["content"] = $this->content;
        $this["inline"] = $this->inline;
    }

    public function UnMarshal(){
        unset($this["name"]);
        unset($this["content"]);
        unset($this["inline"]);
    }

    public function GetMemberName(): string{
        return "field";
    }
}