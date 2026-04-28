<?php

namespace Telegram;

class Bot
{
    private string $token;
    private string $apiUrl = 'https://api.telegram.org';
    private ?int $timeout = 60;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function setTimeout(int $timeout): self
    {
        $this->timeout = $timeout;
        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function sendMessage(int|string $chatId, string $text, array $options = []): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
            'text' => $text,
        ], $options);

        return $this->request('sendMessage', $params);
    }

    public function sendPhoto(int|string $chatId, $photo, string $caption = '', array $options = []): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
        ], is_file($photo) ? ['photo' => $this->prepareFile($photo)] : ['photo' => $photo]);

        if ($caption) {
            $params['caption'] = $caption;
        }

        return $this->request('sendPhoto', $params, !is_file($photo));
    }

    public function sendDocument(int|string $chatId, $document, string $caption = '', array $options = []): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
        ], is_file($document) ? ['document' => $this->prepareFile($document)] : ['document' => $document]);

        if ($caption) {
            $params['caption'] = $caption;
        }

        return $this->request('sendDocument', $params, !is_file($document));
    }

    public function sendAudio(int|string $chatId, $audio, array $options = []): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
        ], is_file($audio) ? ['audio' => $this->prepareFile($audio)] : ['audio' => $audio]);

        return $this->request('sendAudio', $params, !is_file($audio));
    }

    public function sendVideo(int|string $chatId, $video, string $caption = '', array $options = []): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
        ], is_file($video) ? ['video' => $this->prepareFile($video)] : ['video' => $video]);

        if ($caption) {
            $params['caption'] = $caption;
        }

        return $this->request('sendVideo', $params, !is_file($video));
    }

    public function sendVoice(int|string $chatId, $voice, array $options = []): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
        ], is_file($voice) ? ['voice' => $this->prepareFile($voice)] : ['voice' => $voice]);

        return $this->request('sendVoice', $params, !is_file($voice));
    }

    public function sendVideoNote(int|string $chatId, $videoNote, array $options = []): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
        ], is_file($videoNote) ? ['video_note' => $this->prepareFile($videoNote)] : ['video_note' => $videoNote]);

        return $this->request('sendVideoNote', $params, !is_file($videoNote));
    }

    public function sendSticker(int|string $chatId, $sticker, array $options = []): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
        ], is_file($sticker) ? ['sticker' => $this->prepareFile($sticker)] : ['sticker' => $sticker]);

        return $this->request('sendSticker', $params, !is_file($sticker));
    }

    public function sendAnimation(int|string $chatId, $animation, string $caption = '', array $options = []): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
        ], is_file($animation) ? ['animation' => $this->prepareFile($animation)] : ['animation' => $animation]);

        if ($caption) {
            $params['caption'] = $caption;
        }

        return $this->request('sendAnimation', $params, !is_file($animation));
    }

    public function sendLocation(int|string $chatId, float $latitude, float $longitude, array $options = []): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ], $options);

        return $this->request('sendLocation', $params);
    }

    public function sendVenue(int|string $chatId, float $latitude, float $longitude, string $title, string $address, array $options = []): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'title' => $title,
            'address' => $address,
        ], $options);

        return $this->request('sendVenue', $params);
    }

    public function sendContact(int|string $chatId, string $phoneNumber, string $firstName, array $options = []): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
            'phone_number' => $phoneNumber,
            'first_name' => $firstName,
        ], $options);

        return $this->request('sendContact', $params);
    }

    public function sendPoll(int|string $chatId, string $question, array $options, bool $isAnonymous = true, string $type = 'regular'): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
            'question' => $question,
            'options' => json_encode($options),
            'is_anonymous' => $isAnonymous,
            'type' => $type,
        ], $options);

        return $this->request('sendPoll', $params);
    }

    public function sendDice(int|string $chatId, string $emoji = '🎲', array $options = []): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
            'emoji' => $emoji,
        ], $options);

        return $this->request('sendDice', $params);
    }

    public function sendChatAction(int|string $chatId, string $action): array
    {
        return $this->request('sendChatAction', [
            'chat_id' => $chatId,
            'action' => $action,
        ]);
    }

    public function sendMediaGroup(int|string $chatId, array $media, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'media' => json_encode($media),
        ];

        return $this->request('sendMediaGroup', $params);
    }

    public function sendInvoice(int|string $chatId, array $invoice, array $options = []): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
        ], $invoice);

        return $this->request('sendInvoice', $params);
    }

    public function sendGame(int|string $chatId, string $gameShortName, array $options = []): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
            'game_short_name' => $gameShortName,
        ], $options);

        return $this->request('sendGame', $params);
    }

    public function copyMessage(int|string $chatId, int $fromChatId, int $messageId, array $options = []): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
            'from_chat_id' => $fromChatId,
            'message_id' => $messageId,
        ], $options);

        return $this->request('copyMessage', $params);
    }

    public function copyMessages(int|string $chatId, int $fromChatId, array $messageIds, array $options = []): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
            'from_chat_id' => $fromChatId,
            'message_ids' => json_encode($messageIds),
        ], $options);

        return $this->request('copyMessages', $params);
    }

    public function forwardMessage(int|string $chatId, int $fromChatId, int $messageId, bool $disableNotification = false): array
    {
        return $this->request('forwardMessage', [
            'chat_id' => $chatId,
            'from_chat_id' => $fromChatId,
            'message_id' => $messageId,
            'disable_notification' => $disableNotification,
        ]);
    }

    public function forwardMessages(int|string $chatId, int $fromChatId, array $messageIds, bool $disableNotification = false): array
    {
        return $this->request('forwardMessages', [
            'chat_id' => $chatId,
            'from_chat_id' => $fromChatId,
            'message_ids' => json_encode($messageIds),
            'disable_notification' => $disableNotification,
        ]);
    }

    public function getUpdates(int $offset = 0, int $limit = 100, int $timeout = 0, array $allowedUpdates = []): array
    {
        $params = [
            'offset' => $offset,
            'limit' => $limit,
            'timeout' => $timeout,
        ];

        if ($allowedUpdates) {
            $params['allowed_updates'] = json_encode($allowedUpdates);
        }

        return $this->request('getUpdates', $params);
    }

    public function getMe(): array
    {
        return $this->request('getMe');
    }

    public function getMyCommands(array $scope = [], string $languageCode = ''): array
    {
        $params = [];

        if ($scope) {
            $params['scope'] = json_encode($scope);
        }

        if ($languageCode) {
            $params['language_code'] = $languageCode;
        }

        return $this->request('getMyCommands', $params);
    }

    public function setMyCommands(array $commands, string $languageCode = ''): array
    {
        $params = [
            'commands' => json_encode($commands),
        ];

        if ($languageCode) {
            $params['language_code'] = $languageCode;
        }

        return $this->request('setMyCommands', $params);
    }

    public function deleteMyCommands(array $scope = [], string $languageCode = ''): array
    {
        $params = [];

        if ($scope) {
            $params['scope'] = json_encode($scope);
        }

        if ($languageCode) {
            $params['language_code'] = $languageCode;
        }

        return $this->request('deleteMyCommands', $params);
    }

    public function getChat(int|string $chatId): array
    {
        return $this->request('getChat', ['chat_id' => $chatId]);
    }

    public function getChatAdministrators(int|string $chatId): array
    {
        return $this->request('getChatAdministrators', ['chat_id' => $chatId]);
    }

    public function getChatMemberCount(int|string $chatId): array
    {
        return $this->request('getChatMemberCount', ['chat_id' => $chatId]);
    }

    public function getChatMember(int|string $chatId, int $userId): array
    {
        return $this->request('getChatMember', [
            'chat_id' => $chatId,
            'user_id' => $userId,
        ]);
    }

    public function getChatMenuButton(int|string $chatId = 0, int $userId = 0): array
    {
        $params = [];

        if ($chatId) {
            $params['chat_id'] = $chatId;
        }

        if ($userId) {
            $params['user_id'] = $userId;
        }

        return $this->request('getChatMenuButton', $params);
    }

    public function setChatMenuButton(int|string $chatId = 0, array $menuButton): array
    {
        $params = [
            'menu_button' => json_encode($menuButton),
        ];

        if ($chatId) {
            $params['chat_id'] = $chatId;
        }

        return $this->request('setChatMenuButton', $params);
    }

    public function leaveChat(int|string $chatId): array
    {
        return $this->request('leaveChat', ['chat_id' => $chatId]);
    }

    public function banChatMember(int|string $chatId, int $userId, int $untilDate = 0, bool $revokeMessages = false): array
    {
        $params = [
            'chat_id' => $chatId,
            'user_id' => $userId,
            'revoke_messages' => $revokeMessages,
        ];

        if ($untilDate > 0) {
            $params['until_date'] = $untilDate;
        }

        return $this->request('banChatMember', $params);
    }

    public function unbanChatMember(int|string $chatId, int $userId, bool $onlyIfBanned = true): array
    {
        return $this->request('unbanChatMember', [
            'chat_id' => $chatId,
            'user_id' => $userId,
            'only_if_banned' => $onlyIfBanned,
        ]);
    }

    public function restrictChatMember(int|string $chatId, int $userId, array $permissions, int $untilDate = 0): array
    {
        $params = [
            'chat_id' => $chatId,
            'user_id' => $userId,
            'permissions' => json_encode($permissions),
        ];

        if ($untilDate > 0) {
            $params['until_date'] = $untilDate;
        }

        return $this->request('restrictChatMember', $params);
    }

    public function promoteChatMember(int|string $chatId, int $userId, array $options = []): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
            'user_id' => $userId,
        ], $options);

        return $this->request('promoteChatMember', $params);
    }

    public function setChatAdministratorCustomTitle(int|string $chatId, int $userId, string $customTitle): array
    {
        return $this->request('setChatAdministratorCustomTitle', [
            'chat_id' => $chatId,
            'user_id' => $userId,
            'custom_title' => $customTitle,
        ]);
    }

    public function setChatTitle(int|string $chatId, string $title): array
    {
        return $this->request('setChatTitle', [
            'chat_id' => $chatId,
            'title' => $title,
        ]);
    }

    public function setChatDescription(int|string $chatId, string $description): array
    {
        return $this->request('setChatDescription', [
            'chat_id' => $chatId,
            'description' => $description,
        ]);
    }

    public function setChatPhoto(int|string $chatId, string $photo): array
    {
        return $this->request('setChatPhoto', [
            'chat_id' => $chatId,
            'photo' => $this->prepareFile($photo),
        ], false);
    }

    public function deleteChatPhoto(int|string $chatId): array
    {
        return $this->request('deleteChatPhoto', ['chat_id' => $chatId]);
    }

    public function exportChatInviteLink(int|string $chatId): array
    {
        return $this->request('exportChatInviteLink', ['chat_id' => $chatId]);
    }

    public function createChatInviteLink(int|string $chatId, int $expireDate = 0, int $memberLimit = 0, string $name = ''): array
    {
        $params = ['chat_id' => $chatId];

        if ($expireDate > 0) {
            $params['expire_date'] = $expireDate;
        }

        if ($memberLimit > 0) {
            $params['member_limit'] = $memberLimit;
        }

        if ($name) {
            $params['name'] = $name;
        }

        return $this->request('createChatInviteLink', $params);
    }

    public function editChatInviteLink(int|string $chatId, string $inviteLink, int $expireDate = 0, int $memberLimit = 0, string $name = ''): array
    {
        $params = [
            'chat_id' => $chatId,
            'invite_link' => $inviteLink,
        ];

        if ($expireDate > 0) {
            $params['expire_date'] = $expireDate;
        }

        if ($memberLimit > 0) {
            $params['member_limit'] = $memberLimit;
        }

        if ($name) {
            $params['name'] = $name;
        }

        return $this->request('editChatInviteLink', $params);
    }

    public function revokeChatInviteLink(int|string $chatId, string $inviteLink): array
    {
        return $this->request('revokeChatInviteLink', [
            'chat_id' => $chatId,
            'invite_link' => $inviteLink,
        ]);
    }

    public function approveChatJoinRequest(int|string $chatId, int $userId): array
    {
        return $this->request('approveChatJoinRequest', [
            'chat_id' => $chatId,
            'user_id' => $userId,
        ]);
    }

    public function declineChatJoinRequest(int|string $chatId, int $userId): array
    {
        return $this->request('declineChatJoinRequest', [
            'chat_id' => $chatId,
            'user_id' => $userId,
        ]);
    }

    public function editMessageText(int|string $chatId, int $messageId, string $text, array $options = []): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => $text,
        ], $options);

        return $this->request('editMessageText', $params);
    }

    public function editMessageCaption(int|string $chatId, int $messageId, string $caption = '', array $options = []): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
            'message_id' => $messageId,
        ], $caption ? ['caption' => $caption] : [], $options);

        return $this->request('editMessageCaption', $params);
    }

    public function editMessageMedia(int|string $chatId, int $messageId, array $media, array $options = []): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'media' => json_encode($media),
        ], $options);

        return $this->request('editMessageMedia', $params);
    }

    public function editMessageReplyMarkup(int|string $chatId, int $messageId, array $replyMarkup = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
        ];

        if ($replyMarkup) {
            $params['reply_markup'] = json_encode($replyMarkup);
        }

        return $this->request('editMessageReplyMarkup', $params);
    }

    public function stopPoll(int|string $chatId, int $messageId, array $options = []): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
            'message_id' => $messageId,
        ], $options);

        return $this->request('stopPoll', $params);
    }

    public function deleteMessage(int|string $chatId, int $messageId): array
    {
        return $this->request('deleteMessage', [
            'chat_id' => $chatId,
            'message_id' => $messageId,
        ]);
    }

    public function deleteMessages(int|string $chatId, array $messageIds): array
    {
        return $this->request('deleteMessages', [
            'chat_id' => $chatId,
            'message_ids' => json_encode($messageIds),
        ]);
    }

    public function pinChatMessage(int|string $chatId, int $messageId, bool $disableNotification = false): array
    {
        return $this->request('pinChatMessage', [
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'disable_notification' => $disableNotification,
        ]);
    }

    public function unpinChatMessage(int|string $chatId, int $messageId = 0): array
    {
        $params = ['chat_id' => $chatId];

        if ($messageId > 0) {
            $params['message_id'] = $messageId;
        }

        return $this->request('unpinChatMessage', $params);
    }

    public function unpinAllChatMessages(int|string $chatId): array
    {
        return $this->request('unpinAllChatMessages', ['chat_id' => $chatId]);
    }

    public function getStickerSet(string $name): array
    {
        return $this->request('getStickerSet', ['name' => $name]);
    }

    public function getCustomEmojiStickers(array $customEmojiIds): array
    {
        return $this->request('getCustomEmojiStickers', [
            'custom_emoji_ids' => json_encode($customEmojiIds),
        ]);
    }

    public function uploadStickerFile(int $userId, string $pngSticker): array
    {
        return $this->request('uploadStickerFile', [
            'user_id' => $userId,
            'png_sticker' => $this->prepareFile($pngSticker),
        ], false);
    }

    public function createNewStickerSet(int $userId, string $name, string $title, string $pngSticker, string $emojis, array $options = []): array
    {
        $params = array_merge([
            'user_id' => $userId,
            'name' => $name,
            'title' => $title,
            'png_sticker' => $this->prepareFile($pngSticker),
            'emojis' => $emojis,
        ], $options);

        return $this->request('createNewStickerSet', $params, false);
    }

    public function addStickerToSet(int $userId, string $name, string $pngSticker, string $emojis, array $options = []): array
    {
        $params = array_merge([
            'user_id' => $userId,
            'name' => $name,
            'png_sticker' => $this->prepareFile($pngSticker),
            'emojis' => $emojis,
        ], $options);

        return $this->request('addStickerToSet', $params, false);
    }

    public function setStickerPositionInSet(string $stickers, int $position): array
    {
        return $this->request('setStickerPositionInSet', [
            'sticker' => $stickers,
            'position' => $position,
        ]);
    }

    public function deleteStickerFromSet(string $sticker): array
    {
        return $this->request('deleteStickerFromSet', ['sticker' => $sticker]);
    }

    public function replaceStickerInSet(int $userId, string $name, string $sticker, string $pngSticker, string $emojis, array $options = []): array
    {
        $params = array_merge([
            'user_id' => $userId,
            'name' => $name,
            'old_sticker' => $sticker,
            'png_sticker' => $this->prepareFile($pngSticker),
            'emojis' => $emojis,
        ], $options);

        return $this->request('replaceStickerInSet', $params, false);
    }

    public function createForumTopic(int|string $chatId, string $name, int $iconColor = 7322096, string $iconCustomEmojiId = ''): array
    {
        $params = [
            'chat_id' => $chatId,
            'name' => $name,
            'icon_color' => $iconColor,
        ];

        if ($iconCustomEmojiId) {
            $params['icon_custom_emoji_id'] = $iconCustomEmojiId;
        }

        return $this->request('createForumTopic', $params);
    }

    public function editForumTopic(int|string $chatId, int $messageThreadId, string $name = '', int $iconColor = 0, string $iconCustomEmojiId = ''): array
    {
        $params = [
            'chat_id' => $chatId,
            'message_thread_id' => $messageThreadId,
        ];

        if ($name) {
            $params['name'] = $name;
        }

        if ($iconColor > 0) {
            $params['icon_color'] = $iconColor;
        }

        if ($iconCustomEmojiId) {
            $params['icon_custom_emoji_id'] = $iconCustomEmojiId;
        }

        return $this->request('editForumTopic', $params);
    }

    public function closeForumTopic(int|string $chatId, int $messageThreadId): array
    {
        return $this->request('closeForumTopic', [
            'chat_id' => $chatId,
            'message_thread_id' => $messageThreadId,
        ]);
    }

    public function reopenForumTopic(int|string $chatId, int $messageThreadId): array
    {
        return $this->request('reopenForumTopic', [
            'chat_id' => $chatId,
            'message_thread_id' => $messageThreadId,
        ]);
    }

    public function deleteForumTopic(int|string $chatId, int $messageThreadId): array
    {
        return $this->request('deleteForumTopic', [
            'chat_id' => $chatId,
            'message_thread_id' => $messageThreadId,
        ]);
    }

    public function unpinAllForumTopicMessages(int|string $chatId, int $messageThreadId): array
    {
        return $this->request('unpinAllForumTopicMessages', [
            'chat_id' => $chatId,
            'message_thread_id' => $messageThreadId,
        ]);
    }

    public function getForumTopicIconColors(): array
    {
        return $this->request('getForumTopicIconColors');
    }

    public function getWebhookInfo(): array
    {
        return $this->request('getWebhookInfo');
    }

    public function setWebhook(string $url, array $options = []): array
    {
        $params = array_merge(['url' => $url], $options);

        return $this->request('setWebhook', $params);
    }

    public function deleteWebhook(bool $dropPendingUpdates = false): array
    {
        return $this->request('deleteWebhook', [
            'drop_pending_updates' => $dropPendingUpdates,
        ]);
    }

    public function getFile(string $fileId): array
    {
        return $this->request('getFile', ['file_id' => $fileId]);
    }

    public function getFileUrl(string $filePath): string
    {
        return "{$this->apiUrl}/file/bot{$this->token}/{$filePath}";
    }

    public function downloadFile(string $filePath, string $savePath): bool
    {
        $url = $this->getFileUrl($filePath);
        $fp = fopen($savePath, 'w+');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result = curl_exec($ch);
        curl_close($ch);
        fclose($fp);

        return $result !== false;
    }

    public function answerCallbackQuery(string $callbackQueryId, string $text = '', bool $showAlert = false, string $url = '', int $cacheTime = 0): array
    {
        $params = [
            'callback_query_id' => $callbackQueryId,
        ];

        if ($text) {
            $params['text'] = $text;
        }

        if ($showAlert) {
            $params['show_alert'] = $showAlert;
        }

        if ($url) {
            $params['url'] = $url;
        }

        if ($cacheTime > 0) {
            $params['cache_time'] = $cacheTime;
        }

        return $this->request('answerCallbackQuery', $params);
    }

    public function answerInlineQuery(string $inlineQueryId, array $results, int $cacheTime = 300, bool $isPersonal = false, string $nextOffset = '', string $switchPmText = '', string $switchPmParameter = ''): array
    {
        $params = [
            'inline_query_id' => $inlineQueryId,
            'results' => json_encode($results),
            'cache_time' => $cacheTime,
            'is_personal' => $isPersonal,
        ];

        if ($nextOffset) {
            $params['next_offset'] = $nextOffset;
        }

        if ($switchPmText) {
            $params['switch_pm_text'] = $switchPmText;
            $params['switch_pm_parameter'] = $switchPmParameter;
        }

        return $this->request('answerInlineQuery', $params);
    }

    public function answerPreCheckoutQuery(string $preCheckoutQueryId, bool $ok, string $errorMessage = ''): array
    {
        $params = [
            'pre_checkout_query_id' => $preCheckoutQueryId,
            'ok' => $ok,
        ];

        if (!$ok && $errorMessage) {
            $params['error_message'] = $errorMessage;
        }

        return $this->request('answerPreCheckoutQuery', $params);
    }

    public function answerShippingQuery(string $shippingQueryId, bool $ok, array $options = []): array
    {
        $params = array_merge([
            'shipping_query_id' => $shippingQueryId,
            'ok' => $ok,
        ], $options);

        return $this->request('answerShippingQuery', $params);
    }

    public function getGameHighScores(int $userId, int $score, int $topOnly = 0): array
    {
        return $this->request('getGameHighScores', [
            'user_id' => $userId,
            'score' => $score,
            'top_only' => $topOnly,
        ]);
    }

    public function setGameScore(int $userId, int $score, bool $force = false, int $messageId = 0, int $chatId = 0): array
    {
        $params = [
            'user_id' => $userId,
            'score' => $score,
            'force' => $force,
        ];

        if ($messageId > 0) {
            $params['message_id'] = $messageId;
            $params['chat_id'] = $chatId;
        }

        return $this->request('setGameScore', $params);
    }

    public function getMyName(string $languageCode = ''): array
    {
        $params = [];

        if ($languageCode) {
            $params['language_code'] = $languageCode;
        }

        return $this->request('getMyName', $params);
    }

    public function setMyName(string $name, string $languageCode = ''): array
    {
        $params = ['name' => $name];

        if ($languageCode) {
            $params['language_code'] = $languageCode;
        }

        return $this->request('setMyName', $params);
    }

    public function getMyDescription(string $languageCode = ''): array
    {
        $params = [];

        if ($languageCode) {
            $params['language_code'] = $languageCode;
        }

        return $this->request('getMyDescription', $params);
    }

    public function setMyDescription(string $description, string $languageCode = ''): array
    {
        $params = ['description' => $description];

        if ($languageCode) {
            $params['language_code'] = $languageCode;
        }

        return $this->request('setMyDescription', $params);
    }

    public function getMyShortDescription(string $languageCode = ''): array
    {
        $params = [];

        if ($languageCode) {
            $params['language_code'] = $languageCode;
        }

        return $this->request('getMyShortDescription', $params);
    }

    public function setMyShortDescription(string $shortDescription, string $languageCode = ''): array
    {
        $params = ['short_description' => $shortDescription];

        if ($languageCode) {
            $params['language_code'] = $languageCode;
        }

        return $this->request('setMyShortDescription', $params);
    }

    public function getUserChatBoots(int $userId): array
    {
        return $this->request('getUserChatBoots', ['user_id' => $userId]);
    }

    private function prepareFile(string $file): array
    {
        return [
            'file' => new \CURLFile($file),
        ];
    }

    private function request(string $method, array $params = [], bool $isPost = true): array
    {
        $url = "{$this->apiUrl}/bot{$this->token}/{$method}";

        $ch = curl_init();
        
        if ($isPost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        if ($this->timeout) {
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        }

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return ['ok' => false, 'error' => $error];
        }

        return json_decode($response, true) ?? ['ok' => false, 'error' => 'Invalid response'];
    }
}