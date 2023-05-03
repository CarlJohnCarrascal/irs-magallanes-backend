<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Barangay;
use App\Models\IncidentCause;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        if (!User::count()) {

            $input['password'] = bcrypt('irs-admin');
            $input['role'] = 'admin';
            $input['firstname'] = 'Administrator';
            $input['lastname'] = '';
            $input['address'] = 'IRS';
            $input['email'] = 'admin@irs.com';
            $input['status'] = 'active';
            User::create($input);

            $input['password'] = bcrypt('irs-guest');
            $input['role'] = 'guest';
            $input['firstname'] = 'Guest';
            $input['lastname'] = '';
            $input['address'] = 'IRS';
            $input['email'] = 'guest@irs.com';
            $input['status'] = 'active';
            User::create($input);

        }
        if(!Type::count()) {
            $input1['name'] = 'Medical';
            Type::create($input1);
            $input1['name'] = 'Traumatic';
            Type::create($input1);
        }

        $id = Type::all("id")->where("name","=","Medical Accident")->first(null,1);
        if (!IncidentCause::all()->where("type_id","=",$id)->count()) {
            
            $input2['type_id'] = $id;

            $input2['name'] = 'Cardiac arrest patient';
            IncidentCause::create($input2);

            $input2['name'] = 'Stroke Patient';
            IncidentCause::create($input2);

            $input2['name'] = 'Diabetic emergencies';
            $input2['description'] = 'such as diabetic ketoacidosis or hypoglycemia';
            IncidentCause::create($input2);

            $input2['name'] = 'Respiratory distress patients';
            $input2['description'] = 'such as those with severe asthma attacks or pneumothorax';
            IncidentCause::create($input2);

            $input2['name'] = 'Other';
            $input2['description'] = '';
            IncidentCause::create($input2);
        }

        $id = Type::all("id")->where("name","=","Traumatic Accident")->first(null,2);
        if (!IncidentCause::all()->where("type_id","=",$id)->count()) {
            $input3['type_id'] = $id;

            $input3['name'] = 'Motor vehicle accident victims';
            IncidentCause::create($input3);

            $input3['name'] = 'Gunshot or stab wound victims';
            IncidentCause::create($input3);

            $input3['name'] = 'Falls from heights';
            $input3['description'] = '';
            IncidentCause::create($input3);

            $input3['name'] = 'Burns';
            $input3['description'] = 'thermal or chemical';
            IncidentCause::create($input3);

            $input3['name'] = 'Crush injuries';
            $input3['description'] = 'such as in building collapses or heavy machinery accidents';
            IncidentCause::create($input3);

            $input3['name'] = 'Other';
            $input3['description'] = '';
            IncidentCause::create($input3);
            
        }

        if(!Barangay::count()) {
            $brgy['name'] = 'Barangay 1';
            Barangay::create($brgy);
            $brgy['name'] = 'Barangay 2';
            Barangay::create($brgy);
            $brgy['name'] = 'Barangay 3';
            Barangay::create($brgy);
        }
    }
}
