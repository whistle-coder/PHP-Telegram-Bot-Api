<?php

namespace Telegram;

class Update
{
    private array $update;

    public function __construct(array $update)
    {
        $this->update = $update;
    }

    public static function fromJson(string $json): self
    {
        return new self(json_decode($json, true));
    }

    public static function fromArray(array $update): self
    {
        return new self($update);
    }

    public function getUpdateId(): int
    {
        return $this->update['update_id'] ?? 0;
    }

    public function getMessage(): ?Message
    {
        if (!isset($this->update['message'])) {
            return null;
        }
        return new Message($this->update['message']);
    }

    public function getEditedMessage(): ?Message
    {
        if (!isset($this->update['edited_message'])) {
            return null;
        }
        return new Message($this->update['edited_message']);
    }

    public function getChannelPost(): ?Message
    {
        if (!isset($this->update['channel_post'])) {
            return null;
        }
        return new Message($this->update['channel_post']);
    }

    public function getEditedChannelPost(): ?Message
    {
        if (!isset($this->update['edited_channel_post'])) {
            return null;
        }
        return new Message($this->update['edited_channel_post']);
    }

    public function getCallbackQuery(): ?CallbackQuery
    {
        if (!isset($this->update['callback_query'])) {
            return null;
        }
        return new CallbackQuery($this->update['callback_query']);
    }

    public function getInlineQuery(): ?InlineQuery
    {
        if (!isset($this->update['inline_query'])) {
            return null;
        }
        return new InlineQuery($this->update['inline_query']);
    }

    public function getShippingQuery(): ?ShippingQuery
    {
        if (!isset($this->update['shipping_query'])) {
            return null;
        }
        return new ShippingQuery($this->update['shipping_query']);
    }

    public function getPreCheckoutQuery(): ?PreCheckoutQuery
    {
        if (!isset($this->update['pre_checkout_query'])) {
            return null;
        }
        return new PreCheckoutQuery($this->update['pre_checkout_query']);
    }

    public function getPoll(): ?Poll
    {
        if (!isset($this->update['poll'])) {
            return null;
        }
        return new Poll($this->update['poll']);
    }

    public function getPollAnswer(): ?PollAnswer
    {
        if (!isset($this->update['poll_answer'])) {
            return null;
        }
        return new PollAnswer($this->update['poll_answer']);
    }

    public function getMyChatMember(): ?ChatMemberUpdated
    {
        if (!isset($this->update['my_chat_member'])) {
            return null;
        }
        return new ChatMemberUpdated($this->update['my_chat_member']);
    }

    public function getChatMember(): ?ChatMemberUpdated
    {
        if (!isset($this->update['chat_member'])) {
            return null;
        }
        return new ChatMemberUpdated($this->update['chat_member']);
    }

    public function getChatJoinRequest(): ?ChatJoinRequest
    {
        if (!isset($this->update['chat_join_request'])) {
            return null;
        }
        return new ChatJoinRequest($this->update['chat_join_request']);
    }

    public function getRaw(): array
    {
        return $this->update;
    }
}

class Message
{
    private array $message;

    public function __construct(array $message)
    {
        $this->message = $message;
    }

    public function getMessageId(): int
    {
        return $this->message['message_id'] ?? 0;
    }

    public function getChat(): ?Chat
    {
        if (!isset($this->message['chat'])) {
            return null;
        }
        return new Chat($this->message['chat']);
    }

    public function getFrom(): ?User
    {
        if (!isset($this->message['from'])) {
            return null;
        }
        return new User($this->message['from']);
    }

    public function getForwardFrom(): ?User
    {
        if (!isset($this->message['forward_from'])) {
            return null;
        }
        return new User($this->message['forward_from']);
    }

    public function getForwardFromMessage(): ?Chat
    {
        if (!isset($this->message['forward_from_chat'])) {
            return null;
        }
        return new Chat($this->message['forward_from_chat']);
    }

    public function getForwardDate(): ?int
    {
        return $this->message['forward_date'] ?? null;
    }

    public function getEditDate(): ?int
    {
        return $this->message['edit_date'] ?? null;
    }

    public function getText(): ?string
    {
        return $this->message['text'] ?? null;
    }

    public function getCaption(): ?string
    {
        return $this->message['caption'] ?? null;
    }

    public function getEntities(): array
    {
        return $this->message['entities'] ?? [];
    }

    public function getPhoto(): ?array
    {
        return $this->message['photo'] ?? null;
    }

    public function getAudio(): ?array
    {
        return $this->message['audio'] ?? null;
    }

    public function getDocument(): ?array
    {
        return $this->message['document'] ?? null;
    }

