<?php

namespace Database\Factories;

use App\Enums\Department;
use App\Enums\Priority;
use App\Enums\TicketSentiment;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $state = $this->faker->randomElement(TicketStatus::cases());

        return [
            'title' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(),
            'state' => $state,
            'user_id' => User::factory(), // Assuming users 1-10 exist
            'priority' => $this->faker->randomElement(Priority::cases()),
            'sentiment' => $this->faker->randomElement(TicketSentiment::cases()),
            'department' => $this->faker->randomElement(Department::cases()),
            'ai_tags' => $this->faker->randomElements(['bug', 'feature', 'ui', 'backend', 'urgent', 'low-priority'], 2),
            'closed_at' => $state === TicketStatus::CLOSED ? $this->faker->dateTime() : null,
        ];
    }
}
