<?php

use App\Models\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\NotificationChannelEnum;
use App\Enums\NotificationStatusEnum;
use Faker\Factory as Faker;

uses(RefreshDatabase::class);

it('creates a notification successfully', function () {
    $URL = '/api/v1/notifications';
    $faker = Faker::create();
    $data = [
        'send_at' => now()->addDay()->toDateTimeString(),
        'destination' =>  $faker->email(),
        'message' => 'Test Message',
        'channel' => NotificationChannelEnum::EMAIL->name
    ];

    $response = $this->postJson($URL, $data);

    $response->assertStatus(Response::HTTP_CREATED)
        ->assertJson(
            fn (AssertableJson $json) =>
            $json->where('message', 'Notificação criada com sucesso')
                ->etc()
        );

    $this->assertDatabaseHas('notifications', [
        'send_at' => $data['send_at'],
        'destination' => $data['destination'],
        'message' => $data['message'],
        'channel' => NotificationChannelEnum::EMAIL->value,
        'status' => NotificationStatusEnum::PENDING->value,
    ]);
});

it('creates a notification when channel is email', function () {
    $URL = '/api/v1/notifications';
    $faker = Faker::create();
    $data = [
        'send_at' => now()->addDay()->toDateTimeString(),
        'destination' =>  $faker->email(),
        'message' => 'Test Message',
        'channel' => NotificationChannelEnum::EMAIL->name
    ];

    $response = $this->postJson($URL, $data);

    $response->assertStatus(Response::HTTP_CREATED)
        ->assertJson(
            fn (AssertableJson $json) =>
            $json->where('message', 'Notificação criada com sucesso')
                ->etc()
        );

    $this->assertDatabaseHas('notifications', [
        'send_at' => $data['send_at'],
        'destination' => $data['destination'],
        'message' => $data['message'],
        'channel' => NotificationChannelEnum::EMAIL->value,
        'status' => NotificationStatusEnum::PENDING->value,
    ]);
});

it('fails to create a notification when channel is email and destination is not a valid email', function () {
    $URL = '/api/v1/notifications';

    $data = [
        'send_at' => now()->addDay()->toDateTimeString(),
        'destination' => 'invalid-email', // Invalid email address
        'message' => 'Test Message',
        'channel' => NotificationChannelEnum::EMAIL->name,
    ];

    $response = $this->postJson($URL, $data);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJson(
            fn (AssertableJson $json) =>
            $json->has('errors.destination')
                ->where('errors.destination.0', 'The destination field must be a valid email address.')
                ->etc()
        );

    $this->assertDatabaseMissing('notifications', [
        'destination' => 'invalid-email',
    ]);
});

it('fails to create a notification when channel is SMS and destination is not a valid phone number', function () {
    $URL = '/api/v1/notifications';

    $data = [
        'send_at' => now()->addDay()->toDateTimeString(),
        'destination' => 'invalid-phone-number', // Invalid phone number
        'message' => 'Test Message',
        'channel' => NotificationChannelEnum::SMS->name,
    ];

    $response = $this->postJson($URL, $data);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJson(
            fn (AssertableJson $json) =>
            $json->has('errors.destination')
                ->where('errors.destination.0', 'The destination field format is invalid.')
                ->etc()
        );
});

it('creates a notification SMS channel successfully', function () {
    $URL = '/api/v1/notifications';
    $faker = Faker::create();

    $data = [
        'send_at' => now()->addDay()->toDateTimeString(),
        'destination' => $faker->e164PhoneNumber,
        'message' => 'Test Message',
        'channel' => NotificationChannelEnum::SMS->name
    ];

    $response = $this->postJson($URL, $data);

    $response->assertStatus(Response::HTTP_CREATED)
        ->assertJson(
            fn (AssertableJson $json) =>
            $json->where('message', 'Notificação criada com sucesso')
                ->etc()
        );

    $this->assertDatabaseHas('notifications', [
        'send_at' => $data['send_at'],
        'destination' => $data['destination'],
        'message' => $data['message'],
        'channel' => NotificationChannelEnum::SMS->value,
        'status' => NotificationStatusEnum::PENDING->value,
    ]);
});

it('fails to create a notification when channel is WHATSAPP and destination is not a valid phone number', function () {
    $URL = '/api/v1/notifications';

    $data = [
        'send_at' => now()->addDay()->toDateTimeString(),
        'destination' => 'invalid-phone-number', // Invalid phone number
        'message' => 'Test Message',
        'channel' => NotificationChannelEnum::WHATSAPP->name,
    ];

    $response = $this->postJson($URL, $data);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJson(
            fn (AssertableJson $json) =>
            $json->has('errors.destination')
                ->where('errors.destination.0', 'The destination field format is invalid.')
                ->etc()
        );
});

it('creates a notification WHATSAPP channel successfully', function () {
    $URL = '/api/v1/notifications';
    $faker = Faker::create();

    $data = [
        'send_at' => now()->addDay()->toDateTimeString(),
        'destination' => $faker->e164PhoneNumber,
        'message' => 'Test Message',
        'channel' => NotificationChannelEnum::WHATSAPP->name
    ];

    $response = $this->postJson($URL, $data);

    $response->assertStatus(Response::HTTP_CREATED)
        ->assertJson(
            fn (AssertableJson $json) =>
            $json->where('message', 'Notificação criada com sucesso')
                ->etc()
        );

    $this->assertDatabaseHas('notifications', [
        'send_at' => $data['send_at'],
        'destination' => $data['destination'],
        'message' => $data['message'],
        'channel' => NotificationChannelEnum::WHATSAPP->value,
        'status' => NotificationStatusEnum::PENDING->value,
    ]);
});

it('fails to create a notification with invalid data', function () {
    $URL = '/api/v1/notifications';

    $data = [
        'send_at' => 'invalid-date',
        'destination' => 'not-an-email',
        'message' => 'Test Message',
        'channel' => 'invalid-channel',
    ];

    $response = $this->postJson($URL, $data);


    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJson(
            fn (AssertableJson $json) =>
            $json->has('errors')
                ->etc()
        );

    $this->assertDatabaseMissing('notifications', [
        'destination' => 'not-an-email',
    ]);
});