    public function getAnimation(): ?array
    {
        return $this->message['animation'] ?? null;
    }

    public function getVideo(): ?array
    {
        return $this->message['video'] ?? null;
    }

    public function getVideoNote(): ?array
    {
        return $this->message['video_note'] ?? null;
    }

    public function getVoice(): ?array
    {
        return $this->message['voice'] ?? null;
    }

    public function getSticker(): ?array
    {
        return $this->message['sticker'] ?? null;
    }

    public function getLocation(): ?Location
    {
        if (!isset($this->message['location'])) {
            return null;
        }
        return new Location($this->message['location']);
    }

    public function getVenue(): ?Venue
    {
        if (!isset($this->message['venue'])) {
            return null;
        }
        return new Venue($this->message['venue']);
    }

    public function getContact(): ?Contact
    {
        if (!isset($this->message['contact'])) {
            return null;
        }
        return new Contact($this->message['contact']);
    }

    public function getNewChatMembers(): array
    {
        return $this->message['new_chat_members'] ?? [];
    }

    public function getLeftChatMember(): ?User
    {
        if (!isset($this->message['left_chat_member'])) {
            return null;
        }
        return new User($this->message['left_chat_member']);
    }

    public function getDate(): int
    {
        return $this->message['date'] ?? 0;
    }

    public function getChatId(): int
    {
        return $this->message['chat']['id'] ?? 0;
    }

    public function getUserId(): int
    {
        return $this->message['from']['id'] ?? 0;
    }

    public function getMessageThreadId(): ?int
    {
        return $this->message['message_thread_id'] ?? null;
    }

    public function isCommand(): bool
    {
        if ($text = $this->getText()) {
            return str_starts_with($text, '/');
        }
        return false;
    }

    public function getCommand(): ?string
    {
        if ($text = $this->getText()) {
            if (str_starts_with($text, '/')) {
                $parts = explode(' ', $text);
                return trim($parts[0], '@');
            }
        }
        return null;
    }

    public function getArgs(): array
    {
        if ($text = $this->getText()) {
            if (str_contains($text, ' ')) {
                $parts = explode(' ', $text, 2);
                return array_filter(explode(' ', trim($parts[1] ?? '')));
            }
        }
        return [];
    }

    public function hasMention(): bool
    {
        if ($entities = $this->getEntities()) {
            foreach ($entities as $entity) {
                if ($entity['type'] === 'mention') {
                    return true;
                }
            }
        }
        return false;
    }

    public function getRaw(): array
    {
        return $this->message;
    }
}

class Chat
{
    private array $chat;

    public function __construct(array $chat)
    {
        $this->chat = $chat;
    }

    public function getId(): int
    {
        return $this->chat['id'] ?? 0;
    }

    public function getType(): string
    {
        return $this->chat['type'] ?? 'private';
    }

    public function getTitle(): ?string
    {
        return $this->chat['title'] ?? null;
    }

    public function getUsername(): ?string
    {
        return $this->chat['username'] ?? null;
    }

    public function getFirstName(): ?string
    {
        return $this->chat['first_name'] ?? null;
    }

    public function getLastName(): ?string
    {
        return $this->chat['last_name'] ?? null;
    }

    public function getRaw(): array
    {
        return $this->chat;
    }
}

class User
{
    private array $user;

    public function __construct(array $user)
    {
        $this->user = $user;
    }

    public function getId(): int
    {
        return $this->user['id'] ?? 0;
    }

    public function getIsBot(): bool
    {
        return $this->user['is_bot'] ?? false;
    }

    public function getFirstName(): string
    {
        return $this->user['first_name'] ?? '';
    }

    public function getLastName(): ?string
    {
        return $this->user['last_name'] ?? null;
    }

    public function getUsername(): ?string
    {
        return $this->user['username'] ?? null;
    }

    public function getLanguageCode(): ?string
    {
        return $this->user['language_code'] ?? null;
    }

    public function getRaw(): array
    {
        return $this->user;
    }
}

class Location
{
    private array $location;

    public function __construct(array $location)
    {
        $this->location = $location;
    }

    public function getLongitude(): float
    {
        return $this->location['longitude'] ?? 0.0;
    }

    public function getLatitude(): float
    {
        return $this->location['latitude'] ?? 0.0;
    }

    public function getRaw(): array
    {
        return $this->location;
    }
}

class Venue
{
    private array $venue;

    public function __construct(array $venue)
    {
        $this->venue = $venue;
    }

    public function getLocation(): ?Location
    {
        if (!isset($this->venue['location'])) {
            return null;
        }
        return new Location($this->venue['location']);
    }

