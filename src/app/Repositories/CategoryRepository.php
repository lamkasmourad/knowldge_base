<?php
namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{

    public function getAllCategories(){
        return Category::select('id as value' ,'label')->get()->toArray();
    }

}
