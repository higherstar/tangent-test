<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Interfaces\PostRepositoryInterface;

class PostController extends Controller
{
  private PostRepositoryInterface $postRepository;

  public function __construct(PostRepositoryInterface $postRepository)
  {
    $this->postRepository = $postRepository;
  }
  
  /**
   * @OA\Get(
   *     path="/api/post",
   *     tags={"Posts"},
   *     summary="Get all posts",
   *     @OA\Response(
   *          response=200,
   *          description="Get all post success"
   *      )
   *     )
   * 
   */
  public function index()
  {
    return response()->json([
      'data' => $this->postRepository->getPosts()
    ]);
  }

  /**
   * @OA\Post(
   *      path="/api/post",
   *      tags={"Posts"},
   *      summary="Create new post",
   *      @OA\RequestBody(
   *        @OA\MediaType(
   *            mediaType="application/json",
   *            @OA\Schema(
   *                @OA\Property(
   *                    property="title",
   *                    type="string"
   *                ),
   *                @OA\Property(
   *                    property="content",
   *                    type="string"
   *                ),
   *                @OA\Property(
   *                    property="user_id",
   *                    type="number"
   *                ),
   *                @OA\Property(
   *                    property="category_id",
   *                    type="number"
   *                ),
   *                example={"title": "post swagger", "content": "Description about post swagger on article", "user_id": 2, "category_id": 3}
   *            )
   *        )
   *      ),      
   *      @OA\Response(
   *          response=201,
   *          description="Create new post succeed"
   *      )
   *     )
   * 
   */
  public function store(Request $request)
  {
    $postDetails = [
      'title' => $request->title,
      'content' => $request->content,
      'user_id' => $request->user_id,
      'category_id' => $request->category_id,
    ];

    return response()->json(
      [
        'data' => $this->postRepository->createPost($postDetails)
      ],
      Response::HTTP_CREATED
    );
  }

  /**
   * @OA\Get(
   *      path="/api/post/{id}",
   *      tags={"Posts"},
   *      summary="Get post by id",
   *      @OA\Parameter(
   *          name="id",
   *          in="path"
   *      ),
   *      @OA\Response(
   *          response=200,
   *          description="Get post by id succeed"
   *      ),
   *      @OA\Response(
   *        response=404,
   *        description="Post Not Found"
   *      )
   *     )
   * 
   */
  public function show(string $id)
  {
    $post = $this->postRepository->getPostById($id);

    if ($post === null)
    {
      return response()->json(['message' => 'post not found'], Response::HTTP_NOT_FOUND);
    }

    return response()->json($post);
  }

  /**
   * @OA\Put(
   *     path="/api/post/{id}",
   *     tags={"Posts"},
   *     summary="Update post",
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
   *                   property="title",
   *                   type="string"
   *               ),
   *               @OA\Property(
   *                   property="content",
   *                   type="string"
   *               ),
   *               @OA\Property(
   *                   property="user_id",
   *                   type="number"
   *               ),
   *               @OA\Property(
   *                   property="category_id",
   *                   type="number"
   *               )
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
    $postDetail = [
      'title' => $request->title,
      'content' => $request->content,
      'user_id' => $request->user_id,
      'category_id' => $request->category_id,
    ];

    return response()->json([
      $this->postRepository->updatePost($id, $postDetail)
    ], Response::HTTP_NO_CONTENT);
  }

   /**
   * @OA\Delete(
   *      path="/api/post/{id}",
   *      tags={"Posts"},
   *      summary="Delete post by id",
   *      @OA\Parameter(
   *          name="id",
   *          in="path"
   *      ),
   *      @OA\Response(
   *          response=204,
   *          description="Delete post by id succeed"
   *      )
   *     )
   * 
   */
  public function delete(string $id)
  {
    return response()->json([
      $this->postRepository->deletePost($id)
    ], Response::HTTP_NO_CONTENT);
  }
}
