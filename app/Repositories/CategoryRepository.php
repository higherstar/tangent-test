<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
  public function getCategories()
  {
    return Category::all();
  }

  public function getCategoryById($categoryId)
  {
    return Category::find($categoryId);
  }

  public function createCategory(array $categoryDetails)
  {
    return Category::create($categoryDetails);
  }

  public function updateCategory($categoryId, array $categoryDetails)
  {
    return Category::find($categoryId)->update($categoryDetails);
  }

  public function deleteCategory($categoryId)
  {
    Category::destroy($categoryId);
  }
}