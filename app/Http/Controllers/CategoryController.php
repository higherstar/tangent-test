<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Interfaces\CategoryRepositoryInterface;

class CategoryController extends Controller
{
  private CategoryRepositoryInterface $categoryRepository;

  public function __construct(CategoryRepositoryInterface $categoryRepository)
  {
    $this->categoryRepository = $categoryRepository;
  }

  public function index()
  {
    return response()->json([
      'data' => $this->categoryRepository->getCategories()
    ]);
  }

  public function store(Request $request)
  {
    $categoryDetails = [
      'name' => $request->name,
    ];

    return response()->json(
      [
        'data' => $this->categoryRepository->createCategory($categoryDetails)
      ],
      Response::HTTP_CREATED
    );
  }

  public function show(string $id)
  {
    $category = $this->categoryRepository->getCategoryById($id);

    if ($category === null)
    {
      return response()->json(['message' => 'category not found'], Response::HTTP_NOT_FOUND);
    }

    return response()->json($category);
  }

  public function update(Request $request, string $id)
  {
    $categoryDetail = [
      'name' => $request->name,
    ];

    return response()->json([
      $this->categoryRepository->updateCategory($id, $categoryDetail)
    ], Response::HTTP_NO_CONTENT);
  }

  public function delete(string $id)
  {
    return response()->json([
      $this->categoryRepository->deleteCategory($id)
    ], Response::HTTP_NO_CONTENT);
  }
}
