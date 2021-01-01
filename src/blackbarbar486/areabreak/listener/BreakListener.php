<?php

namespace blackbarbar486\areabreak\listener;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;
use blackbarbar486\areabreak\task\BlockTask;
use blackbarbar486\areabreak\Main;

class BreakListener implements Listener {
	private $plugin;
	
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}
	
	public function onBlockBreak(BlockBreakEvent $e) {
		$player = $e->getPlayer();
		$item = $player->getInventory()->getItemInHand()->getId();
		$block = $e->getBlock();
		$x = $block->getX();
		$y = $block->getY();
		$z = $block->getZ();
		$level = $block->getLevel()->getName();
		$world = $block->getLevel();
		$coords = "$x $y $z $level";
		
		if($player->getGamemode() === 1) {
			return true;
		}
		if(!$this->plugin->worlds->exists($level)) {
			return true;
		}
		if(!$this->plugin->blocks->exists($coords)) {
			$e->setCancelled(true);
			return true;
		}
		$cfgitem = $this->plugin->blocks->get($coords);
		$info = explode(" ", $cfgitem);
		$toolid = $info[0];
		if($item != $toolid) {
			if($toolid != "all") {
				$e->setCancelled(true);
				return true;
			}
		}
		$e->setCancelled(false);
		$pos = $block->asVector3();
		$this->plugin->getScheduler()->scheduleDelayedTask(new BlockTask($this->plugin, $pos, $world), intval($this->plugin->config->get("respawn.delay") * 20));
	    return true;
	}
}
