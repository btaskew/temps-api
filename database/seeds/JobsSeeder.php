<?php

use Illuminate\Database\Seeder;

class JobsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobs = factory(App\Job::class, 30)->create();

        foreach ($jobs as $job) {
            factory(App\Tag::class, 3)->create(['job_id' => $job->id]);
        }
    }
}
