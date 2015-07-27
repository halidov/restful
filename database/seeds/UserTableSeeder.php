<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create three App\User instances...
		factory(App\User::class, 3)->create();

		// Create an App\User "admin" instance...
		factory(App\User::class, 'admin')->create();
    }
}
