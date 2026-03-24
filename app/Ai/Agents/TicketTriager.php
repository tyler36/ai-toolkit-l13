<?php

namespace App\Ai\Agents;

use App\Enums\Department;
use App\Enums\Priority;
use App\Enums\TicketSentiment;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Attributes\MaxTokens;
use Laravel\Ai\Attributes\Model;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Attributes\UseCheapestModel;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

#[Provider(Lab::Ollama)]
#[UseCheapestModel()]
#[MaxTokens(1200)]
#[Model('llama3.1:8b')]
class TicketTriager implements Agent, Conversational, HasStructuredOutput, HasTools
{
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        $departmentList = implode(", ", array_map(fn($d) => $d->value, Department::cases()));
        $priorityList = implode(", ", array_map(fn($p) => $p->value, Priority::cases()));
        $sentimentList = implode(", ", array_map(fn($p) => $p->value, TicketSentiment::cases()));

            return <<<PROMPT
You are a support ticket triage assistant. Analyze the ticket and return structured data only.

RULES
    - Always include every key in the schema.
    - do NOT include extra keys.
    - 'department' value must be from: ["$departmentList"]
    - 'priority' value must be from: ["$priorityList"]
    - 'sentiment' value must be from: ["$sentimentList"]
PROMPT;
    }

    /**
     * Get the list of messages comprising the conversation so far.
     *
     * @return Message[]
     */
    public function messages(): iterable
    {
        return [];
    }

    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [];
    }

    /**
     * Get the agent's structured output schema definition.
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'priority' => $schema->string()
                ->required(),
            'department' => $schema->string()->required(),
            'summary' => $schema->string()->required(),
            'sentiment' => $schema->string()->required(),
            'tags' => $schema->array()->items($schema->string())
                ->min(0)->max(3)
                ->required(),
        ];
    }

    /**
     * Get provider-specific generation options.
     */
    public function providerOptions(Lab|string $provider): array
    {
        return match ($provider) {
            Lab::Ollama => [
                'thinking' => ['false'],
            ],
        };
    }
}
