<?php

namespace blackbarbar486\areabreak\task;

use pocketmine\scheduler\Task;
use pocketmine\utils\Config;
use pocketmine\math\Vector3;
use pocketmine\level\Level;
use pocketmine\block\Block;
use pocketmine\plugin\Plugin;
use pocketmine\Player;
use pocketmine\Server;

class BlockTask extends Task {
	private $pos;
	private $level;
	private $plugin;
	public $seconds = 30;
	
	public function __construct(Plugin $plugin, Vector3 $pos, Level $level) {
		$this->plugin = $plugin;
		$this->pos = $pos;
		$this->level = $level;
	}
	
	public function onRun(int $currentTick) {
		$this->seconds--;
		if($this->seconds === 0) {
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
}