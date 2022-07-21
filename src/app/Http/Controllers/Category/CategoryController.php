<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryController extends Controller{



    private CategoryRepositoryInterface $categoryRepo;


    public function __construct(CategoryRepositoryInterface $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }



    public function getAllCategories(){
        return $this->categoryRepo->getAllCategories();
    }







}
