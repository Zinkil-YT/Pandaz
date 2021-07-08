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

class EmbedFields extends EmbedMember{

    private $fields;

    public function __construct(EmbedField ...$fields){
        $this->fields = $fields;
    }

    public function Marshal(){
        foreach ($this->fields as $field){
            $field->Marshal();
        }
    }

    public function UnMarshal(){
        foreach ($this->fields as $field){
            $field->UnMarshal();
        }
    }

    public function GetMemberName(): string{
        return "fields";
    }
}