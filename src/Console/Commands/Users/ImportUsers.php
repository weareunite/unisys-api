<?php

namespace Unite\UnisysApi\Console\Commands\Users;

use Illuminate\Console\Command;
use Unite\UnisysApi\Models\User;

class ImportUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unisys-api:import-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import users from users.xslx';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // todo: dorobit import od vydania toho Maatwebsite/Excel 3.1 momentalne je len 3.0 kde chybaju veci
        return;

        $pathToExcel = storage_path('import/users.xlsx');

        Excel::load($pathToExcel, function($reader) {

            $rows = $reader->get();
            $bar = $this->output->createProgressBar($rows->count());

            foreach ($rows as $item) {
                if(!$object = User::where('username', '=', $item->username)->first()) {
                    $object = User::create([
                        'name'          => $item->name,
                        'email'         => $item->email,
                        'username'      => $item->username,
                        'password'      => $item->password,
                    ]);
                    $object->assignRole($item->rola);
                } else {
                    $data = [
                        'name'          => $item->name,
                        'password'      => $item->password,
                    ];

                    if(!User::where('email', '=', $item->email)->exists()) {
                        $data['email'] = $item->email;
                    }

                    $object->update($data);
                    $object->syncRoles([$item->rola]);
                }

                $bar->advance();
            }

            $bar->finish();
        });
    }
}
