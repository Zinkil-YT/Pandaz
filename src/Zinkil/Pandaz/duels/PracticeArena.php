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

namespace Zinkil\Pandaz\duels;

use pocketmine\level\Level;
use pocketmine\level\Position;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\Utils;

class PracticeArena{
	
	public const DUEL_ARENA="arena.duel";
	public const NO_ARENA="none";
	
	private $name;
	private $arenaType;
	protected $level;
	private $spawnPos;
	private $build;
	
	public function __construct(string $name, string $arenaType, bool $canBuild, Position $center){
		$this->name=$name;
		$this->arenaType=$arenaType;
		$this->build=$canBuild;
		$this->spawnPos=$center;
		$this->level=$center->getLevel();
	}

	public function getLevel(){
		return $this->level;
	}

	public function getSpawnPosition():Position{
		return $this->spawnPos;
	}

	public function canBuild():bool{
		return $this->build;
	}

	public function getArenaType():string{
		return $this->arenaType;
	}

	public static function getType(string $test):string{
		$result="unknown";
		if(Utils::equals_string($test, "duel", "duels", "Duels", "Duel", "DUEL", "1vs1", "1v1")){
			$result=self::DUEL_ARENA;
		}
		return $result;
	}

	public static function getFormattedType(string $type):string{
		$str="(Unknown)";
		if($type===self::DUEL_ARENA){
			$str="(Duel)";
		}
		return $str;
	}

	public function getName():string{
		return $this->name;
	}

	public function getLocalizedName():string{
		return strtolower(strval(str_replace(" ", "", $this->name)));
	}

	public function equals($arena):bool{
		$result=false;
		if($arena instanceof PracticeArena){
			if($arena->getArenaType()===$this->arenaType){
				$result=$arena->getName()===$this->name;
			}
		}
		return $result;
	}
}