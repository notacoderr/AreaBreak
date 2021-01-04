<?php

namespace blackbarbar486\areabreak;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use blackbarbar486\areabreak\command\MainCommand;
use blackbarbar486\areabreak\listener\EditListener;
use blackbarbar486\areabreak\listener\BreakListener;
use blackbarbar486\areabreak\listener\PlaceListener;

/**
 * @property Config worlds
 * @property Config blocks
 * @property Config config
 */

class Main extends PluginBase implements Listener {
	public $editmode = [];
	
	public function onEnable() {
		# register configs
		$this->saveResource("config.yml");
		$this->config = new Config($this->getDataFolder()."config.yml", Config::YAML);
		$this->worlds = new Config($this->getDataFolder()."worlds.yml", Config::YAML);
		$this->blocks = new Config($this->getDataFolder()."blocks.yml", Config::YAML);
		$this->saveResource("worlds.yml");
		$this->saveResource("blocks.yml");
		# register commands
		$this->getServer()->getCommandMap()->register("abreak", new MainCommand($this));
		# register listener
		$this->getServer()->getPluginManager()->registerEvents(new EditListener($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new BreakListener($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new PlaceListener($this), $this);
	}
}
