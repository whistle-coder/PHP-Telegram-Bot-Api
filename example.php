<?php

require_once __DIR__ . '/src/Bot.php';
require_once __DIR__ . '/src/Keyboard.php';
require_once __DIR__ . '/src/Update.php';

use Telegram\Bot;
use Telegram\Keyboard;
use Telegram\Update;

$bot = new Bot('YOUR_BOT_TOKEN');

echo "Bot API Test\n";
echo "===========\n\n";

$me = $bot->getMe();
echo "getMe: ";
print_r($me);

echo "\n\nSending message...\n";
$response = $bot->sendMessage(123456789, 'Hello from PHP Telegram API!');
print_r($response);

echo "\n\nSending with inline keyboard...\n";
$keyboard = Keyboard::inlineKeyboard([
    Keyboard::inlineRow(
        Keyboard::callbackButton('Click Me', 'callback_data_1'),
        Keyboard::urlButton('Open URL', 'https://example.com')
    ),
    Keyboard::inlineRow(
        Keyboard::switchQueryButton('Search', 'search query')
    ),
]);

$response = $bot->sendMessage(123456789, 'Choose an option:', ['reply_markup' => json_encode($keyboard)]);
print_r($response);

echo "\n\nSending photo...\n";
$response = $bot->sendPhoto(123456789, '/path/to/photo.jpg', 'Photo caption');
print_r($response);

echo "\n\nForwarding message...\n";
$response = $bot->forwardMessage(123456789, -1001234567890, 42);
print_r($response);

echo "\n\nAnswering callback query...\n";
$response = $bot->answerCallbackQuery('callback_query_id', 'You clicked!', true);
print_r($response);

echo "\n\nPin message...\n";
$response = $bot->pinChatMessage(123456789, 123);
print_r($response);

echo "\n\nGet chat...\n";
$response = $bot->getChat(123456789);
print_r($response);