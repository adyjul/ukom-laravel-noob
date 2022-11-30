<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            PermissionRoleUserSeeder::class,
            CategoryProposalSeeder::class
        ]);

        // for ($i = 0; $i < 100; $i++) {
        //     User::factory()->create([
        //         'name' => 'User-' . ($i + 1),
        //         'username' => 'User-' . ($i + 1),
        //     ]);
        // }
    }
}
