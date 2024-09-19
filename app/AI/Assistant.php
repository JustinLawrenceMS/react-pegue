<?php

namespace App\AI;

use Illuminate\Support\Facades\Storage;
use OpenAI\Laravel\Facades\OpenAI;

class Assistant
{
    private string $systemMessage = '';
    private string $csl_path = '';
    protected array $messages = [];

    public function systemMessage(string $message = null): static
    {
        $this->systemMessage = config('openai.prompt.prompt_text');
        $this->csl_path = Storage::disk('local')->path(config('openai.prompt.csl_path'));

        \Log::info($this->systemMessage . $this->csl_path);

        if (!is_null($message)) {
            $this->systemMessage = $message;
        }

        $this->messages[] = [
            'role' => 'system',
            'content' => $this->systemMessage
        ];

        $this->setMessages();

        return $this;
    }

    public function send(string $message): ?string
    {
        $this->messages[] = [
            'role' => 'user',
            'content' => $message
        ];

        $response = OpenAI::chat()->create([
            "model"    => "gpt-3.5-turbo",
            'max_tokens' => 4096,
            "messages" => $this->messages
        ])->choices[0]->message->content;

        if ($response) {
            $this->messages[] = [
                'role' => 'assistant',
                'content' => $response,
            ];
        }

        return $response;
    }

    public function reply(string $message): ?string
    {
        $this->setMessages();

        \Log::info("this->messages, AI assistant, line 62", $this->messages);
        unset($this->messages);
        return $this->send($message);
    }

    public function messages()
    {
        return $this->messages;
    }

    public function setMessages()
    {
        if (!session('messages')) {
            session(['messages' => json_encode($this->messages, JSON_PRETTY_PRINT)]);
        } else {
            $sess = json_decode(session('messages'), true);
            $merge = array_merge($sess, $this->messages);
            session(['messages' => json_encode($merge, JSON_PRETTY_PRINT)]);
            $this->messages = json_decode(session('messages'), true);
        }
    }
}
