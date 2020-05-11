<?php

namespace Unite\UnisysApi\Modules\Contacts\Contracts;

interface HasContactProfile
{
    public function contact_profile();

    public function addContactProfile(array $data = []);

    public function updateContactProfile(array $data = []);

    public function removeContactProfile($id);

    public function existContactProfile();

    public function attachOrUpdateContactProfile(array $data);
}
