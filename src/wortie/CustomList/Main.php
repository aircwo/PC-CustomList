<?php

declare(strict_types=1);

namespace wortie\CustomList;

use pocketmine\plugin\PluginBase;
use wortie\CustomList\command\ListCommand;

class Main extends PluginBase {

	public function onEnable(): void {
        $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
		if(is_null($pureChat)){
			$this->getServer()->getPluginManager()->disablePlugin($this);
			$this->getLogger()->critical("PureChat was not found, Plugin: CustomList Disabled");
			return;
		}else{
			$this->getLogger()->info("PureChat plugin found.");
			$this->initCommand();
		}
	}
	
	public function initCommand(): void {
		$this->getServer()->getCommandMap()->unregister($this->getServer()->getCommandMap()->getCommand("list"));
		$this->getServer()->getCommandMap()->register($this->getName(), new ListCommand("Shows a list of online players display names", "Usage: /list", "No permission to use", "list.use"));
    }
}
