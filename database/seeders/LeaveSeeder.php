<?php

namespace Database\Seeders;

use App\Models\Leave;
use Illuminate\Database\Seeder;

class LeaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $get_json = file_get_contents(public_path('data.json'));
        $data     = json_decode($get_json);

        foreach($data->leave as $l) {
            Leave::create([
                'employee_id' => $l->employee_id,
                'date_leave'  => $l->date_leave,
                'long_leave'  => $l->long_leave,
                'description' => $l->description
            ]);
        }
    }
}
