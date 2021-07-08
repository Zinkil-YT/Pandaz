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

namespace Zinkil\Pandaz\tasks;

use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use Zinkil\Pandaz\discord\Message;
use Zinkil\Pandaz\discord\Webhook;

class DiscordTask extends AsyncTask{
	
	protected $webhook;
	protected $message;
	
	public function __construct(Webhook $webhook, Message $message){
		$this->webhook=$webhook;
		$this->message=$message;
	}

	public function onRun(){
		$web=curl_init($this->webhook->getURL());
		curl_setopt($web, CURLOPT_POSTFIELDS, json_encode($this->message));
		curl_setopt($web, CURLOPT_POST,true);
		curl_setopt($web, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($web, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($web, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($web, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		$this->setResult(curl_exec($web));
		curl_close($web);
	}

	public function onCompletion(Server $server){
		$response=$this->getResult();
		if($response!==""){
			Server::getInstance()->getLogger()->error("[Pandaz-Discord] Got error: " . $response);
		}
	}
}