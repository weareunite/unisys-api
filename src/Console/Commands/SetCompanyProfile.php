<?php

namespace Unite\UnisysApi\Commands;

use Illuminate\Console\Command;
use Illuminate\Routing\Router;
use Unite\Contacts\CountryRepository;
use Unite\Contacts\Models\Country;
use Unite\UnisysApi\Services\SettingService;

class SetCompanyProfile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unisys-api:set-company-profile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set Basic company profile if is not exists';

    /**
     * The router instance.
     *
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    /**
     * An array of all the registered routes.
     *
     * @var \Illuminate\Routing\RouteCollection
     */
    protected $routes;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Router $router)
    {
        parent::__construct();

        $this->router = $router;
        $this->routes = $router->getRoutes();
    }

    /*
     * Execute the console command.
     */
    public function handle(SettingService $settingService, CountryRepository $countryRepository)
    {
        if(app('companyProfile')) {
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

        $countryName = $this->validate(function() use ($countryRepository) {
            return $this->choice('Country', $countryRepository->getListForSelect(), Country::DEFAULT_COUNTRY_ID);
        }, 'string');

        if($countryName && $country = $countryRepository->getByName($countryName)) {
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

        $settingService->saveCompanyProfile($contactData);

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
