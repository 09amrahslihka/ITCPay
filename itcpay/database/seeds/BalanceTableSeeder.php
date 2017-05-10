<?php

use Illuminate\Database\Seeder;

class BalanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	
	       $users = \App\User::whereNotIn('id', function($query) {
				$query->select('id')
					->from(with(new \App\Balance())->getTable());
		   })->get();
		   foreach($users as $user)
		   {
				//print_r($user);
			    DB::table('balance')->insert([
					 'id' => $user->id,
					 'balance' => '0.00',
				 ]);
		   }		   
    }
}
