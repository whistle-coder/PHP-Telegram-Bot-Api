<?php

namespace Telegram;

class Keyboard
{
    public static function inlineKeyboard(array $rows): array
    {
        return [
            'inline_keyboard' => array_map(function ($row) {
                return array_map(function ($button) {
                    if (is_array($button)) {
                        return $button;
                    }
                    return $button;
                }, $row);
            }, $rows),
        ];
    }

    public static function replyKeyboard(array $rows, bool $resizeKeyboard = true, bool $oneTimeKeyboard = false, bool $selective = false): array
    {
        return [
            'keyboard' => array_map(function ($row) {
                return array_map(function ($button) {
                    if (is_string($button)) {
                        return ['text' => $button];
                    }
                    return $button;
                }, $row);
            }, $rows),
            'resize_keyboard' => $resizeKeyboard,
            'one_time_keyboard' => $oneTimeKeyboard,
            'selective' => $selective,
        ];
    }

    public static function removeKeyboard(bool $selective = false): array
    {
        return [
            'remove_keyboard' => true,
            'selective' => $selective,
        ];
    }

    public static function button(string $text, string $callbackData = '', string $url = '', string $loginUrl = '', int $gameId = 0): array
    {
        if ($loginUrl) {
            return [
                'text' => $text,
                'login_url' => is_array($loginUrl) ? $loginUrl : ['url' => $loginUrl],
            ];
        }

        if ($callbackData) {
            return [
                'text' => $text,
                'callback_data' => $callbackData,
            ];
        }

        if ($url) {
            return [
                'text' => $text,
                'url' => $url,
            ];
        }

        if ($gameId) {
            return [
                'text' => $text,
                'game' => true,
            ];
        }

        return ['text' => $text];
    }

    public static function urlButton(string $text, string $url): array
    {
        return ['text' => $text, 'url' => $url];
    }

    public static function callbackButton(string $text, string $callbackData): array
    {
        return ['text' => $text, 'callback_data' => $callbackData];
    }

    public static function gameButton(string $text): array
    {
        return ['text' => $text, 'game' => true];
    }

    public static function switchQueryButton(string $text, string $query): array
    {
        return ['text' => $text, 'switch_inline_query' => $query];
    }

    public static function switchQueryCurrentChatButton(string $text, string $query = ''): array
    {
        return $query
            ? ['text' => $text, 'switch_inline_query_current_chat' => $query]
            : ['text' => $text, 'switch_inline_query_current_chat' => ''];
    }

    public static function loginButton(string $text, string $url, bool $forwardText = false): array
    {
        $button = ['text' => $text, 'login_url' => ['url' => $url]];

        if ($forwardText) {
            $button['login_url']['forward_text'] = $forwardText;
        }

        return $button;
    }

    public static function switchInlineQueryButton(string $text, string $query = ''): array
    {
        return $query
            ? ['text' => $text, 'switch_inline_query' => $query]
            : ['text' => $text, 'switch_inline_query' => ''];
    }

    public static function inlineRow(...$buttons): array
    {
        return $buttons;
    }
}