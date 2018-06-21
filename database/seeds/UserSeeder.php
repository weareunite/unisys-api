<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name'          => 'Vlado Zilka',
                'email'         => 'vlado.zilka@gmail.com',
                'username'      => 'vlado.zilka',
                'password'      => bcrypt('asdasd'),
            ],
            [
                'name'          => 'Michal Stupak',
                'email'         => 'michal@unite.sk',
                'username'      => 'michal',
                'password'      => bcrypt('michalko'),
            ]
        ];

        foreach ($users as $user) {
            \Unite\UnisysApi\Models\User::create($user);
        }
    }
}
