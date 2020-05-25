<?php

namespace Unite\UnisysApi\Modules\Users\Console\Commands;

use Illuminate\Console\Command;
use Unite\UnisysApi\Modules\Company\CompanyService;
use Unite\UnisysApi\Modules\Contacts\CountryRepository;
use Unite\UnisysApi\Modules\Contacts\Models\Country;
use Unite\UnisysApi\Modules\Permissions\Role;
use Unite\UnisysApi\Modules\Users\User;

class SetFirstUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unisys-api:set-first-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set first user and his required relations like roles and company profile';

    /** @var  User */
    protected $user;

    /** @var  Role */
    protected $adminRole;

    /** @var  CountryRepository */
    protected $countryRepository;

    /** @var  CompanyService */
    protected $companyService;

    /** @var  string */
    protected $plainPassword;


    public function handle(CountryRepository $countryRepository, CompanyService $companyService)
    {
        $this->countryRepository = $countryRepository;
        $this->companyService = $companyService;

        if (User::count() > 0) {
            $this->info('Table of users is not empty ...');

            return;
        }

        $this->createUser();

        $this->createDefaultRoles();

        $this->attachUserToRoles();

        $this->setCompanyProfile();

        $this->getOutput()->success('DONE! You can now log in to your API.');

        $this->getOutput()->note('REMEMBER Login credentials');
        $this->table([ 'Username', 'Password' ], [ [ $this->user->username, $this->plainPassword ] ]);
    }

    private function createUser()
    {
        $this->getOutput()->title('Create User');

        $data['name'] = $this->validate(function () {
            return $this->ask('Name *');
        }, 'required|string|max:100');

        $data['surname'] = $this->validate(function () {
            return $this->ask('Surname *');
        }, 'required|string|max:100');

        $data['email'] = $this->validate(function () {
            return $this->ask('Email *');
        }, 'required|email');

        $data['username'] = $this->validate(function () {
            return $this->ask('Username for login *');
        }, 'required|string|max:100');

        $this->plainPassword = $data['password'] = $this->validate(function () {
            return $this->ask('Password for login *');
        }, 'required|string|max:100');

        $data['active'] = 1;

        $this->user = User::create($data);

        $this->getOutput()->success('User ' . $this->user->getFullName() . ' was created');
    }

    private function createDefaultRoles()
    {
        $this->adminRole = Role::create([
            'name'       => 'admin',
            'guard_name' => 'api',
        ]);

        Role::create([
            'name'       => 'user',
            'guard_name' => 'api',
        ]);

        $this->info('Roles admin and user was created');
    }

    private function attachUserToRoles()
    {
        $this->user->assignRole($this->adminRole);

        $this->info('User ' . $this->user->getFullName() . ' was attached to role Admin');
    }

    private function setCompanyProfile()
    {
        $this->getOutput()->title('Set Company information');

        $contactData['name'] = $this->validate(function () {
            return $this->ask('Contact name *');
        }, 'required|string|max:40');

        $contactData['company'] = $this->validate(function () {
            return $this->ask('Company name *');
        }, 'required|string|max:40');

        $contactData['street'] = $this->validate(function () {
            return $this->ask('Street');
        }, 'nullable|string|max:40');

        $contactData['zip'] = $this->validate(function () {
            return $this->ask('Zip');
        }, 'nullable|string|max:10');

        $contactData['city'] = $this->validate(function () {
            return $this->ask('City');
        }, 'nullable|string|max:20');

        $countryName = $this->validate(function () {
            return $this->choice('Country', $this->countryRepository->getListForSelect(), Country::DEFAULT_COUNTRY_ID);
        }, 'string');

        if ($countryName && $country = $this->countryRepository->getByName($countryName)) {
            $contactData['country_id'] = $country->id;
        }

        $contactData['reg_no'] = $this->validate(function () {
            return $this->ask('Registration number');
        }, 'nullable|string|max:20');

        $contactData['tax_no'] = $this->validate(function () {
            return $this->ask('Tax number');
        }, 'nullable|string|max:20');

        $contactData['vat_no'] = $this->validate(function () {
            return $this->ask('Vat number');
        }, 'nullable|string|max:20');

        $contactData['email'] = $this->validate(function () {
            return $this->ask('Email *');
        }, 'required|email');

        $contactData['telephone'] = $this->validate(function () {
            return $this->ask('Phone number');
        }, 'nullable|string|max:20');

        $this->companyService->create(['name' => $contactData['name'], 'contact_profile' => $contactData]);

        $this->getOutput()->success('Company profile is set');
    }

    private function validate(\Closure $closure, string $validates)
    {
        do {
            $value = $closure();

            $validator = \Validator::make([ 'input' => $value ], [ 'input' => $validates ]);

            if ($validator->fails()) {
                $this->error($validator->errors()->first());
            }
        } while ($validator->fails());

        return $value;
    }
}