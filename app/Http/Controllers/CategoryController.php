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

  /**
   * @OA\Get(
   *     path="/api/category",
   *     tags={"Categories"},
   *     summary="Get list of categories",
   *     @OA\Response(
   *          response=200,
   *          description="Successful operation"
   *      )
   *     )
   * 
   */
  public function index()
  {
    return response()->json([
      'data' => $this->categoryRepository->getCategories()
    ]);
  }

  /**
   * @OA\Post(
   *      path="/api/category",
   *      tags={"Categories"},
   *      summary="Create new category",
   *      @OA\RequestBody(
   *        @OA\MediaType(
   *            mediaType="application/json",
   *            @OA\Schema(
   *                @OA\Property(
   *                    property="name",
   *                    type="string"
   *                ),
   *                example={"name": "Technology"}
   *            )
   *        )
   *      ),      
   *      @OA\Response(
   *          response=201,
   *          description="Create new category succeed"
   *      )
   *     )
   * 
   */
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

  /**
   * @OA\Get(
   *      path="/api/category/{id}",
   *      tags={"Categories"},
   *      summary="Get category by id",
   *      @OA\Parameter(
   *          name="id",
   *          in="path"
   *      ),
   *      @OA\Response(
   *          response=200,
   *          description="Get category by id succeed"
   *      ),
   *      @OA\Response(
   *        response=404,
   *        description="Category Not Found"
   *      )
   *     )
   * 
   */
  public function show(string $id)
  {
    $category = $this->categoryRepository->getCategoryById($id);

    if ($category === null)
    {
      return response()->json(['message' => 'category not found'], Response::HTTP_NOT_FOUND);
    }

    return response()->json($category);
  }

  /**
   * @OA\Put(
   *     path="/api/category/{id}",
   *     tags={"Categories"},
   *     summary="Updates a category",
   *     @OA\Parameter(
   *         description="Parameter with mutliple examples",
   *         in="path",
   *         name="id",
   *         required=true,
   *     ),
   *     @OA\RequestBody(
   *       @OA\MediaType(
   *           mediaType="application/json",
   *           @OA\Schema(
   *               @OA\Property(
   *                   property="name",
   *                   type="string"
   *               ),
   *           )
   *        )
   *      ),      
   *     @OA\Response(
   *        response=204,
   *        description="OK"
   *     ),
   * )
   */
  public function update(Request $request, string $id)
  {
    $categoryDetail = [
      'name' => $request->name,
    ];

    return response()->json([
      $this->categoryRepository->updateCategory($id, $categoryDetail)
    ], Response::HTTP_NO_CONTENT);
  }

  /**
   * @OA\Delete(
   *      path="/api/category/{id}",
   *      tags={"Categories"},
   *      summary="Delete category by id",
   *      @OA\Parameter(
   *          name="id",
   *          in="path"
   *      ),
   *      @OA\Response(
   *          response=204,
   *          description="Delete category by id succeed"
   *      )
   *     )
   * 
   */
  public function delete(string $id)
  {
    return response()->json([
      $this->categoryRepository->deleteCategory($id)
    ], Response::HTTP_NO_CONTENT);
  }
}
