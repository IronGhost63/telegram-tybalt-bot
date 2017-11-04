<?php
require 'vendor/autoload.php';

use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use function TybaltBot\Helper\WvW\get_match_score as get_match_score;

$telegram = new Api('471790556:AAGOQmKyMOzlanLLqBfJczQe7JCNahSo5IQ');

$telegram->addCommands([
	TybaltBot\Command\HelpCommand::class,
	TybaltBot\Command\StartCommand::class,
	TybaltBot\Command\WorldsCommand::class,
	TybaltBot\Command\MatchCommand::class,
	TybaltBot\Command\SkirmishCommand::class
]);

$update = $telegram->commandsHandler(true);

if ($update->isType('callback_query')) {
	$query = $update->getCallbackQuery();
	$data  = $query->getData();
	$chid = $query->getFrom()->getId();

	$query_id = $query->getId();
	$message_id = $query->getMessage()->getMessageId();
	$chat_id = $query->getMessage()->getChat()->getId();

	$call = explode(":", $data);

	switch ($call[0]) {
		case "match" :
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

			$telegram->editMessageText([
				'chat_id' => $chat_id,
				'message_id' => $message_id,
				'text' => $response = get_match_score($call[1]),
				'reply_markup' => $keyboard,
				'parse_mode' => 'Markdown'
			]);

			$telegram->answerCallbackQuery([
				'callback_query_id' => $query_id,
				'text' => "Score has been updated to selected map!",
				'show_alert' => true
			]);
			break;
	}
}

?>