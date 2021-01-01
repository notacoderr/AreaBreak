<?php

namespace blackbarbar486\areabreak\listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\level\Level;
use pocketmine\block\Block;
use pocketmine\item\Item;
use pocketmine\inventory\Inventory;
use pocketmine\utils\Config;
use pocketmine\plugin\Plugin;
use pocketmine\Player;
use pocketmine\Server;
use blackbarbar486\areabreak\Main;

class EditListener implements Listener {
	private $plugin;
	
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}
	
	public function onPlayerInteract(PlayerInteractEvent $e) {
		$player = $e->getPlayer();
		$item = $player->getInventory()->getItemInHand()->getId();
		$block = $e->getBlock();
		$id = $block->getId();
		$meta = $block->getDamage();
		$x = $block->getX();
		$y = $block->getY();
		$z = $block->getZ();
		$level = $block->getLevel()->getName();
		$coords = "$x $y $z $level";
		
		if(isset($this->plugin->editmode[$player->getName()])) {
			$player->sendPopUp("§l§5ABreak§r§7»§r§dBlock added");			
			if($this->plugin->blocks->exists($coords)) {
				$player->sendPopUp("§l§5ABreak§r§7»§r§dBlock removed");
				$this->plugin->blocks->remove($coords);
				$this->plugin->blocks->save();
				return true;
			}
			if($item === 0) {
				$this->plugin->blocks->set($coords, "all $id $meta");
				$this->plugin->blocks->save();
				return true;
			}
			$this->plugin->blocks->set($coords, "$item $id $meta");
			$this->plugin->blocks->save();
		}
	}
}