    public function getTitle(): string
    {
        return $this->venue['title'] ?? '';
    }

    public function getAddress(): string
    {
        return $this->venue['address'] ?? '';
    }

    public function getFoursquareId(): ?string
    {
        return $this->venue['foursquare_id'] ?? null;
    }

    public function getFoursquareType(): ?string
    {
        return $this->venue['foursquare_type'] ?? null;
    }

    public function getRaw(): array
    {
        return $this->venue;
    }
}

class Contact
{
    private array $contact;

    public function __construct(array $contact)
    {
        $this->contact = $contact;
    }

    public function getPhoneNumber(): string
    {
        return $this->contact['phone_number'] ?? '';
    }

    public function getFirstName(): string
    {
        return $this->contact['first_name'] ?? '';
    }

    public function getLastName(): ?string
    {
        return $this->contact['last_name'] ?? null;
    }

    public function getUserId(): ?int
    {
        return $this->contact['user_id'] ?? null;
    }

    public function getVcard(): ?string
    {
        return $this->contact['vcard'] ?? null;
    }

    public function getRaw(): array
    {
        return $this->contact;
    }
}

class CallbackQuery
{
    private array $callback;

    public function __construct(array $callback)
    {
        $this->callback = $callback;
    }

    public function getId(): string
    {
        return $this->callback['id'] ?? '';
    }

    public function getFrom(): ?User
    {
        if (!isset($this->callback['from'])) {
            return null;
        }
        return new User($this->callback['from']);
    }

    public function getMessage(): ?Message
    {
        if (!isset($this->callback['message'])) {
            return null;
        }
        return new Message($this->callback['message']);
    }

    public function getInlineMessageId(): ?string
    {
        return $this->callback['inline_message_id'] ?? null;
    }

    public function getData(): ?string
    {
        return $this->callback['data'] ?? null;
    }

    public function getGameShortName(): ?string
    {
        return $this->callback['game_short_name'] ?? null;
    }

    public function getChatInstance(): string
    {
        return $this->callback['chat_instance'] ?? '';
    }

    public function getRaw(): array
    {
        return $this->callback;
    }
}

class InlineQuery
{
    private array $query;

    public function __construct(array $query)
    {
        $this->query = $query;
    }

    public function getId(): string
    {
        return $this->query['id'] ?? '';
    }

    public function getFrom(): ?User
    {
        if (!isset($this->query['from'])) {
            return null;
        }
        return new User($this->query['from']);
    }

    public function getQuery(): string
    {
        return $this->query['query'] ?? '';
    }

    public function getOffset(): string
    {
        return $this->query['offset'] ?? '';
    }

    public function getLocation(): ?Location
    {
        if (!isset($this->query['location'])) {
            return null;
        }
        return new Location($this->query['location']);
    }

    public function getRaw(): array
    {
        return $this->query;
    }
}

class ShippingQuery
{
    private array $query;

    public function __construct(array $query)
    {
        $this->query = $query;
    }

    public function getId(): string
    {
        return $this->query['id'] ?? '';
    }

    public function getFrom(): ?User
    {
        if (!isset($this->query['from'])) {
            return null;
        }
        return new User($this->query['from']);
    }

    public function getInvoicePayload(): string
    {
        return $this->query['invoice_payload'] ?? '';
    }

    public function getShippingAddress(): array
    {
        return $this->query['shipping_address'] ?? [];
    }

    public function getRaw(): array
    {
        return $this->query;
    }
}

class PreCheckoutQuery
{
    private array $query;

    public function __construct(array $query)
    {
        $this->query = $query;
    }

    public function getId(): string
    {
        return $this->query['id'] ?? '';
    }

    public function getFrom(): ?User
    {
        if (!isset($this->query['from'])) {
            return null;
        }
        return new User($this->query['from']);
    }

    public function getCurrency(): string
    {
        return $this->query['currency'] ?? '';
    }

    public function getTotalAmount(): int
    {
        return $this->query['total_amount'] ?? 0;
    }

    public function getInvoicePayload(): string
    {
        return $this->query['invoice_payload'] ?? '';
    }

    public function getRaw(): array
    {
        return $this->query;
    }
}

class Poll
{
    private array $poll;

    public function __construct(array $poll)
    {
        $this->poll = $poll;
    }

    public function getId(): string
    {
        return $this->poll['id'] ?? '';
    }

    public function getQuestion(): string
    {
        return $this->poll['question'] ?? '';
    }

    public function getOptions(): array
    {
        return $this->poll['options'] ?? [];
    }

