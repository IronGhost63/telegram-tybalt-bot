<?php
namespace TybaltBot\Command;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use GW2Treasures\GW2Api\GW2Api;

class StartCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "start";

    /**
     * @var string Command Description
     */
    protected $description = "Start using TybaltBot";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
        $this->replyWithMessage(['text' => 'My name is Tybalt Leftpaw, Lightbringer of the Order of Whispers, and that’s Agent to you!']);
        $this->triggerCommand('help');
    }
}