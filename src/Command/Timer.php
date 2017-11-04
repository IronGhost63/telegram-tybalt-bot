<?php
namespace TybaltBot\Command;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class TimerCommand extends Command {
	/**
	 * @var string Command Name
	 */
	protected $name = "timer";

	/**
	 * @var string Command Description
	 */
	protected $description = "Event Timers";

	/**
	 * @inheritdoc
	 */
	public function handle($arguments) {
		$this->replyWithChatAction(['action' => Actions::TYPING]);

		$arguments = explode(" ", $arguments);

		switch($arguments[0]){
			case "day":
			case "night":
			case "cycle":

				break;
			case "boss":
			default:
				$response = $this->help();
		}

		$response = $this->help();

		$this->replyWithMessage([
			'text' => $response,
			'reply_markup' => $keyboard,
			'parse_mode' => 'Markdown'
		]);
	}

	public function help(){
		return "Details about /timer arguments";
	}
}