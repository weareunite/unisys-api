<?php

namespace Unite\UnisysApi\Modules\Users\Services;

use Unite\UnisysApi\Exceptions\MissingInstanceException;
use Unite\UnisysApi\Modules\Users\User;
use Unite\UnisysApi\Services\Service;
use DB;
use DomainException;

class InstanceService extends Service
{
    /** @var User */
    protected $user;

    protected $instanceId = null;

    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
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
        if ($this->instanceId) {
            return $this;
        }

        if ($this->user) {
            return $this->selectInstanceByUser();
        }

        return $this->selectSingleDefaultInstance();
    }

    protected function selectInstanceByUser()
    {
        if (!$instance_id = $this->user->selectedInstanceId()) {
            if ($this->user->instances()->count() < 1) {
                throw new MissingInstanceException;
            }

            $instance_id = $this->user->instances()->first()->id;

            $this->user->selected_instance_id = $instance_id;
            $this->user->save();
        }

        $this->instanceId = $instance_id;

        return $this;
    }

    protected function getFirstInstanceId()
    {
        return DB::table('instances')->select([ 'id' ])->value('id');
    }

    protected function selectSingleDefaultInstance()
    {
        if (DB::table('instances')->count() > 1) {
            throw new DomainException('Domain has defined more than one instance. You must define instance');
        }

        $this->instanceId = $this->getFirstInstanceId();

        return $this;
    }
}