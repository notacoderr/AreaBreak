<?php

namespace blackbarbar486\areabreak\task;

use pocketmine\scheduler\Task;
use pocketmine\math\Vector3;
use pocketmine\level\Level;
use pocketmine\block\Block;
use pocketmine\plugin\Plugin;

class BlockTask extends Task {
	private $pos;
	private $level;
	private $plugin;
	
	public function __construct(Plugin $plugin, Vector3 $pos, Level $level) {
		$this->plugin = $plugin;
		$this->pos = $pos;
		$this->level = $level;
	}
	
	public function onRun(int $currentTick) {
		$level = $this->level;
		$levelname = $level->getName();
		$x = $this->pos->getX();
		$y = $this->pos->getY();
		$z = $this->pos->getZ();
		$coords = "$x $y $z $levelname";
		$block = $this->plugin->blocks->get($coords);
		$block = explode(" ", $block);
		$blockid = intval($block[1]);
		$blockmeta = intval($block[2]);
			
		$level->setBlock(new Vector3($x, $y, $z), Block::get($blockid, $blockmeta));
	}
}
