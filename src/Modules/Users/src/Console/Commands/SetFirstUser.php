<?php

namespace Unite\UnisysApi\Modules\Users\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Routing\Router;
use Unite\UnisysApi\Modules\Contacts\CountryRepository;
use Unite\UnisysApi\Modules\Contacts\Models\Country;
use Unite\UnisysApi\Modules\Permissions\Role;
use Unite\UnisysApi\Modules\Settings\Services\SettingService;
use Unite\UnisysApi\Modules\Users\Instance;
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
    protected $description = 'Set first user and his required relations like instance, roles and company profile';

    /** @var  User */
    protected $user;

    /** @var  Instance */
    protected $instance;

    /** @var  Role */
    protected $adminRole;

    /** @var  CountryRepository */
    protected $countryRepository;

    /** @var  SettingService */
    protected $settingService;
    /*
     * Execute the console command.
     */
    public function __construct(CountryRepository $countryRepository, SettingService $settingService)
    {
        parent::__construct();

        $this->countryRepository = $countryRepository;
        $this->settingService = $settingService;
    }

    public function handle()
    {
        if(User::exists()) {
            $this->info('User already exists');

        }

        $this->createInstance();

        $this->createUser();

        $this->createDefaultRoles();

        $this->attachUserToRoles();

        $this->attachUserToInstance();

        $this->setCompanyProfile();

        $this->call('unisys:set-company-profile');
    }

    private function createInstance()
    {
        $this->info('Create Instance');

        $data['name'] = $this->validate(function() {
            return $this->ask('Instance name *');
        }, 'required|string|max:150');

        $this->instance = Instance::create($data);

        $this->success('Instance '. $this->instance->name .' was created');
    }

    private function createUser()
    {
        $this->info('Create User');

        $data['name'] = $this->validate(function() {
            return $this->ask('Name *');
        }, 'required|string|max:100');

        $data['surname'] = $this->validate(function() {
            return $this->ask('Surname *');
        }, 'required|string|max:100');

        $data['email'] = $this->validate(function() {
            return $this->ask('Email *');
        }, 'required|email');

        $data['username'] = $this->validate(function() {
            return $this->ask('Username for login *');
        }, 'required|string|max:100');

        $data['password'] = $this->validate(function() {
            return $this->ask('Password for login *');
        }, 'required|string|max:100');

        $data['active'] = 1;

        $this->user = User::create($data);

        $this->success('User '. $this->user->getFullName() .' was created');
        $this->info('REMEMBER Login credentials: username: '. $data['username'] .', password: '.$data['password'].'');
    }

    private function createDefaultRoles()
    {
        $this->info('Create default roles admin and user');

        $this->adminRole = Role::create([
            'name' => 'admin',
            'guard_name' => 'api',
        ]);

        Role::create([
            'name' => 'user',
            'guard_name' => 'api',
        ]);

        $this->success('Roles admin and user was created');
    }

    private function attachUserToRoles()
    {
        $this->user->attachRole($this->adminRole);

        $this->success('User '. $this->user->getFullName() .' was attached to role Admin');
    }

    private function attachUserToInstance()
    {
        $this->user->instances()->attach($this->instance->id);

        $this->success('User '. $this->user->getFullName() .' was attached to instance '. $this->instance->name);
    }

    private function setCompanyProfile()
    {
        if(companyProfile()) {
            $this->info('Company profile already exist');

            if (!$this->confirm('Do you wish to continue and rewrite it?')) {
                return;
            }
        }

        $this->info('Set Company information');

        $contactData['name'] = $this->validate(function() {
            return $this->ask('Contact name *');
        }, 'required|string|max:40');

        $contactData['company'] = $this->validate(function() {
            return $this->ask('Company name *');
        }, 'required|string|max:40');

        $contactData['street'] = $this->validate(function() {
            return $this->ask('Street');
        }, 'nullable|string|max:40');

        $contactData['zip'] = $this->validate(function() {
            return $this->ask('Zip');
        }, 'nullable|string|max:10');

        $contactData['city'] = $this->validate(function() {
            return $this->ask('City');
        }, 'nullable|string|max:20');

        $countryName = $this->validate(function() {
            return $this->choice('Country', $this->countryRepository->getListForSelect(), Country::DEFAULT_COUNTRY_ID);
        }, 'string');

        if($countryName && $country = $this->countryRepository->getByName($countryName)) {
            $contactData['country_id'] = $country->id;
        }

        $contactData['reg_no'] = $this->validate(function() {
            return $this->ask('Registration number');
        }, 'nullable|string|max:20');

        $contactData['tax_no'] = $this->validate(function() {
            return $this->ask('Tax number');
        }, 'nullable|string|max:20');

        $contactData['vat_no'] = $this->validate(function() {
            return $this->ask('Vat number');
        }, 'nullable|string|max:20');

        $contactData['email'] = $this->validate(function() {
            return $this->ask('Email *');
        }, 'required|email');

        $contactData['telephone'] = $this->validate(function() {
            return $this->ask('Phone number');
        }, 'nullable|string|max:20');

        $this->settingService->saveCompanyProfile($contactData);

        $this->info('Company profile is set');
    }

    private function validate(\Closure $closure, string $validates)
    {
        do {
            $value = $closure();

            $validator = \Validator::make(['input' => $value], ['input' => $validates]);

            if ($validator->fails()) {
                $this->error( $validator->errors()->first() );
            }
        } while ($validator->fails());

        return $value;
    }
}
