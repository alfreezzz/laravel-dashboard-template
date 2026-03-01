<?php

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Events\NotificationCreated;

uses(Tests\TestCase::class);
uses(RefreshDatabase::class);


it('broadcasts on the correct private channel', function () {
    $user = \App\Models\User::factory()->create();

    $notification = \App\Models\Notification::factory()->create(['user_id' => $user->id]);

    $event = new NotificationCreated($notification);
    $channels = $event->broadcastOn();

    expect($channels)->toHaveCount(1);
    expect($channels[0]->name)->toBe('private-user.' . $user->id);
});
