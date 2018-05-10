<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(App\User::class)->create([
            'email' => 'john@email.com',
            'name' => 'John Doe',
            'password' => Hash::make('password')
        ]);

        $worker = factory(App\Worker::class)->create([
            'user_id' => $user->id
        ]);

        factory(App\Experience::class, 3)->create([
            'worker_id' => $worker->id
        ]);

        factory(App\Education::class, 3)->create([
            'worker_id' => $worker->id
        ]);
    }
}
