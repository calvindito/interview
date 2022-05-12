<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
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

        foreach($data->employee as $e) {
            Employee::create([
                'nip'           => $e->nip,
                'name'          => $e->name,
                'address'       => $e->address,
                'date_of_birth' => $e->date_of_birth,
                'date_join'     => $e->date_join
            ]);
        }
    }
}
