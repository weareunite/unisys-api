<?php

namespace Unite\UnisysApi\Modules\Contacts\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasContacts
{
    public function contacts(): MorphMany
    {
        return $this->morphMany(Contact::class, 'subject');
    }

    /**
     * @param array $data
     * @return \Unite\UnisysApi\Modules\Contacts\Models\Contact
     */
    public function addContact(array $data = [])
    {
        return $this->contacts()->create($data);
    }

    public function removeContact($id)
    {
        $this->contacts()->where('id', $id)->delete();
    }

    public function existContacts()
    {
        return $this->contacts()->exists();
    }

    public function contactsCount()
    {
        return $this->contacts()->count();
    }

    public function getLatestContacts(int $limit = 20)
    {
        //todo: move it to repository for caching
        return $this->contacts()->orderBy('created_at', 'desc')->limit($limit)->get();
    }
}
