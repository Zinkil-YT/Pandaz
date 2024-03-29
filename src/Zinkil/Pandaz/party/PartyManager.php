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

namespace Zinkil\Pandaz\party;

use pocketmine\Player;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\Utils;
use Zinkil\Pandaz\party\{Party, PartyInvite};

class PartyManager{
	
	public static function createParty($player){
		if($player instanceof Player) $player=$player->getName();
		$capacity=8;
		$p=Utils::getPlayer($player);
		$rank=$p->getRank();
		if($p->isTrainee() or $p->isHelper() or $p->isMod()) $capacity=18;
		if($p->isAdmin() or $p->isManager() or $p->isOwner()) $capacity=20;
		if($p->isMedia()) $capacity=10;
		if($p->isVip()) $capacity=12;
		if($p->isElite()) $capacity=14;
		if($p->isPremium()) $capacity=16;
		$party=new Party($player, $player, [$player], $capacity, false, Party::IDLE);
		Core::getInstance()->parties[]=$party;
		$p->setParty($party);
		$p->setPartyRank(Party::LEADER);
		$p->sendMessage("§aYour party was created.");
		$party->sendMessage("Welcome to your party, use * before your message to type in party chat.");
	}

	public static function getParty($party){
		$result=null;
		foreach(Core::getInstance()->parties as $parties){
			$name=$parties->getName();
			if($name==$party){
				$result=$parties;
			}
		}
		return $result;
	}

	public static function getPartyFromPlayer($player){
		$result=null;
		if(isset($player) and !is_null($player)){
			if($player instanceof Player) $player=$player->getName();
			foreach(Core::getInstance()->parties as $party){
				if($party->isMember($player) or $party->isLeader($player)){
					$result=$party;
				}
			}
		}
		return $result;
	}

	public static function getPartyIndexOf(Party $party){
		$index=array_search($party, Core::getInstance()->parties);
		if(is_bool($index) and $index===false){
			$index=-1;
		}
		return $index;
	}

	public static function doesPartyExist(Party $party):bool{
		return self::getPartyIndexOf($party) !== -1;
	}

	public static function invitePlayer($party, $sender, $target){
		if($sender instanceof Player) $sender=$sender->getName();
		if($target instanceof Player) $target=$target->getName();
		$invite=new PartyInvite($party, $sender, $target);
		Core::getInstance()->partyinvites[]=$invite;
		$sender=Utils::getPlayer($sender);
		$target=Utils::getPlayer($target);
		$sender->sendMessage("§aYou invited ".$target->getDisplayName()." to your party.");
		$target->sendMessage("§a".$sender->getDisplayName()." invited you to their party.");
	}

	public static function getInvite($invite){
		$result=null;
		foreach(Core::getInstance()->partyinvites as $invites){
			$name=$invites->getParty()->getName();
			if($name==$invite){
				$result=$invites;
			}
		}
		return $result;
	}

	public static function getInvites($player):array{
		$result=[];
		if(isset($player) and !is_null($player)){
			if($player instanceof Player) $player=$player->getName();
			foreach(Core::getInstance()->partyinvites as $invite){
				if($invite->isTarget($player)){
					$result[]=$invite;
				}
			}
		}
		return $result;
	}

	public static function getInvitesFromParty($party):array{
		$result=[];
		if(isset($party) and !is_null($party)){
			foreach(Core::getInstance()->partyinvites as $invite){
				if($invite->isParty($party)){
					$result[]=$invite;
				}
			}
		}
		return $result;
	}

	public static function hasInvite($target, Party $partyA):bool{
		$result=false;
		foreach(self::getInvites($target) as $invites){
			$partyB=$invites->getParty();
			if($partyA!==null){
				if($partyA->getName()===$partyB->getName()){
					$result=true;
				}
			}
		}
		return $result;
	}
}