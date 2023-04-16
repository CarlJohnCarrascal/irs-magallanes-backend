<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
            $input['name'] = 'Medical Accident';
            Type::create($input);
            $input['name'] = 'Traumatic Accident';
            Type::create($input);
        }

        $id = Type::all("id")->where("name","=","Medical Accident")->first(null,1);
        if (!IncidentCause::all()->where("type_id","=",$id)->count()) {
            
            $input['type_id'] = $id;

            $input['name'] = 'Cardiac arrest patient';
            IncidentCause::create($input);

            $input['name'] = 'Stroke Patient';
            IncidentCause::create($input);

            $input['name'] = 'Diabetic emergencies';
            $input['description'] = 'such as diabetic ketoacidosis or hypoglycemia';
            IncidentCause::create($input);

            $input['name'] = 'Respiratory distress patients';
            $input['description'] = 'such as those with severe asthma attacks or pneumothorax';
            IncidentCause::create($input);
        }

        $id = Type::all("id")->where("name","=","Traumatic Accident")->first(null,2);
        if (!IncidentCause::all()->where("type_id","=",$id)->count()) {
            $input['type_id'] = $id;

            $input['name'] = 'Motor vehicle accident victims';
            IncidentCause::create($input);

            $input['name'] = 'Gunshot or stab wound victims';
            IncidentCause::create($input);

            $input['name'] = 'Falls from heights';
            $input['description'] = '';
            IncidentCause::create($input);

            $input['name'] = 'Burns';
            $input['description'] = 'thermal or chemical';
            IncidentCause::create($input);

            $input['name'] = 'Crush injuries';
            $input['description'] = 'such as in building collapses or heavy machinery accidents';
            IncidentCause::create($input);
        }
    }
}
