<?php

namespace blackbarbar486\areabreak\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use blackbarbar486\areabreak\Main;

class MainCommand extends Command {
	private $plugin;
	
	public function __construct(Main $plugin) {
		parent::__construct("abreak", "", "/abreak", [""]);
		$this->plugin = $plugin;
	}
	
	public function execute(CommandSender $player, string $commandLabel, array $args) {
		$worldname = $player->getLevel()->getName();
		if(empty($args[0])) {
			$player->sendMessage("§l§5Break§r§7»§r§dUsage: /abreak join/leave/add/remove");
			return true;
		}
		if(!$player instanceof Player) {
			$player->sendMessage("You've to be In-Game!");
			return true;
		}
		if(strtolower($args[0]) === "join") {
			if(!$player->hasPermission("abreak.editmode")) {
			$player->sendMessage($this->plugin->config->get("noperms.message"));
			return true;
			}
			if(!$this->plugin->worlds->exists($worldname)) {
				$cfgmessage = $this->plugin->config->get("worldnotfound.message");
				$message = str_replace("{worldname}", $worldname, $cfgmessage);
				$player->sendMessage($message);
				return true;
			}
			if(isset($this->plugin->editmode[$player->getName()])) {
				$player->sendMessage($this->plugin->config->get("alreadyineditmode.message"));
				return true;
			}
			$cfgmessage = $this->plugin->config->get("editmodejoin.message");
			$message = str_replace("{line}", "\n", $cfgmessage);
			$player->sendMessage($message);
			$this->plugin->editmode[$player->getName()] = $player->getName();
		}
		if(strtolower($args[0]) === "leave") {
			if(!isset($this->plugin->editmode[$player->getName()])) {
				$player->sendMessage($this->plugin->config->get("alreadyouteditmode.message"));
				return true;
			}
			$player->sendMessage($this->plugin->config->get("editmodeleft.message"));
			unset($this->plugin->editmode[$player->getName()]);
		}
		if(strtolower($args[0] === "add")) {
			if(!$player->hasPermission("abreak.addworld")) {
				$player->sendMessage($this->plugin->config->get("noperms.message"));
				return true;
			}
			if($this->plugin->worlds->exists($worldname)) {
				$cfgmessage = $this->plugin->config->get("worldisregistered.message");
				$message = str_replace("{worldname}", $worldname, $cfgmessage);
				$player->sendMessage($message);
				return true;
			}
			$cfgmessage = $this->plugin->config->get("worldadd.message");
			$message = str_replace("{worldname}", $worldname, $cfgmessage);
			$message = str_replace("{line}", "\n", $message);
			$player->sendMessage($message);
			$this->plugin->worlds->set($worldname, "");
			$this->plugin->worlds->save();
		}
		if(strtolower($args[0] === "remove")) {
			if(!$player->hasPermission("abreak.removeworld")) {
				$player->sendMessage($this->plugin->config->get("noperms.message"));
				return true;
			}
			if(!$this->plugin->worlds->exists($worldname)) {
				$cfgmessage = $this->plugin->config->get("worldisnotregistered.message");
				$message = str_replace("{worldname}", $worldname, $cfgmessage);
				$player->sendMessage($message);
				return true;
			}
			$cfgmessage = $this->plugin->config->get("worldremove.message");
			$message = str_replace("{worldname}", $worldname, $cfgmessage);
			$player->sendMessage($message);
			$this->plugin->worlds->remove($worldname);
			$this->plugin->worlds->save();
		}
		return true;
	}
}
