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

namespace Zinkil\Pandaz;

use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\ListTag;
use Zinkil\Pandaz\Core;

class Kits{
	
	public $plugin;
	
	public function __construct(Core $plugin){
		$this->plugin=$plugin;
	}

	public static function sendKit(Player $player, $kit){
		switch($kit){
			case "lobby":
			$player->extinguish();
			$player->setScale(1);
			$player->setGamemode(2);
			$player->setImmobile(false);
			$player->setAllowFlight(false);
			$player->setFlying(false);
			$player->getInventory()->clearAll();
			$player->getArmorInventory()->clearAll();
			$player->removeAllEffects();
			$player->setXpLevel(0);
			$player->setXpProgress(0.0);
			$player->setFood(20);
			$player->setHealth(20);
			$player->getInventory()->setSize(36);
			$ffa=Item::get(Item::DIAMOND_SWORD, 0, 1);
			$ffa->setCustomName("§l§bFFA");
			$ffa->setLore(["§r§eWarp to FFA!"]);
			$ranked=Item::get(Item::IRON_SWORD, 0, 1);
			$ranked->setCustomName("§l§bRanked");
			$ranked->setLore(["§r§ePlay ranked duels!"]);
			$unranked=Item::get(Item::GOLD_SWORD, 0, 1);
			$unranked->setCustomName("§l§bUnranked");
			$unranked->setLore(["§r§ePlay unranked duels!"]);
			$duels=Item::get(Item::IRON_SWORD, 0, 1);
			$duels->setCustomName("§l§bDuels");
			$duels->setLore(["§r§ePlay Duels!"]);
			$botduels=Item::get(Item::GOLD_AXE, 0, 1);
			$botduels->setCustomName("§l§bBot Duels");
			$botduels->setLore(["§r§ePlay bot duels!"]);
			$spectate=Item::get(Item::GOLD_AXE, 0, 1);
			$spectate->setCustomName("§l§bSpectate");
			$spectate->setLore(["§r§eSpectate Duels!"]);
			$market=Item::get(421, 0, 1);
			$market->setCustomName("§l§bMarket");
			$market->setLore(["§r§eView the market!"]);
			$party=Item::get(288, 0, 1);
			$party->setCustomName("§l§bParty");
			$party->setLore(["§r§ePlay With Your Friends!"]);
			$daily=Item::get(345, 0, 1);
			$daily->setCustomName("§l§bDaily Rankings");
			$daily->setLore(["§r§eView Daily Rankings!"]);
			$cosmetics=Item::get(399, 0, 1);
			$cosmetics->setCustomName("§l§bCosmetics");
			$cosmetics->setLore(["§r§eCustomize Your Gameplay!"]);
			$profile=Item::get(130, 0, 1);
			$profile->setCustomName("§l§bPlayer Portal");
			$profile->setLore(["§r§eView Your Profile!"]);
			$events=Item::get(340, 0, 1);
			$events->setCustomName("§l§bEvents");
			$events->setLore(["§r§eEnter an event!"]);
			$player->getInventory()->setItem(0, $ffa);
			$player->getInventory()->setItem(1, $duels);
			$player->getInventory()->setItem(2, $botduels);
			$player->getInventory()->setItem(4, $profile);
			$player->getInventory()->setItem(6, $party);
			$player->getInventory()->setItem(7, $daily);
			$player->getInventory()->setItem(8, $cosmetics);
			$player->getInventory()->setHeldItemIndex(4);
			break;
			case "nodebuff":
			case "NoDebuff":
			$mode="§r§bNoDebuff";
			$name=$player->getName();
			$player->extinguish();
			$player->setScale(1);
			$player->setGamemode(2);
			$player->setImmobile(false);
			$player->setAllowFlight(false);
			$player->setFlying(false);
			$player->removeAllEffects();
			$player->setXpLevel(0);
			$player->setXpProgress(0.0);
			$player->setFood(20);
			$player->setHealth(20);
			$player->getInventory()->setSize(36);
			$player->getInventory()->clearAll();
			$player->getArmorInventory()->clearAll();
			$helmet=Item::get(310, 0, 1);
			$helmet->setCustomName($mode);
			$player->getArmorInventory()->setHelmet($helmet);
			$chestplate=Item::get(311, 0, 1);
			$chestplate->setCustomName($mode);
			$player->getArmorInventory()->setChestplate($chestplate);
			$leggings=Item::get(312, 0, 1);
			$leggings->setCustomName($mode);
			$player->getArmorInventory()->setLeggings($leggings);
			$boots=Item::get(313, 0, 1);
			$boots->setCustomName($mode);
			$player->getArmorInventory()->setBoots($boots);
			$sword=Item::get(276, 0, 1);
			$player->getInventory()->setItem(0, $sword);
			$player->getInventory()->setItem(1, Item::get(368, 0, 16));
			$player->getInventory()->addItem(Item::get(438, 22, 36));
			$player->addEffect(new EffectInstance(Effect::getEffect(1), 45 * 1200, 0, false));//speed 1 for 45 mins
			break;
			case "nodebuffjava":
			case "NoDebuffJava":
			$mode="§r§bNoDebuff";
			$name=$player->getName();
			$player->extinguish();
			$player->setScale(1);
			$player->setGamemode(2);
			$player->setImmobile(false);
			$player->setAllowFlight(false);
			$player->setFlying(false);
			$player->removeAllEffects();
			$player->setXpLevel(0);
			$player->setXpProgress(0.0);
			$player->setFood(20);
			$player->setHealth(20);
			$player->getInventory()->setSize(36);
			$player->getInventory()->clearAll();
			$player->getArmorInventory()->clearAll();
			$helmet=Item::get(310, 0, 1);
			$helmet->setCustomName($mode);
			$player->getArmorInventory()->setHelmet($helmet);
			$chestplate=Item::get(311, 0, 1);
			$chestplate->setCustomName($mode);
			$player->getArmorInventory()->setChestplate($chestplate);
			$leggings=Item::get(312, 0, 1);
			$leggings->setCustomName($mode);
			$player->getArmorInventory()->setLeggings($leggings);
			$boots=Item::get(313, 0, 1);
			$boots->setCustomName($mode);
			$player->getArmorInventory()->setBoots($boots);
			$sword=Item::get(276, 0, 1);
			$player->getInventory()->setItem(0, $sword);
			$player->getInventory()->setItem(1, Item::get(368, 0, 16));
			$player->getInventory()->addItem(Item::get(438, 22, 36));
			$player->addEffect(new EffectInstance(Effect::getEffect(1), 45 * 1200, 1, false));//speed 2 for 45 mins
			break;
			case "gapple":
			case "Gapple":
			$mode="§r§bGapple";
			$name=$player->getName();
			$player->extinguish();
			$player->setScale(1);
			$player->setGamemode(2);
			$player->setImmobile(false);
			$player->setAllowFlight(false);
			$player->setFlying(false);
			$player->removeAllEffects();
			$player->setXpLevel(0);
			$player->setXpProgress(0.0);
			$player->setFood(20);
			$player->setHealth(20);
			$player->getInventory()->setSize(36);
			$player->getInventory()->clearAll();
			$player->getArmorInventory()->clearAll();
			$helmet=Item::get(306, 0, 1);
			$helmet->setCustomName($mode);
			$player->getArmorInventory()->setHelmet($helmet);
			$chestplate=Item::get(307, 0, 1);
			$chestplate->setCustomName($mode);
			$player->getArmorInventory()->setChestplate($chestplate);
			$leggings=Item::get(308, 0, 1);
			$leggings->setCustomName($mode);
			$player->getArmorInventory()->setLeggings($leggings);
			$boots=Item::get(309, 0, 1);
			$boots->setCustomName($mode);
			$player->getArmorInventory()->setBoots($boots);
			$sword=Item::get(267, 0, 1);
			$player->getInventory()->setItem(0, $sword);
			$player->getInventory()->setItem(1, Item::get(322, 0, 16));
			break;
			case "opgapple":
			case "OP Gapple":
			$mode="§r§bGapple";
			$name=$player->getName();
			$player->extinguish();
			$player->setScale(1);
			$player->setGamemode(2);
			$player->setImmobile(false);
			$player->setAllowFlight(false);
			$player->setFlying(false);
			$player->removeAllEffects();
			$player->setXpLevel(0);
			$player->setXpProgress(0.0);
			$player->setFood(20);
			$player->setHealth(20);
			$player->getInventory()->setSize(36);
			$player->getInventory()->clearAll();
			$player->getArmorInventory()->clearAll();
			$helmet=Item::get(310, 0, 1);
			$helmet->setCustomName($mode);
			$player->getArmorInventory()->setHelmet($helmet);
			$chestplate=Item::get(311, 0, 1);
			$chestplate->setCustomName($mode);
			$player->getArmorInventory()->setChestplate($chestplate);
			$leggings=Item::get(312, 0, 1);
			$leggings->setCustomName($mode);
			$player->getArmorInventory()->setLeggings($leggings);
			$boots=Item::get(313, 0, 1);
			$boots->setCustomName($mode);
			$player->getArmorInventory()->setBoots($boots);
			$sword=Item::get(276, 0, 1);
			$player->getInventory()->setItem(0, $sword);
			$player->getInventory()->setItem(1, Item::get(466, 0, 32));
			$player->addEffect(new EffectInstance(Effect::getEffect(1), 999999, 0, false));
			break;
			case "combo":
			case "Combo":
			$mode="§r§bCombo";
			$name=$player->getName();
			$player->extinguish();
			$player->setScale(1);
			$player->setGamemode(2);
			$player->setImmobile(false);
			$player->setAllowFlight(false);
			$player->setFlying(false);
			$player->removeAllEffects();
			$player->setXpLevel(0);
			$player->setXpProgress(0.0);
			$player->setFood(20);
			$player->setHealth(20);
			$player->getInventory()->setSize(36);
			$player->getInventory()->clearAll();
			$player->getArmorInventory()->clearAll();
			$helmet=Item::get(310, 0, 1);
			$helmet->setCustomName($mode);
			$helmet->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 20));
			$player->getArmorInventory()->setHelmet($helmet);
			$chestplate=Item::get(311, 0, 1);
			$chestplate->setCustomName($mode);
			$chestplate->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 20));
			$player->getArmorInventory()->setChestplate($chestplate);
			$leggings=Item::get(312, 0, 1);
			$leggings->setCustomName($mode);
			$leggings->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 20));
			$player->getArmorInventory()->setLeggings($leggings);
			$boots=Item::get(313, 0, 1);
			$boots->setCustomName($mode);
			$boots->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 20));
			$player->getArmorInventory()->setBoots($boots);
			$sword=Item::get(276, 0, 1);
			$sword->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 20));
			$player->getInventory()->setItem(0, $sword);
			$player->getInventory()->setItem(1, Item::get(466, 0, 64));
			$player->addEffect(new EffectInstance(Effect::getEffect(1), 999999, 0, false));
			break;
			case "fist":
			case "Fist":
			$mode="§r§bFist";
			$name=$player->getName();
			$player->extinguish();
			$player->setScale(1);
			$player->setGamemode(2);
			$player->setImmobile(false);
			$player->setAllowFlight(false);
			$player->setFlying(false);
			$player->removeAllEffects();
			$player->setXpLevel(0);
			$player->setXpProgress(0.0);
			$player->setFood(20);
			$player->setHealth(20);
			$player->getInventory()->setSize(36);
			$player->getInventory()->clearAll();
			$player->getInventory()->setItem(0, Item::get(424, 0, 1));
			$player->getArmorInventory()->clearAll();
			break;
			case "resistance":
			case "Resistance":
			$mode="§r§bResistance";
			$name=$player->getName();
			$player->extinguish();
			$player->setScale(1);
			$player->setGamemode(2);
			$player->setImmobile(false);
			$player->setAllowFlight(false);
			$player->setFlying(false);
			$player->removeAllEffects();
			$player->setXpLevel(0);
			$player->setXpProgress(0.0);
			$player->setFood(20);
			$player->setHealth(20);
			$player->getInventory()->setSize(36);
			$player->getInventory()->clearAll();
			$player->getArmorInventory()->clearAll();
			$player->getInventory()->setItem(0, Item::get(276, 0, 1));
			$player->addEffect(new EffectInstance(Effect::getEffect(11), 999999, 600000, false));
			break;
			case "sumoffa":
			case "SumoFFA":
			$mode="§r§bSumoFFA";
			$name=$player->getName();
			$player->extinguish();
			$player->setScale(1);
			$player->setGamemode(2);
			$player->setImmobile(false);
			$player->setAllowFlight(false);
			$player->setFlying(false);
			$player->removeAllEffects();
			$player->setXpLevel(0);
			$player->setXpProgress(0.0);
			$player->setFood(20);
			$player->setHealth(20);
			$player->getInventory()->setSize(36);
			$player->getInventory()->clearAll();
			$player->getArmorInventory()->clearAll();
			$player->getInventory()->setItem(0, Item::get(349, 3, 1));
			$player->addEffect(new EffectInstance(Effect::getEffect(11), 999999, 600000, false));
			break;
			case "knockbackffa":
			case "KnockBackFFA":
			$mode="§r§bKnockBackFFA";
			$name=$player->getName();
			$player->extinguish();
			$player->setScale(1);
			$player->setGamemode(2);
			$player->setImmobile(false);
			$player->setAllowFlight(false);
			$player->setFlying(false);
			$player->removeAllEffects();
			$player->setXpLevel(0);
			$player->setXpProgress(0.0);
			$player->setFood(20);
			$player->setHealth(20);
			$player->getInventory()->setSize(36);
			$player->getInventory()->clearAll();
			$player->getArmorInventory()->clearAll();
			$stick=Item::get(280, 0, 1);
			$stick->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(12), 2));
			$player->getInventory()->setItem(0, $stick);
			$player->getInventory()->addItem(Item::get(368, 0, 16));
			$player->addEffect(new EffectInstance(Effect::getEffect(11), 999999, 600000, false));
			break;
			case "buildffa":
			case "BuildFFA":
			$mode="§r§bBuildFFA";
			$name=$player->getName();
			$player->extinguish();
			$player->setScale(1);
			$player->setGamemode(0);
			$player->setImmobile(false);
			$player->setAllowFlight(false);
			$player->setFlying(false);
			$player->removeAllEffects();
			$player->setXpLevel(0);
			$player->setXpProgress(0.0);
			$player->setFood(20);
			$player->setHealth(20);
			$player->getInventory()->setSize(36);
			$player->getInventory()->clearAll();
			$player->getArmorInventory()->clearAll();
			$helmet=Item::get(306, 0, 1);
			$helmet->setCustomName($mode);
			$helmet->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 20));
			$player->getArmorInventory()->setHelmet($helmet);
			$chestplate=Item::get(315, 0, 1);
			$chestplate->setCustomName($mode);
			$chestplate->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 20));
			$player->getArmorInventory()->setChestplate($chestplate);
			$leggings=Item::get(316, 0, 1);
			$leggings->setCustomName($mode);
			$leggings->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 20));
			$player->getArmorInventory()->setLeggings($leggings);
			$boots=Item::get(309, 0, 1);
			$boots->setCustomName($mode);
			$boots->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 20));
			$player->getArmorInventory()->setBoots($boots);
			$sword=Item::get(283, 0, 1);
			$sword->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 20));
			$pickaxe=Item::get(257, 0, 1);
			$pickaxe->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 20));
			$goldenhead=Item::get(322, 0, 2);
			$goldenhead->setCustomName(Core::GOLDEN_HEAD);
			$sandstone=Item::get(24, 0, 64);
			$pearl=Item::get(368, 0, 1);
			$player->getInventory()->setItem(0, $sword);
			$player->getInventory()->setItem(1, $sandstone);
			$player->getInventory()->setItem(2, $goldenhead);
			$player->getInventory()->setItem(3, $pearl);
			$player->getInventory()->setItem(8, $pickaxe);
			break;
			case "staff":
			$player->extinguish();
			$player->setScale(1);
			$player->setGamemode(3);
			$player->setAllowFlight(true);
			$player->setFlying(false);
			$player->removeAllEffects();
			$player->setFood(20);
			$player->setHealth(20);
			$player->getInventory()->setSize(9);
			$player->getInventory()->clearAll();
			$player->getArmorInventory()->clearAll();
			$staffportal=Item::get(339, 0, 1);
			$staffportal->setCustomName("§l§bStaff Portal");
			$staffportal->setLore(["§r§bStaff portal!"]);
			$teleporter=Item::get(345, 0, 1);
			$teleporter->setCustomName("§l§bTeleport");
			$teleporter->setLore(["§r§bTeleport between FFA worlds!"]);
			$leave=Item::get(355, 0, 1);
			$leave->setCustomName("§l§bLeave Staff Mode");
			$leave->setLore(["§r§bLeave staff mode!"]);
			$player->getInventory()->setItem(0, $staffportal);
			$player->getInventory()->setItem(4, $teleporter);
			$player->getInventory()->setItem(8, $leave);
			break;
			case "spectator":
			$player->extinguish();
			$player->setScale(1);
			$player->setGamemode(3);
			$player->setAllowFlight(true);
			$player->setFlying(false);
			$player->removeAllEffects();
			$player->setFood(20);
			$player->setHealth(20);
			$player->getInventory()->setSize(9);
			$player->getInventory()->clearAll();
			$player->getArmorInventory()->clearAll();
			$leave=Item::get(355, 0, 1);
			$leave->setCustomName("§l§bLeave Duel");
			$leave->setLore(["§r§bLeave the duel!"]);
			$player->getInventory()->setItem(4, $leave);
			$player->getInventory()->setHeldItemIndex(4);
			break;
			default:
			return;
			break;
		}
	}

	public static function sendMatchKit($player, $kit){
		switch($kit){
			case "nodebuff":
			case "NoDebuff":
			$mode="§r§bNoDebuff";
			$name=$player->getName();
			$player->extinguish();
			$player->setScale(1);
			if($player instanceof Player){
				$player->setGamemode(2);
				$player->setAllowFlight(false);
				$player->setFlying(false);
				$player->setXpLevel(0);
				$player->setXpProgress(0.0);
			}
			$player->removeAllEffects();
			$player->setFood(20);
			$player->setHealth(20);
			$player->getInventory()->setSize(36);
			$player->getInventory()->clearAll();
			$player->getArmorInventory()->clearAll();
			$helmet=Item::get(310, 0, 1);
			$helmet=Item::get(310, 0, 1);
			$helmet->setCustomName($mode);
			$player->getArmorInventory()->setHelmet($helmet);
			$chestplate=Item::get(311, 0, 1);
			$chestplate->setCustomName($mode);
			$player->getArmorInventory()->setChestplate($chestplate);
			$leggings=Item::get(312, 0, 1);
			$leggings->setCustomName($mode);
			$player->getArmorInventory()->setLeggings($leggings);
			$boots=Item::get(313, 0, 1);
			$boots->setCustomName($mode);
			$player->getArmorInventory()->setBoots($boots);
			$sword=Item::get(276, 0, 1);
			$player->getInventory()->setItem(0, $sword);
			$player->getInventory()->setItem(1, Item::get(368, 0, 16));
			$player->getInventory()->addItem(Item::get(438, 22, 36));
			$player->addEffect(new EffectInstance(Effect::getEffect(1), 45 * 1200, 0, false));//speed 1 for 45 mins
			break;
			case "gapple":
			case "Gapple":
			$mode="§r§bGapple";
			$name=$player->getName();
			$player->extinguish();
			$player->setScale(1);
			$player->setGamemode(2);
			$player->setAllowFlight(false);
			$player->setFlying(false);
			$player->removeAllEffects();
			$player->setXpLevel(0);
			$player->setXpProgress(0.0);
			$player->setFood(20);
			$player->setHealth(20);
			$player->getInventory()->setSize(36);
			$player->getInventory()->clearAll();
			$player->getArmorInventory()->clearAll();
			$helmet=Item::get(306, 0, 1);
			$helmet->setCustomName($mode);
			$player->getArmorInventory()->setHelmet($helmet);
			$chestplate=Item::get(307, 0, 1);
			$chestplate->setCustomName($mode);
			$player->getArmorInventory()->setChestplate($chestplate);
			$leggings=Item::get(308, 0, 1);
			$leggings->setCustomName($mode);
			$player->getArmorInventory()->setLeggings($leggings);
			$boots=Item::get(309, 0, 1);
			$boots->setCustomName($mode);
			$player->getArmorInventory()->setBoots($boots);
			$sword=Item::get(267, 0, 1);
			$player->getInventory()->setItem(0, $sword);
			$player->getInventory()->setItem(1, Item::get(322, 0, 16));
			break;
			case "diamond":
			case "Diamond":
			$mode="§r§bDiamond";
			$name=$player->getName();
			$player->extinguish();
			$player->setScale(1);
			$player->setGamemode(2);
			$player->setAllowFlight(false);
			$player->setFlying(false);
			$player->removeAllEffects();
			$player->setXpLevel(0);
			$player->setXpProgress(0.0);
			$player->setFood(20);
			$player->setHealth(20);
			$player->getInventory()->setSize(36);
			$player->getInventory()->clearAll();
			$player->getArmorInventory()->clearAll();
			$helmet=Item::get(310, 0, 1);
			$helmet->setCustomName($mode);
			$player->getArmorInventory()->setHelmet($helmet);
			$chestplate=Item::get(311, 0, 1);
			$chestplate->setCustomName($mode);
			$player->getArmorInventory()->setChestplate($chestplate);
			$leggings=Item::get(312, 0, 1);
			$leggings->setCustomName($mode);
			$player->getArmorInventory()->setLeggings($leggings);
			$boots=Item::get(313, 0, 1);
			$boots->setCustomName($mode);
			$player->getArmorInventory()->setBoots($boots);
			$sword=Item::get(267, 0, 1);
			$player->getInventory()->setItem(0, $sword);
			$player->getInventory()->setItem(1, Item::get(261, 0, 1));
			$player->getInventory()->setItem(2, Item::get(322, 0, 5));
			$player->getInventory()->setItem(3, Item::get(373, 14, 1));
			$player->getInventory()->setItem(4, Item::get(373, 28, 1));
			$player->getInventory()->setItem(5, Item::get(262, 0, 32));
			break;
			case "combo":
			case "Combo":
			$mode="§r§bCombo";
			$name=$player->getName();
			$player->extinguish();
			$player->setScale(1);
			$player->setGamemode(2);
			$player->setAllowFlight(false);
			$player->setFlying(false);
			$player->removeAllEffects();
			$player->setXpLevel(0);
			$player->setXpProgress(0.0);
			$player->setFood(20);
			$player->setHealth(20);
			$player->getInventory()->setSize(36);
			$player->getInventory()->clearAll();
			$player->getArmorInventory()->clearAll();
			$helmet=Item::get(306, 0, 1);
			$helmet->setCustomName($mode);
			$helmet->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 15));
			$helmet->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 1));
			$player->getArmorInventory()->setHelmet($helmet);
			$chestplate=Item::get(307, 0, 1);
			$chestplate->setCustomName($mode);
			$chestplate->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 15));
			$chestplate->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 1));
			$player->getArmorInventory()->setChestplate($chestplate);
			$leggings=Item::get(308, 0, 1);
			$leggings->setCustomName($mode);
			$leggings->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 15));
			$leggings->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 1));
			$player->getArmorInventory()->setLeggings($leggings);
			$boots=Item::get(309, 0, 1);
			$boots->setCustomName($mode);
			$boots->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 15));
			$boots->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 1));
			$player->getArmorInventory()->setBoots($boots);
			$player->addEffect(new EffectInstance(Effect::getEffect(10), 999999, 2, false));
			$player->addEffect(new EffectInstance(Effect::getEffect(1), 999999, 0, false));
			break;
			case "sumo":
			case "Sumo":
			$mode="§r§bSumo";
			$name=$player->getName();
			$player->extinguish();
			$player->setScale(1);
			$player->setGamemode(2);
			$player->setAllowFlight(false);
			$player->setFlying(false);
			$player->removeAllEffects();
			$player->setXpLevel(0);
			$player->setXpProgress(0.0);
			$player->setFood(20);
			$player->setHealth(20);
			$player->getInventory()->setSize(36);
			$player->getInventory()->clearAll();
			$player->getArmorInventory()->clearAll();
			$player->addEffect(new EffectInstance(Effect::getEffect(11), 999999, 600000, false));
			break;
			case "mlgrush":
			case "MlgRush":
			$mode="§r§bMlgRush";
			$name=$player->getName();
			$player->extinguish();
			$player->setScale(1);
			$player->setGamemode(0);
			$player->setImmobile(false);
			$player->setAllowFlight(false);
			$player->setFlying(false);
			$player->removeAllEffects();
			$player->setXpLevel(0);
			$player->setXpProgress(0.0);
			$player->setFood(20);
			$player->setHealth(20);
			$player->getInventory()->setSize(36);
			$player->getInventory()->clearAll();
			$player->getArmorInventory()->clearAll();
			$sword=Item::get(280, 0, 1);
			$sword->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(12), 1));
			$player->getInventory()->setItem(0, $sword);
			$player->getInventory()->addItem(Item::get(278, 0, 1));
			$player->getInventory()->addItem(Item::get(24, 0, 64));
			$player->getInventory()->addItem(Item::get(24, 0, 64));
			$player->getInventory()->addItem(Item::get(24, 0, 64));
			$player->addEffect(new EffectInstance(Effect::getEffect(11), 999999, 600000, false));
			break;
			case "line":
			case "Line":
			$mode="§r§bLine";
			$name=$player->getName();
			$player->extinguish();
			$player->setScale(1);
			$player->setGamemode(2);
			$player->setImmobile(false);
			$player->setAllowFlight(false);
			$player->setFlying(false);
			$player->removeAllEffects();
			$player->setXpLevel(0);
			$player->setXpProgress(0.0);
			$player->setFood(20);
			$player->setHealth(20);
			$player->getInventory()->setSize(36);
			$player->getInventory()->clearAll();
			$player->getArmorInventory()->clearAll();
			$player->getInventory()->setItem(0, Item::get(369, 0, 1));
			$player->addEffect(new EffectInstance(Effect::getEffect(10), 999999, 4, true));
			break;
			case "soup":
			case "Soup":
			$mode="§r§bSoup";
			$name=$player->getName();
			$player->extinguish();
			$player->setScale(1);
			$player->setGamemode(2);
			$player->setAllowFlight(false);
			$player->setFlying(false);
			$player->removeAllEffects();
			$player->setXpLevel(0);
			$player->setXpProgress(0.0);
			$player->setFood(20);
			$player->setHealth(20);
			$player->getInventory()->setSize(36);
			$player->getInventory()->clearAll();
			$player->getArmorInventory()->clearAll();
			$helmet=Item::get(306, 0, 1);
			$helmet->setCustomName($mode);
			$helmet->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 10));
			$helmet->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 3));
			$player->getArmorInventory()->setHelmet($helmet);
			$chestplate=Item::get(307, 0, 1);
			$chestplate->setCustomName($mode);
			$chestplate->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 10));
			$chestplate->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 3));
			$player->getArmorInventory()->setChestplate($chestplate);
			$leggings=Item::get(308, 0, 1);
			$leggings->setCustomName($mode);
			$leggings->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 10));
			$leggings->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 3));
			$player->getArmorInventory()->setLeggings($leggings);
			$boots=Item::get(309, 0, 1);
			$boots->setCustomName($mode);
			$boots->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 10));
			$boots->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 3));
			$player->getArmorInventory()->setBoots($boots);
			$sword=Item::get(267, 0, 1);
			$sword->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 10));
			$player->getInventory()->setItem(0, $sword);
			$player->getInventory()->addItem(Item::get(282, 0, 36));
			$player->addEffect(new EffectInstance(Effect::getEffect(1), 45 * 1200, 0, false));//speed 1 for 45 mins
			break;
			case "builduhc":
			case "BuildUHC":
			$mode="§r§bBuildUHC";
			$name=$player->getName();
			$player->extinguish();
			$player->setScale(1);
			$player->setGamemode(0);
			$player->setAllowFlight(false);
			$player->setFlying(false);
			$player->removeAllEffects();
			$player->setXpLevel(0);
			$player->setXpProgress(0.0);
			$player->setFood(20);
			$player->setHealth(20);
			$player->getInventory()->setSize(36);
			$player->getInventory()->clearAll();
			$player->getArmorInventory()->clearAll();
			$helmet=Item::get(310, 0, 1);
			$helmet->setCustomName($mode);
			$player->getArmorInventory()->setHelmet($helmet);
			$chestplate=Item::get(311, 0, 1);
			$chestplate->setCustomName($mode);
			$player->getArmorInventory()->setChestplate($chestplate);
			$leggings=Item::get(312, 0, 1);
			$leggings->setCustomName($mode);
			$player->getArmorInventory()->setLeggings($leggings);
			$boots=Item::get(313, 0, 1);
			$boots->setCustomName($mode);
			$player->getArmorInventory()->setBoots($boots);
			$sword=Item::get(276, 0, 1);
			$goldenhead=Item::get(322, 0, 5);
			$goldenhead->setCustomName(Core::GOLDEN_HEAD);
			$player->getInventory()->setItem(0, $sword);
			$player->getInventory()->setItem(1, Item::get(346, 0, 1));
			$player->getInventory()->setItem(2, Item::get(279, 0, 1));
			$player->getInventory()->setItem(3, Item::get(261, 0, 1));
			$player->getInventory()->setItem(4, $goldenhead);
			$player->getInventory()->setItem(5, Item::get(325, 8, 1));
			$player->getInventory()->setItem(6, Item::get(325, 10, 1));
			$player->getInventory()->setItem(7, Item::get(5, 0, 64));
			$player->getInventory()->setItem(8, Item::get(4, 0, 64));
			$player->getInventory()->setItem(9, Item::get(278, 0, 1));
			$player->getInventory()->setItem(10, Item::get(262, 0, 64));
			break;
			default:
			return;
			break;
		}
	}

	public static function preComboKit(Player $player){
		$player->setGamemode(2);
		$player->setAllowFlight(false);
		$player->setFlying(false);
		$player->removeAllEffects();
		$player->setFood(20);
		$player->setHealth(20);
		$player->getInventory()->setSize(36);
		$player->getInventory()->clearAll();
		$player->getArmorInventory()->clearAll();
		$item1=Item::get(340, 0, 1);
		$item1->setCustomName("§r§bSelect Combo Kit");
		$item1->setLore(["§r§bClaim your kit!"]);
		$item2=Item::get(399, 0, 1);
		$item2->setCustomName("§r§bLobby");
		$item2->setLore(["§r§bWarp to the lobby!"]);
		$player->getInventory()->setItem(0, $item1);
		$player->getInventory()->setItem(8, $item2);
	}

	public static function preNoDebuffKit(Player $player){
		$player->setGamemode(2);
		$player->setAllowFlight(false);
		$player->setFlying(false);
		$player->removeAllEffects();
		$player->setFood(20);
		$player->setHealth(20);
		$player->getInventory()->setSize(36);
		$player->getInventory()->clearAll();
		$player->getArmorInventory()->clearAll();
		$item1=Item::get(340, 0, 1);
		$item1->setCustomName("§r§bSelect NoDebuff Kit");
		$item1->setLore(["§r§bClaim your kit!"]);
		$item2=Item::get(399, 0, 1);
		$item2->setCustomName("§r§bLobby");
		$item2->setLore(["§r§bWarp to the lobby!"]);
		$player->getInventory()->setItem(0, $item1);
		$player->getInventory()->setItem(8, $item2);
	}

	public static function preGappleKit(Player $player){
		$player->setGamemode(2);
		$player->setAllowFlight(false);
		$player->setFlying(false);
		$player->removeAllEffects();
		$player->setFood(20);
		$player->setHealth(20);
		$player->getInventory()->setSize(36);
		$player->getInventory()->clearAll();
		$player->getArmorInventory()->clearAll();
		$item1=Item::get(340, 0, 1);
		$item1->setCustomName("§r§bSelect Gapple Kit");
		$item1->setLore(["§r§bClaim your kit!"]);
		$item2=Item::get(399, 0, 1);
		$item2->setCustomName("§r§bLobby");
		$item2->setLore(["§r§bWarp to the lobby!"]);
		$player->getInventory()->setItem(0, $item1);
		$player->getInventory()->setItem(8, $item2);
	}
}