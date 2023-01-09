<?php

use Illuminate\Database\Seeder;

class NearbyLocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset the users table
        //DB::statement('SET FOREIGN_KEY_CHECKS=0');
        //DB::table('nearby_locations')->truncate();


        // generate 3 users
        for ($i = 2; $i <= 3; $i++) {
            DB::table('nearby_locations')->insert([
                ['center_id' => $i, 'nearby' => 'Uttara',],
                ['center_id' => $i, 'nearby' => 'Uttarkhan',],
                ['center_id' => $i, 'nearby' => 'Dakkhinkhan',],
                ['center_id' => $i, 'nearby' => 'Nikunja',],
                ['center_id' => $i, 'nearby' => 'Khilkhet',],
                ['center_id' => $i, 'nearby' => 'Tongi',],
                ['center_id' => $i, 'nearby' => 'Baridhara',],
                ['center_id' => $i, 'nearby' => 'Basundhara',],
                ['center_id' => $i, 'nearby' => 'Banani',],
                ['center_id' => $i, 'nearby' => 'Badda',],
                ['center_id' => $i, 'nearby' => 'Mohakhali',],
                ['center_id' => $i, 'nearby' => 'Mohakhali DOHS',],
                ['center_id' => $i, 'nearby' => 'Shahjadpur',],
                ['center_id' => $i, 'nearby' => 'Tejgaon',],
                ['center_id' => $i, 'nearby' => 'Nakhalpara',],
                ['center_id' => $i, 'nearby' => 'Mogbazar',],
                ['center_id' => $i, 'nearby' => 'Malibag',],
                ['center_id' => $i, 'nearby' => 'Shantinagar',],
                ['center_id' => $i, 'nearby' => 'Bijoy Sarani',],
                ['center_id' => $i, 'nearby' => 'Khamarbari',],
                ['center_id' => $i, 'nearby' => 'Indira Road',],
                ['center_id' => $i, 'nearby' => 'Monipuripara',],
                ['center_id' => $i, 'nearby' => 'Dhanmondi 27',],
                ['center_id' => $i, 'nearby' => 'Lalmatia',],
                ['center_id' => $i, 'nearby' => 'Shankar',],
                ['center_id' => $i, 'nearby' => 'Sobhanbag',],
                ['center_id' => $i, 'nearby' => 'Kalabagan',],
                ['center_id' => $i, 'nearby' => 'Science lab',],
                ['center_id' => $i, 'nearby' => 'Zigatola',],
                ['center_id' => $i, 'nearby' => 'Shyamoli',],
                ['center_id' => $i, 'nearby' => 'Mohammadpur Bus Stand',],
                ['center_id' => $i, 'nearby' => 'New Market',],
                ['center_id' => $i, 'nearby' => 'Azimpur',],
                ['center_id' => $i, 'nearby' => 'Lalbag',],
                ['center_id' => $i, 'nearby' => 'Palashi',],
                ['center_id' => $i, 'nearby' => 'Katabon',],
                ['center_id' => $i, 'nearby' => 'Poribag',],
                ['center_id' => $i, 'nearby' => 'Bangla Motor',],
                ['center_id' => $i, 'nearby' => 'Hatirjheel',],
                ['center_id' => $i, 'nearby' => 'Hatirpool',],
                ['center_id' => $i, 'nearby' => 'Shahbag',],
                ['center_id' => $i, 'nearby' => 'Minto Road',],
                ['center_id' => $i, 'nearby' => 'Kakrail',],
                ['center_id' => $i, 'nearby' => 'Fakirerpool',],
                ['center_id' => $i, 'nearby' => 'Arambag',],
                ['center_id' => $i, 'nearby' => 'Kamlapur',],
                ['center_id' => $i, 'nearby' => 'Khilgaon',],
                ['center_id' => $i, 'nearby' => 'Basabo',],
                ['center_id' => $i, 'nearby' => 'Tikatuli',],
                ['center_id' => $i, 'nearby' => 'Gulistan',],
                ['center_id' => $i, 'nearby' => 'Bakshibazar',],
                ['center_id' => $i, 'nearby' => 'Dhaka University (Arts Faculty)',],
                ['center_id' => $i, 'nearby' => 'Curzon Hall',],
                ['center_id' => $i, 'nearby' => 'Mohammadpur College Gate',],
                ['center_id' => $i, 'nearby' => 'Kallyanpur',],
                ['center_id' => $i, 'nearby' => 'Gabtali',],
                ['center_id' => $i, 'nearby' => 'Mirpur Mazar Road',],
                ['center_id' => $i, 'nearby' => 'Mirpur 1',],
                ['center_id' => $i, 'nearby' => 'Mirpur 10',],
            ]);
        }
    }
}
