<?php
declare(strict_types=1);

namespace wortie\CustomList\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;

use function array_filter;
use function array_map;

class ListCommand extends Command{
    
	public function __construct(String $description, String $usage, String $noperm, String $perm){
        parent::__construct("list", $description, $usage);
        $this->setPermissionMessage($noperm);
        $this->setPermission($perm);
    }
	
    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if($sender instanceof Player){
			$players = $sender->getServer()->getOnlinePlayers();
			$playerNames = array_map(function(Player $player) : string{
				$pc = Server::getInstance()->getPluginManager()->getPlugin("PureChat");
				return $pc->getNametag($player);
			}, array_filter($sender->getServer()->getOnlinePlayers(), function(Player $player) use ($sender) : bool{
				return $player->isOnline() and (!($sender instanceof Player) or $sender->canSee($player));
			}));
			sort($playerNames, SORT_STRING);
			
			$sender->sendMessage("Currenlty (" . count($players) . "/" . $sender->getServer()->getMaxPlayers() . ") Online:");
			$sender->sendMessage(implode(", ", $playerNames));
        }
    }
}
