<?php

use App\Status;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'id' => '1',
                'title' => 'To Do',
                'color' => '#ffd700',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '2',
                'title' => 'Done',
                'color' => '#008000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '3',
                'title' => 'Canceled',
                'color' => '#b22222',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '4',
                'title' => 'Expired',
                'color' => '#808080',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        Status::insert($statuses);
    }
}
