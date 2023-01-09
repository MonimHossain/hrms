<?php

use Illuminate\Database\Seeder;

class ProcessSegmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset the users table
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('process_segments')->truncate();
        // generate 3 users
        $processes = \App\Process::all();
        DB::table('process_segments')->insert([
            [
                'process_id' => 1,
                'name' => 'All'
            ],
        ]);
        foreach ($processes as $key => $process) {

            if ($process->name == 'Akash') {
                DB::table('process_segments')->insert([

                    [
                        'process_id' => $process->id,
                        'name' => 'All'
                    ],

                    [
                        'process_id' => $process->id,
                        'name' => 'Outbound (Caller)'
                    ],

                    [
                        'process_id' => $process->id,
                        'name' => 'Business Promoter'
                    ],

                ]);
            }

            if ($process->name == 'Banglalink') {
                DB::table('process_segments')->insert([

                    [
                        'process_id' => $process->id,
                        'name' => 'All'
                    ],

                    [
                        'process_id' => $process->id,
                        'name' => 'Inbound'
                    ],

                    [
                        'process_id' => $process->id,
                        'name' => 'IRU'
                    ],

                    [
                        'process_id' => $process->id,
                        'name' => 'Digital'
                    ],

                    [
                        'process_id' => $process->id,
                        'name' => 'Collection'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'Retention'
                    ],

                    [
                        'process_id' => $process->id,
                        'name' => 'Activation'
                    ],

                ]);
            }

            if ($process->name == 'BAT') {
                DB::table('process_segments')->insert([

                    [
                        'process_id' => $process->id,
                        'name' => 'All'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'Inbound'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'Outbound'
                    ],

                ]);
            }

            if ($process->name == 'Beximco') {
                DB::table('process_segments')->insert([

                    [
                        'process_id' => $process->id,
                        'name' => 'All'
                    ],


                ]);
            }

            if ($process->name == 'CPP') {
                DB::table('process_segments')->insert([

                    [
                        'process_id' => $process->id,
                        'name' => 'All'
                    ],

                    [
                        'process_id' => $process->id,
                        'name' => 'Inbound'
                    ],

                ]);
            }

            if ($process->name == 'DIGI') {
                DB::table('process_segments')->insert([

                    [
                        'process_id' => $process->id,
                        'name' => 'All'
                    ],

                    [
                        'process_id' => $process->id,
                        'name' => 'Back Office'
                    ],

                ]);
            }

            if ($process->name == 'Foodpanda') {
                DB::table('process_segments')->insert([

                    [
                        'process_id' => $process->id,
                        'name' => 'All'
                    ],

                    [
                        'process_id' => $process->id,
                        'name' => 'Non Voice Backoffice'
                    ],

                ]);
            }

            if ($process->name == 'Genex Academy') {
                DB::table('process_segments')->insert([

                    [
                        'process_id' => $process->id,
                        'name' => 'All'
                    ],

                ]);
            }

            if ($process->name == 'Genex Solutions') {
                DB::table('process_segments')->insert([

                    [
                        'process_id' => $process->id,
                        'name' => 'All'
                    ],

                ]);
            }

            if ($process->name == 'Genex Store') {
                DB::table('process_segments')->insert([

                    [
                        'process_id' => $process->id,
                        'name' => 'All'
                    ],

                    [
                        'process_id' => $process->id,
                        'name' => 'Sale Executive'
                    ],

                    [
                        'process_id' => $process->id,
                        'name' => 'Specialist'
                    ],

                ]);
            }

            if ($process->name == 'GP') {
                DB::table('process_segments')->insert([

                    [
                        'process_id' => $process->id,
                        'name' => 'All'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'Inbound'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'Outbound'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'Digital (Social Media)'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'Digital (Live Chat)'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'Digital (Email)'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'Digital (Skitto)'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'HR Helpline (8787)'
                    ],

                ]);
            }

            if ($process->name == 'IBBL') {
                DB::table('process_segments')->insert([

                    [
                        'process_id' => $process->id,
                        'name' => 'All'
                    ],

                    [
                        'process_id' => $process->id,
                        'name' => 'Inbound'
                    ],

                ]);
            }

            if ($process->name == 'NIC') {
                DB::table('process_segments')->insert([

                    [
                        'process_id' => $process->id,
                        'name' => 'All'
                    ],

                    [
                        'process_id' => $process->id,
                        'name' => 'Inbound'
                    ],

                ]);
            }

            if ($process->name == 'Robi') {
                DB::table('process_segments')->insert([

                    [
                        'process_id' => $process->id,
                        'name' => 'All'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'Inbound'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'Outbound (Service Call)'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'Outbound (HVC)'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'Non Voice (Web)'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'Non Voice (CM)'
                    ],

                ]);
            }

            if ($process->name == 'Samsung') {
                DB::table('process_segments')->insert([

                    [
                        'process_id' => $process->id,
                        'name' => 'All'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'Inbound'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'Outbound'
                    ],

                ]);
            }

            if ($process->name == 'Uber') {
                DB::table('process_segments')->insert([

                    [
                        'process_id' => $process->id,
                        'name' => 'All'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'AID'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'DRVRSOS'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'DS'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'ECR'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'ES'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'RDRSOS'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'XS'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'OBD ToF'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'OBD DIC'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'DocAppr'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'Snow'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'AID-SOS'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'InApDrvr'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'Eaters'
                    ],
                    [
                        'process_id' => $process->id,
                        'name' => 'EATS OUT'
                    ],

                ]);
            }

        }

    }
}
