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
        // Defina o canal aleatoriamente primeiro
        $channel = $this->faker->randomElement([
            NotificationChannelEnum::EMAIL,
            NotificationChannelEnum::PUSH,
            NotificationChannelEnum::SMS,
            NotificationChannelEnum::WHATSAPP
        ]);

        // Defina o destino com base no canal selecionado
        $destination = match ($channel) {
            NotificationChannelEnum::EMAIL => $this->faker->email(),
            NotificationChannelEnum::SMS, NotificationChannelEnum::WHATSAPP => $this->faker->phoneNumber(),
            NotificationChannelEnum::PUSH => $this->faker->uuid(), // Gerar um token para PUSH
        };

        return [
            'send_at' => $this->faker->dateTimeBetween('now', '+1 month'),
            'destination' => $destination,
            'message' => $this->faker->text(50),
            'channel' => $channel,
            'status' => $this->faker->randomElement([
                NotificationStatusEnum::PENDING,
                NotificationStatusEnum::SUCCESS,
                NotificationStatusEnum::ERROR,
                NotificationStatusEnum::CANCELED
            ])
        ];
    }
}
