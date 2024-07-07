<?php

namespace App\Http\Controllers;

use App\Enums\NotificationChannelEnum;
use App\Enums\NotificationStatusEnum;
use App\Http\Requests\NotificationRequest;
use App\Http\Requests\NotificationUpdateRequest;
use App\Models\Notification;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotificationsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(NotificationRequest $request)
    {
        $data = $request->validated();

        $channel = NotificationChannelEnum::getValue($data['channel']);

        Notification::query()->create([
            'send_at' => $data['send_at'],
            'destination' => $data['destination'],
            'message' => $data['message'],
            'channel' => $channel->value,
            'status' => NotificationStatusEnum::PENDING
        ]);

        return response()->json([
            'message' => "Notificação criada com sucesso"
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        return response()->json([
            'data' => $notification
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NotificationUpdateRequest $request, Notification $notification)
    {
        if ($notification->status === NotificationStatusEnum::CANCELED) {
            return response()->json([
                'error' => "Não é possível atualizar uma notificação cancelada"
            ], Response::HTTP_BAD_REQUEST);
        }

        $data = $request->validated();

        $channel = NotificationChannelEnum::getValue($data['channel']);

        $notification->update([
            'send_at' => $data['send_at'],
            'destination' => $data['destination'],
            'message' => $data['message'],
            'channel' => $channel->value,
            'status' => NotificationStatusEnum::PENDING
        ]);

        return response()->json([
            'message' => "Notificação atualizada com sucesso"
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        $notification->status = NotificationStatusEnum::CANCELED;
        $notification->save();
        return response()->json([
            'message' => "Notificação deletada com sucesso"
        ], Response::HTTP_OK);
    }
}
