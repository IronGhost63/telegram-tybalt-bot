<?php
namespace TybaltBot\Command;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use GW2Treasures\GW2Api\GW2Api;

class HelpCommand extends Command
{
	/**
	 * @var string Command Name
	 */
	protected $name = "help";

	/**
	 * @var string Command Description
	 */
	protected $description = "List all commands";

	/**
	 * @inheritdoc
	 */
	public function handle($arguments)
	{
		$this->replyWithChatAction(['action' => Actions::TYPING]);

		$commands = $this->getTelegram()->getCommands();
		$response = '';
		foreach ($commands as $name => $command) {
			$response .= sprintf('/%s - %s' . PHP_EOL, $name, $command->getDescription());
		}

		$this->replyWithMessage(['text' => $response]);
	}
}