<?php
namespace TybaltBot\Command;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use GW2Treasures\GW2Api\GW2Api;

class WorldsCommand extends Command {
	/**
	 * @var string Command Name
	 */
	protected $name = "worlds";

	/**
	 * @var string Command Description
	 */
	protected $description = "List all worlds in Guild Wars 2 with population state";

	/**
	 * @inheritdoc
	 */
	public function handle($arguments) {
		$api = new \GW2Treasures\GW2Api\GW2Api();
		$worlds = $api->worlds()->all();
		$zone = strtolower($arguments);
		$response = '';

		switch($zone) {
			case "na" :
				$zone_text = "Here are all worlds in North America.";
				foreach ($worlds as $world) {
					if($world->id < 2000){
						$response .= $world->id . " - " . $world->name . "  _" . $world->population . "_" . PHP_EOL;
					}
				}
				break;
			case "eu" :
				$zone_text = "Here are all worlds in Europe.";
				foreach ($worlds as $world) {
					if($world->id > 2000){
						$response .= $world->id . " - " . $world->name . "  _" . $world->population . "_" . PHP_EOL;
					}
				}
				break;
			default :
				$zone_text = "Here is the list of all worlds in Guild Wars 2!";
				foreach ($worlds as $world) {
					$response .= $world->id . " - " . $world->name . "  _" . $world->population . "_" . PHP_EOL;
				}
		}

		$this->replyWithMessage(['text' => $zone_text]);
		$this->replyWithChatAction(['action' => Actions::TYPING]);
		$this->replyWithMessage(['text' => $response, 'parse_mode' => "Markdown"]);
	}
}