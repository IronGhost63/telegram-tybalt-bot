<?php
namespace TybaltBot\Command;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;
use function TybaltBot\Helper\WvW\PPT_count as PPT_count;
use function TybaltBot\Helper\WvW\get_match_score as get_match_score;

class MatchCommand extends Command {
	/**
	 * @var string Command Name
	 */
	protected $name = "match";

	/**
	 * @var string Command Description
	 */
	protected $description = "Display WvW score for current match";

	/**
	 * @inheritdoc
	 */
	public function handle($arguments) {
		$this->replyWithChatAction(['action' => Actions::TYPING]);
		if(empty($arguments)){
			$arguments = 1018;
		}

		$response = get_match_score("all", $arguments);

		$keyboard = Keyboard::make()
		->inline()
		->row(
			 Keyboard::inlineButton([
				  'text' => 'Overall',
				  'callback_data' => 'match:all'
			 ]),
			 Keyboard::inlineButton([
				  'text' => 'Eternal Battlegrounds',
				  'callback_data' => 'match:ebg'
			 ])
		)
		->row(
			Keyboard::inlineButton([
				 'text' => 'Red BL',
				 'callback_data' => 'match:red'
			]),
			Keyboard::inlineButton([
				 'text' => 'Green BL',
				 'callback_data' => 'match:green'
			]),
			Keyboard::inlineButton([
				 'text' => 'Blue BL',
				 'callback_data' => 'match:blue'
			])
		);

		$this->replyWithMessage([
			'text' => $response,
			'reply_markup' => $keyboard,
			'parse_mode' => 'Markdown'
		]);
	}
}