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
        // Create an App\User "admin" instance...
        factory(App\User::class, 'admin')->create();
        factory(App\User::class, 'waiter', 1)->create();
        factory(App\User::class, 'client', 1)->create();

        // Create three App\User instances...
		factory(App\User::class, 3)->create();
    }
}
