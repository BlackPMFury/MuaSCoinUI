<?php

/* -----[MuaZCoinUI]-----
* Update Screen UI System.
* Version: 2.0
* Editor: BlackPMFury
* This Test Plugin.
*/

namespace MuaZcoin\DoiTien;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\math\Vector3;
use pocketmine\event\Listener;
use pocketmine\{Player, Server};
use jojoe7777\FormAPI;
use onebone\economyapi\EconomyAPI;

class Main extends PluginBase{
	public $tag = "§6♥ §aS§bP§dN§e VN§6 ♥§r";
        public $enable = false;
	
	public function onEnable(){
		$this->getServer()->getLogger()->info($this->tag . " §l§aEnable MuaZCoin System....");
		$this->point = $this->getServer()->getPluginManager()->getPlugin("PointAPI");
		$this->money = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
                $this->eco = EconomyAPI::getInstance();
                If($this->money === null and $this->point === null){
                   $this->enable = false;
	           $this->getServer()->getLogger()->info($this->tag . "§c Bạn chắc rằng bạn đã cài plugin EconomyAPI và PointAPI từ pogit chưa ?");
		   $this->getServer()->shutdown();
		   return;
		}
                if($this->enable = true){
	           $this->getServer()->getLogger()->info($this->tag . "§aPlugin is Enable!");
		   $this->getServer()->getPluginManager()->registerEvents($this, $this);
                }
	}
	
	public function onLoad(): void{
		$this->getServer()->getLogger()->notice("Loading Data.....");
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool{
		switch($cmd->getName()){
			case "muascoin":
			if(!($sender instanceof Player)){
				$this->getLogger()->notice("Please Dont Use that command in here.");
				return true;
			}
			$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
			$form = $api->createSimpleForm(Function (Player $sender, $data){
				
				$result = $data;
				if ($result == null){
				}
				switch ($result) {
					case 0:
					$sender->sendMessage("§c");
					break;
					case 1:
					$this->information($sender);
					break;
					case 2:
					$this->doiZCoin($sender);
					break;
					case 3:
					$this->doiXu($sender);
					break;
				}
			});
			
			$form->setTitle("§l§aDoiZCoin");
			$form->setContent($this->tag . "§l§a Check Your Money, Please!");
			$form->addButton("§cEXIT", 0);
			$form->addButton("§bInformation", 1);
			$form->addButton("§6Đổi SCoin", 2);
			$form->addButton("§eĐổi Xu", 3);
			$form->sendToPlayer($sender);
		}
		return true;
	}
	
	public function information($sender){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(Function (Player $sender, $data){
		});
		$form->setTitle("§bInformation");
		$form->addLabel("§aWelcome To System MuaSCoin.");
		$form->addLabel("§cCách Mua SCoin Và Xu");
		$form->addLabel("§aNhập Số Xu/SCoin cần thiết vào Ô Input");
		$form->addLabel("§a75k xu = 1 SCoin");
		$form->sendToPlayer($sender);
	}
	
	public function doiZCoin($sender){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(Function (Player $sender, $data){
			
			$data[0] >= 1;
			$tien = $this->money->myMoney($sender);
			if($tien >= $data[0]*75000){
				$sender->sendMessage("§l§b[§cS§fPoin§b]§a>§r§a Bạn đã mua§e " . $data[0] . "§a Scoin");
				$this->money->reduceMoney($sender, $data[0]*75000);
				$this->point->addMoney($sender, $data[0]);
			}else{
				$sender->sendMessage($this->tag . " §l§cKhông Đủ Xu!");
				return true;
			}
		});
		$form->setTitle("§6Đổi SCoin");
		$form->addInput("§aNhập Số ZCoin cần Mua");
		$form->sendToPlayer($sender);
	}
	
	public function doiXu($sender){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(Function (Player $sender, $data){
			
			$data[0] >= 30000;
			$tien = $this->point->myMoney($sender);
			if($tien >= $data[0]*17000){
				$sender->sendMessage("§l§b[§aMua§cXu§b]§a>§r§a Bạn đã mua§e " . $data[0] . "§a Xu");
				$this->point->reduceMoney($sender, $data[0]*30000);
				$this->money->addMoney($sender, $data[0]);
			}else{
				$sender->sendMessage($this->tag . " §l§cKhông Đủ Coin!");
				return true;
			}
		});
		$form->setTitle("§aMua SCoin");
		$form->addInput("§aNhập Số Xu cần Mua");
		$form->sendToPlayer($sender);
	}
	
	
}
