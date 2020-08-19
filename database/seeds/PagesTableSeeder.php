<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
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
                'page_code' => 'dashboard',
                'page_title'=> 'Dashboard',
                'page_description'=> 'Halaman Utama',
                'insert_by'=> 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'page_code' => 'alluser',
                'page_title'=> 'Data Pengguna',
                'page_description'=> '-',
                'insert_by'=> 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'page_code' => 'createuser',
                'page_title'=> 'Tambah Pengguna',
                'page_description'=> '-',
                'insert_by'=> 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'page_code' => 'edituser',
                'page_title'=> 'Edit Data Pengguna',
                'page_description'=> '-',
                'insert_by'=> 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'page_code' => 'permission',
                'page_title'=> 'Data Hak Akses',
                'page_description'=> 'Halaman untuk menambah dan mengurangi hak akses pada sistem',
                'insert_by'=> 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'page_code' => 'pages',
                'page_title'=> 'Halaman',
                'page_description'=> 'Menu untuk menambahkan judul dan heading semua halaman sistem',
                'insert_by'=> 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'page_code' => 'roles',
                'page_title'=> 'Group Hak Akses',
                'page_description'=> 'Halaman untuk mengelompokkan hak akses yang akan diberikan kepada pengguna sistem',
                'insert_by'=> 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'page_code' => 'addrole',
                'page_title'=> 'Tambah Group Hak Akses',
                'page_description'=> 'Tambah data group hak akses',
                'insert_by'=> 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'page_code' => 'editrole',
                'page_title'=> 'Edit Group Hak Akses',
                'page_description'=> '-',
                'insert_by'=> 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        DB::table('pages')->insert($data);
    }
}
