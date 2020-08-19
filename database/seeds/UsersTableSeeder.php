<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Adi Gunawan',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin123'),
            ]
        ];
        DB::table('users')->insert($data);
    }
}
