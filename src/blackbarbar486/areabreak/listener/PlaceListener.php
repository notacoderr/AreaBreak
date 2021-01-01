<?php

namespace blackbarbar486\areabreak\listener;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockPlaceEvent;
use blackbarbar486\areabreak\Main;

class PlaceListener implements Listener {
	private $plugin;
	
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}
	
	public function onBlockPlace(BlockPlaceEvent $e) {
		$player = $e->getPlayer();
		$level = $player->getLevel()->getName();
		
		if(!$this->plugin->worlds->exists($level)) {
			return true;
		}
		if($player->getGamemode() === 1) {
			return true;
		}
		$e->setCancelled(true);
		return true;
	}
}