    public function getTotalVoterCount(): int
    {
        return $this->poll['total_voter_count'] ?? 0;
    }

    public function isClosed(): bool
    {
        return $this->poll['is_closed'] ?? false;
    }

    public function isAnonymous(): bool
    {
        return $this->poll['is_anonymous'] ?? true;
    }

    public function getType(): string
    {
        return $this->poll['type'] ?? 'regular';
    }

    public function allowsMultipleAnswers(): bool
    {
        return $this->poll['allows_multiple_answers'] ?? false;
    }

    public function getCorrectOptionId(): ?int
    {
        return $this->poll['correct_option_id'] ?? null;
    }

    public function getRaw(): array
    {
        return $this->poll;
    }
}

class PollAnswer
{
    private array $answer;

    public function __construct(array $answer)
    {
        $this->answer = $answer;
    }

    public function getPollId(): string
    {
        return $this->answer['poll_id'] ?? '';
    }

    public function getUser(): ?User
    {
        if (!isset($this->answer['user'])) {
            return null;
        }
        return new User($this->answer['user']);
    }

    public function getOptionIds(): array
    {
        return $this->answer['option_ids'] ?? [];
    }

    public function getRaw(): array
    {
        return $this->answer;
    }
}

class ChatMemberUpdated
{
    private array $member;

    public function __construct(array $member)
    {
        $this->member = $member;
    }

    public function getChat(): ?Chat
    {
        if (!isset($this->member['chat'])) {
            return null;
        }
        return new Chat($this->member['chat']);
    }

    public function getFrom(): ?User
    {
        if (!isset($this->member['from'])) {
            return null;
        }
        return new User($this->member['from']);
    }

    public function getDate(): int
    {
        return $this->member['date'] ?? 0;
    }

    public function getOldChatMember(): ?ChatMember
    {
        if (!isset($this->member['old_chat_member'])) {
            return null;
        }
        return new ChatMember($this->member['old_chat_member']);
    }

    public function getNewChatMember(): ?ChatMember
    {
        if (!isset($this->member['new_chat_member'])) {
            return null;
        }
        return new ChatMember($this->member['new_chat_member']);
    }

    public function getInviteLink(): ?ChatInviteLink
    {
        if (!isset($this->member['invite_link'])) {
            return null;
        }
        return new ChatInviteLink($this->member['invite_link']);
    }

    public function getRaw(): array
    {
        return $this->member;
    }
}

class ChatMember
{
    private array $member;

    public function __construct(array $member)
    {
        $this->member = $member;
    }

    public function getUser(): ?User
    {
        if (!isset($this->member['user'])) {
            return null;
        }
        return new User($this->member['user']);
    }

    public function getStatus(): string
    {
        return $this->member['status'] ?? '';
    }

    public function getRaw(): array
    {
        return $this->member;
    }
}

class ChatInviteLink
{
    private array $link;

    public function __construct(array $link)
    {
        $this->link = $link;
    }

    public function getInviteLink(): string
    {
        return $this->link['invite_link'] ?? '';
    }

    public function getCreator(): ?User
    {
        if (!isset($this->link['creator'])) {
            return null;
        }
        return new User($this->link['creator']);
    }

    public function getCreatesJoinRequest(): bool
    {
        return $this->link['creates_join_request'] ?? false;
    }

    public function getIsPrimary(): bool
    {
        return $this->link['is_primary'] ?? false;
    }

    public function getIsRevoked(): bool
    {
        return $this->link['is_revoked'] ?? false;
    }

    public function getName(): ?string
    {
        return $this->link['name'] ?? null;
    }

    public function getExpireDate(): ?int
    {
        return $this->link['expire_date'] ?? null;
    }

    public function getMemberLimit(): ?int
    {
        return $this->link['member_limit'] ?? null;
    }

    public function getRaw(): array
    {
        return $this->link;
    }
}

class ChatJoinRequest
{
    private array $request;

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    public function getChat(): ?Chat
    {
        if (!isset($this->request['chat'])) {
            return null;
        }
        return new Chat($this->request['chat']);
    }

    public function getFrom(): ?User
    {
        if (!isset($this->request['from'])) {
            return null;
        }
        return new User($this->request['from']);
    }

    public function getDate(): int
    {
        return $this->request['date'] ?? 0;
    }

    public function getBio(): ?string
    {
        return $this->request['bio'] ?? null;
    }

    public function getInviteLink(): ?ChatInviteLink
    {
        if (!isset($this->request['invite_link'])) {
            return null;
        }
        return new ChatInviteLink($this->request['invite_link']);
    }

    public function getRaw(): array
    {
        return $this->request;
    }
}