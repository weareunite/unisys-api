<?php

namespace Unite\UnisysApi\Http\Controllers;

use Illuminate\Notifications\DatabaseNotification;

/**
 * @resource User Database Notification
 *
 * Users database Notifications handler
 */
class UserNotificationController extends Controller
{
    protected $model;

    public function __construct(DatabaseNotification $model)
    {
        $this->model = $model;
    }

    /**
     * Mark as read
     *
     * @param $uid
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead($uid)
    {
        if(!$object = $this->model->find($uid)) {
            abort(404);
        }

        $this->authorize('update', $object);

        $object->markAsRead();

        \Cache::tags('response')->flush();

        return $this->successJsonResponse();
    }

    /**
     * Mark as unread
     *
     * @param $uid
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsUnread($uid)
    {
        if(!$object = $this->model->find($uid)) {
            abort(404);
        }

        $this->authorize('update', $object);

        if (!is_null($object->read_at)) {
            $object->forceFill(['read_at' => null])->save();
        }

        \Cache::tags('response')->flush();

        return $this->successJsonResponse();
    }

}
