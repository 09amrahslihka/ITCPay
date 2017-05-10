<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::where('email', 'naman@it7solutions.com')->first();
        $user->authorization_password = 'Z2135235GHY26HGG34LN';
        $user->save();
    }
}
