<?php

namespace Unite\UnisysApi\Modules\Contacts\Models;

use Illuminate\Database\Eloquent\Builder;

trait HasOneContactProfile
{
    protected $contact_type = 'contact-profile';

    /**
     * @return Builder
     */
    public function contact_profile()
    {
        return $this
            ->morphOne(Contact::class, 'subject')
            ->where('type', '=', $this->contact_type);
    }

    public function addContactProfile(array $data = [])
    {
        if ($this->existContactProfile()) {
            throw new \LogicException('Contact profile already exists for given entity');
        }

        $data = array_merge($data, [ 'type' => $this->contact_type ]);

        return $this
            ->contact_profile()
            ->create($data);
    }

    public function updateContactProfile(array $data = [])
    {
        return $this
            ->contact_profile()
            ->first()
            ->update($data);
    }

    public function removeContactProfile($id)
    {
        return $this
            ->contact_profile()
            ->where('id', $id)
            ->delete();
    }

    public function existContactProfile()
    {
        return $this
            ->contact_profile()
            ->exists();
    }

    public function attachOrUpdateContactProfile(array $data)
    {
        if($this->existContactProfile()) {
            $this->updateContactProfile($data);
        } else {
            $this->addContactProfile($data);
        }
    }
}
