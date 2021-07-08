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

namespace Zinkil\Pandaz\misc;

class Countries{
    public static function getCountry(string $ip) : string{
        $query = @unserialize(file_get_contents("http://ip-api.com/php/". $ip));
        if ($query["status"] === "success") {
            $cc = strtolower($query["countryCode"]);
            if (in_array($cc, array("en","us"))) {
                return "en";
            } else if (in_array($cc, array("fr","be","lu","ca","ch"))) {
                return "fr";
            } else if (in_array($cc, array("es","br","me"))) {
                return "es";
            } else if (in_array($cc, array("de"))) {
                return "de";
            }
        }
        return "en";
    }
}