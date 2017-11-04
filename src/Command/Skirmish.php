<?php
namespace TybaltBot\Command;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;
use GW2Treasures\GW2Api\GW2Api;

class SkirmishCommand extends Command {
	/**
	 * @var string Command Name
	 */
	protected $name = "skirmish";

	/**
	 * @var string Command Description
	 */
	protected $description = "Display WvW score for current skirmish";

	/**
	 * @inheritdoc
	 */
	public function handle($arguments) {
		$api = new \GW2Treasures\GW2Api\GW2Api();
		$worlds = $api->worlds()->all();
		$zone = strtolower($arguments);

		$caption = "WvW score for current skirmish";

		$keyboard = Keyboard::make()
		->inline()
		->row(
			 Keyboard::inlineButton([
				  'text' => 'Overall',
				  'callback_data' => 'match'
			 ]),
			 Keyboard::inlineButton([
				  'text' => 'Eternal Battlegrounds',
				  'callback_data' => 'ebg'
			 ])
		)
		->row(
			Keyboard::inlineButton([
				 'text' => 'Red BL',
				 'callback_data' => 'red'
			]),
			Keyboard::inlineButton([
				 'text' => 'Green BL',
				 'callback_data' => 'green'
			]),
			Keyboard::inlineButton([
				 'text' => 'Blue BL',
				 'callback_data' => 'blue'
			])
		);

		$this->replyWithMessage([
			'text' => $caption,
			'reply_markup' => $keyboard
		]);
	}
}