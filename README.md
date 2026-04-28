# PHP Telegram Bot API

A PHP library for interacting with the Telegram Bot API.

## Installation

```bash
composer require telegram/api
```

Or clone and use directly:

```php
require_once __DIR__ . '/src/Bot.php';
require_once __DIR__ . '/src/Keyboard.php';
require_once __DIR__ . '/src/Update.php';
```

## Usage

### Basic

```php
use Telegram\Bot;

$bot = new Bot('YOUR_BOT_TOKEN');

// Send message
$bot->sendMessage(123456789, 'Hello World!');

// Get bot info
$me = $bot->getMe();
```

### Sending Messages

```php
// Text message
$bot->sendMessage($chatId, 'Hello!', [
    'parse_mode' => 'Markdown',
    'reply_markup' => json_encode(Keyboard::inlineKeyboard([
        Keyboard::inlineRow(
            Keyboard::callbackButton('Click', 'data_1'),
            Keyboard::urlButton('Visit', 'https://example.com')
        )
    ]))
]);
```

### Sending Files (local files or URL)

```php
// Photo (local file or URL)
$bot->sendPhoto($chatId, '/path/to/photo.jpg', 'Caption');
$bot->sendPhoto($chatId, 'https://example.com/photo.jpg', 'Caption');

// Document
$bot->sendDocument($chatId, '/path/to/file.pdf');

// Video
$bot->sendVideo($chatId, '/path/to/video.mp4');

// Audio
$bot->sendAudio($chatId, '/path/to/audio.mp3');

// Voice
$bot->sendVoice($chatId, '/path/to/voice.ogg');

// Sticker
$bot->sendSticker($chatId, '/path/to/sticker.webp');

// Animation (GIF)
$bot->sendAnimation($chatId, '/path/to/animation.gif');
```

### Inline Keyboards

```php
use Telegram\Keyboard;

$keyboard = Keyboard::inlineKeyboard([
    Keyboard::inlineRow(
        Keyboard::callbackButton('Option A', 'opt_a'),
        Keyboard::callbackButton('Option B', 'opt_b')
    ),
    Keyboard::inlineRow(
        Keyboard::urlButton('Website', 'https://example.com')
    ),
    Keyboard::inlineRow(
        Keyboard::switchQueryButton('Search', 'query')
    )
]);

$bot->sendMessage($chatId, 'Choose:', [
    'reply_markup' => json_encode($keyboard)
]);
```

### Reply Keyboards

```php
$keyboard = Keyboard::replyKeyboard([
    Keyboard::inlineRow('Button 1', 'Button 2'),
    Keyboard::inlineRow('Button 3', 'Button 4')
], true, true);

$bot->sendMessage($chatId, 'Select:', [
    'reply_markup' => json_encode($keyboard)
]);
```

### Handling Updates

```php
use Telegram\Update;

// From webhook or getUpdates
$update = Update::fromJson($jsonString);

// Get message
$message = $update->getMessage();
if ($message) {
    $text = $message->getText();
    $chatId = $message->getChatId();
    $userId = $message->getUserId();
    
    // Check command
    if ($message->isCommand()) {
        $command = $message->getCommand();
        $args = $message->getArgs();
    }
}

// Handle callback query
$callback = $update->getCallbackQuery();
if ($callback) {
    $data = $callback->getData();
    $userId = $callback->getFrom()->getId();
    
    $bot->answerCallbackQuery($callback->getId(), 'Clicked!', true);
}
```

### Answering Queries

```php
// Callback query
$bot->answerCallbackQuery($callbackId, 'Message', false);

// Inline query
$results = [
    [
        'type' => 'article',
        'id' => '1',
        'title' => 'Result 1',
        'input_message_content' => ['message_text' => 'Content 1']
    ]
];
$bot->answerInlineQuery($inlineQueryId, $results, 300);

// Shipping query
$bot->answerShippingQuery($shippingQueryId, true, [
    'id' => '1',
    'title' => 'Shipping',
    'prices' => [['label' => 'Shipping', 'amount' => 500]]
]);

// Pre checkout query
$bot->answerPreCheckoutQuery($preCheckoutQueryId, true);
```

### Chat Management

```php
// Get chat info
$chat = $bot->getChat($chatId);

// Administrators
$admins = $bot->getChatAdministrators($chatId);
$count = $bot->getChatMemberCount($chatId);

// Member info
$member = $bot->getChatMember($chatId, $userId);

// Ban/Unban
$bot->banChatMember($chatId, $userId, time() + 3600);
$bot->unbanChatMember($chatId, $userId);

// Invite link
$link = $bot->exportChatInviteLink($chatId);
$newLink = $bot->createChatInviteLink($chatId);

// Set title/description
$bot->setChatTitle($chatId, 'New Title');
$bot->setChatDescription($chatId, 'Description');
```

### Message Editing

```php
// Edit text
$bot->editMessageText($chatId, $messageId, 'New text', [
    'reply_markup' => json_encode($keyboard)
]);

// Edit caption
$bot->editMessageCaption($chatId, $messageId, 'New caption');

// Edit inline keyboard
$bot->editMessageReplyMarkup($chatId, $messageId, $replyMarkup);

// Delete
$bot->deleteMessage($chatId, $messageId);

// Pin/Unpin
$bot->pinChatMessage($chatId, $messageId);
$bot->unpinChatMessage($chatId);
```

### Location & Contact

```php
$bot->sendLocation($chatId, 40.7128, -74.0060);
$bot->sendVenue($chatId, 40.7128, -74.0060, 'Venue Name', 'Address');
$bot->sendContact($chatId, '+1234567890', 'John');
$bot->sendPoll($chatId, 'Question?', ['Yes', 'No']);
$bot->sendDice($chatId, '🎲');
```

### Webhook

```php
$bot->setWebhook('https://example.com/webhook');
$bot->deleteWebhook();

// Get webhook info
$info = $bot->getWebhookInfo();
```

### File Operations

```php
// Get file info
$file = $bot->getFile($fileId);

// Download file
$bot->downloadFile($file['result']['file_path'], '/save/path');
```

### Bot Commands

```php
// Set bot commands
$bot->setMyCommands([
    ['command' => 'start', 'description' => 'Start the bot'],
    ['command' => 'help', 'description' => 'Show help'],
    ['command' => 'settings', 'description' => 'Settings']
]);

// Get commands
$commands = $bot->getMyCommands();

// Delete commands
$bot->deleteMyCommands();
```

### Bot Info

```php
$bot->getMe();
$bot->getMyName();
$bot->getMyDescription();
$bot->getMyShortDescription();
```

## API Methods

All Telegram Bot API methods are supported. See [Telegram API Documentation](https://core.telegram.org/bots/api) for full list.

## License

MIT


See also [https://ubuntubase.com/software/php-telegram-bot-api/](https://ubuntubase.com/software/php-telegram-bot-api/)
