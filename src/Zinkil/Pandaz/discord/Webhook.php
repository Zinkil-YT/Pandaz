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

namespace Zinkil\Pandaz\discord;

use Zinkil\Pandaz\discord\Tasks\WebhookTask;
use pocketmine\Server;

class Webhook{

	protected $url; 

	public function __construct(string $url){
		$this->url = $url;
	}

	public function getURL():string{
		return $this->url;
	}

	public function isValid(): bool {
		return filter_var($this->url, FILTER_VALIDATE_URL)!==false;
	}

	public function sendAsync(Message $message) {
		Server::getInstance()->getAsyncPool()->submitTask(new WebhookTask($this, $message));
	}

	public function send(Message $message): bool {
        $ch = curl_init($this->getURL());
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
        curl_setopt($ch, CURLOPT_POST,true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        $return = curl_exec($ch);
        curl_close($ch);
        return $return;
    }
}