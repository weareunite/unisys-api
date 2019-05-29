<?php

namespace Unite\UnisysApi\Modules\Users\Services;

use Illuminate\Contracts\Auth\Factory as Auth;
use Unite\UnisysApi\Exceptions\MissingInstanceException;
use Unite\UnisysApi\Modules\Users\User;
use Unite\UnisysApi\Services\Service;

class InstanceService extends Service
{
    /** @var User */
    protected $user;

    protected $instanceId = null;

    public function __construct(Auth $auth)
    {
        $this->user = $auth->user();
    }

    public function getInstanceId()
    {
        return $this->instanceId;
    }

    public function setInstanceId(int $instance_id)
    {
        $this->instanceId = $instance_id;

        return $this;
    }

    public function selectInstanceId()
    {
        if($this->instanceId) {
            return $this->instanceId;
        }

        if (!$this->user->selectedInstanceId()) {
            if ($this->user->instances()->count() < 1) {
                throw new MissingInstanceException;
            }

            $instance_id = $this->user->instances()->first()->id;

            $this->user->selected_instance_id = $instance_id;
            $this->user->save();
        } else {
            $instance_id = $this->user->selectedInstanceId();
        }

        $this->instanceId = $instance_id;

        return $this;
    }
}