<?php

namespace Unite\UnisysApi\Modules\Contacts\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasContacts
{
    public function contacts(): MorphMany;

    public function addContact(array $data = []);

    public function removeContact($id);

    public function existContacts();

    public function contactsCount();

    public function getLatestContacts(int $limit = 20);
}
