<?php

namespace blackbarbar486\areabreak;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\scheduler\Task as PluginTask;
use pocketmine\utils\Config;
use pocketmine\plugin\Plugin;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\Server;
//Task
use blackbarbar486\areabreak\task\BlockTask;
//Command
use blackbarbar486\areabreak\command\MainCommand;
//Listener
use blackbarbar486\areabreak\listener\EditListener;
use blackbarbar486\areabreak\listener\BreakListener;
use blackbarbar486\areabreak\listener\PlaceListener;

class Main extends PluginBase implements Listener {
	public $editmode = [];
	
	public function onEnable() {
		$this->getLogger()->info("AreaBreak was enabled!");
		//Configs
		@mkdir($this->getDataFolder());
		$this->saveDefaultConfig();
		$this->saveResource("config.yml");
		$this->worlds = new Config($this->getDataFolder()."worlds.yml", Config::YAML);
		$this->blocks = new Config($this->getDataFolder()."blocks.yml", Config::YAML);
		$this->saveResource("worlds.yml");
		$this->saveResource("blocks.yml");
		//Command
		$this->getServer()->getCommandMap()->register("abreak", new MainCommand($this));
		//Listener
		$this->getServer()->getPluginManager()->registerEvents(new EditListener($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new BreakListener($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new PlaceListener($this), $this);
	}
	
	public function onDisable() {
		$this->getLogger()->info("AreaBreak was disabled!");
	}
}
