<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
         ['id' => 1, 'label' => 'Habitation'],
         ['id' => 2, 'label' => 'Auto'],
         ['id' => 3, 'label' => 'Sante'],
         ['id' => 4, 'label' => 'Animaux'],
         ['id' => 5, 'label' => 'Partage']
        ];

        foreach($categories as $category){
            $categoryTmp = Category::find($category['id']);
            if(is_null($categoryTmp)){
                Category::create($category);
            }
        }

    }
}
