<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon;
use Kavist\RajaOngkir\Facades\RajaOngkir;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Sandi Harimau',
            'email' => 'devharimau@vmcafe.id',
            'password' => Hash::make('Kediri18!'),
            'phone' => '08123456789',
            'gender' => 'l',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
        $this->call(LocationsSeeder::class);
    }
}
