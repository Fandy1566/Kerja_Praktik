<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            "Kepala Sekolah",
            "Admin",
            "Guru Tetap",
            "Guru Honorer",
            "Berhenti",
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert([
                'nama_role' => $role,
            ]);

        }
    }
}
