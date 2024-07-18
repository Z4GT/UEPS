<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Responsible;

class ResponsibleSeeder extends Seeder
{
    public function run()
    {
        // Responsible::factory()->count(20)->create();

        Responsible::create([
            'id_responsible' => 'RESP-01',
            'id_user' => '1',
            'card_id' => '1004548960',
            'name' => 'Diego',
            'last_name' => 'Recalde',
            'area' => 'Development',
            'role' => 'Project Manager',
            'status' => true,
        ]);

        Responsible::create([
            'id_responsible' => 'RESP-02',
            'id_user' => '2',
            'card_id' => '2345678901',
            'name' => 'Jane',
            'last_name' => 'Smith',
            'area' => 'Marketing',
            'role' => 'Marketing Specialist',
            'status' => true,
        ]);

        Responsible::create([
            'id_responsible' => 'RESP-03',
            'id_user' => '3',
            'card_id' => '3456789012',
            'name' => 'Emily',
            'last_name' => 'Johnson',
            'area' => 'Design',
            'role' => 'Designer',
            'status' => false,
        ]);

        Responsible::create([
            'id_responsible' => 'RESP-04',
            'id_user' => '4',
            'card_id' => '4567890123',
            'name' => 'Michael',
            'last_name' => 'Brown',
            'area' => 'Development',
            'role' => 'Developer',
            'status' => true,
        ]);

        Responsible::create([
            'id_responsible' => 'RESP-05',
            'id_user' => '5',
            'card_id' => '5678901234',
            'name' => 'Sarah',
            'last_name' => 'Davis',
            'area' => 'Sales',
            'role' => 'Sales Manager',
            'status' => false,
        ]);
        
    }
}