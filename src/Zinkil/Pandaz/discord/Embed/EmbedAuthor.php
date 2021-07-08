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

class EmbedAuthor extends EmbedMember{

    private $name;
    private $url;
    private $iconurl;

    public function __construct(string $name, string $url = null, string $iconurl = null) {
        $this->name = $name;
        $this->url = $url;
        $this->iconurl = $iconurl;
    }

    public function Marshal(){
        $this["name"] = $this->name;
        $this["url"] = $this->url;
        $this["icon_url"] = $this->iconurl;
    }

    public function UnMarshal(){
        unset($this["name"]);
        unset($this["url"]);
        unset($this["icon_url"]);
    }

    public function GetMemberName(): string{
        return "author";
    }
}