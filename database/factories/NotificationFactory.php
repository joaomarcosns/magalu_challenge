<?php

namespace Database\Factories;

use App\Enums\NotificationChannelEnum;
use App\Enums\NotificationStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'send_at' => $this->faker->dateTime(),
            'destination' => $this->faker->email(),
            'message' => $this->faker->text(50),
            'channel' => $this->faker->randomElement([
                NotificationChannelEnum::EMAIL,
                NotificationChannelEnum::PUSH,
                NotificationChannelEnum::SMS,
                NotificationChannelEnum::WHATSAPP
            ]),
            'status' => $this->faker->randomElement([
                NotificationStatusEnum::PENDING,
                NotificationStatusEnum::SUCCESS,
                NotificationStatusEnum::ERROR,
                NotificationStatusEnum::CANCELED
            ])
        ];
    }
}
