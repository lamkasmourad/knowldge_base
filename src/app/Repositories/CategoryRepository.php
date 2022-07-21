
<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Keyword;
use App\Models\Voisin;
use App\Repositories\Interfaces\ContenuRepositoryInterface;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{


    public function getAllCategories(){
        return Category::select('id as value' ,'label')->get()->toArray();
    }

}
