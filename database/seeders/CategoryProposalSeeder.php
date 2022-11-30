<?php

namespace Database\Seeders;

use App\Models\Master\CategoryProposal;
use Illuminate\Database\Seeder;

class CategoryProposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrCategoryProposal = [
            'Rintisan', 'Sudah Berjalan',
        ];
        foreach ($arrCategoryProposal as $category) {
            CategoryProposal::create([
                'name' => $category
            ]);
        }
    }
}
