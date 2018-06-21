<?php

namespace Unite\UnisysApi\Repositories;

use Illuminate\Notifications\DatabaseNotification;

class DatabaseNotificationRepository extends Repository
{
    protected $modelClass = DatabaseNotification::class;

    public function markAsRead(DatabaseNotification $databaseNotification)
    {
        $databaseNotification->markAsRead();
    }

    public function markAsUnRead(DatabaseNotification $databaseNotification)
    {
        if (!is_null($databaseNotification->read_at)) {
            $databaseNotification->forceFill(['read_at' => null])->save();
        }
    }
}