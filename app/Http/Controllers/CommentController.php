<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Interfaces\CommentRepositoryInterface;

class CommentController extends Controller
{
  private CommentRepositoryInterface $commentRepository;

  public function __construct(CommentRepositoryInterface $commentRepository)
  {
    $this->commentRepository = $commentRepository;
  }

  /**
   * @OA\Get(
   *     path="/api/comment",
   *     tags={"Comments"},
   *     summary="Get all comment",
   *     @OA\Response(
   *          response=200,
   *          description="Get all comment success"
   *      )
   *     )
   * 
   */
  public function index()
  {
    return response()->json([
      'data' => $this->commentRepository->getComments()
    ]);
  }

  /**
   * @OA\Post(
   *      path="/api/comment",
   *      tags={"Comments"},
   *      summary="Create new comment",
   *      @OA\RequestBody(
   *        @OA\MediaType(
   *            mediaType="application/json",
   *            @OA\Schema(
   *                @OA\Property(
   *                    property="content",
   *                    type="string"
   *                ),
   *                @OA\Property(
   *                    property="post_id",
   *                    type="number"
   *                ),
   *                example={"content": "Comment on post number x", "post_id": 3}
   *            )
   *        )
   *      ),      
   *      @OA\Response(
   *          response=201,
   *          description="Create new comment succeed"
   *      )
   *     )
   * 
   */
  public function store(Request $request)
  {
    $commentDetails = [
      'content' => $request->content,
      'post_id' => $request->post_id
    ];

    return response()->json(
      [
        'data' => $this->commentRepository->createComment($commentDetails)
      ],
      Response::HTTP_CREATED
    );
  }

  /**
   * @OA\Get(
   *      path="/api/comment/{id}",
   *      tags={"Comments"},
   *      summary="Get comment by id",
   *      @OA\Parameter(
   *          name="id",
   *          in="path"
   *      ),
   *      @OA\Response(
   *          response=200,
   *          description="Get comment by id succeed"
   *      ),
   *      @OA\Response(
   *        response=404,
   *        description="Comment not Found"
   *      )
   *     )
   * 
   */
  public function show(string $id)
  {
    $comment = $this->commentRepository->getCommentById($id);

    if ($comment === null)
    {
      return response()->json(['message' => 'comment not found'], Response::HTTP_NOT_FOUND);
    }

    return response()->json($comment);
  }

  /**
   * @OA\Put(
   *     path="/api/comment/{id}",
   *     tags={"Comments"},
   *     summary="Updates a comment",
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
   *                   property="content",
   *                   type="string"
   *               ),
   *               @OA\Property(
   *                   property="post_id",
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
    $commentDetails = [
      'content' => $request->content,
      'post_id' => $request->post_id
    ];

    return response()->json([
      $this->commentRepository->updateComment($id, $commentDetails)
    ], Response::HTTP_NO_CONTENT);
  }

  /**
   * @OA\Delete(
   *      path="/api/comment/{id}",
   *      tags={"Comments"},
   *      summary="Delete comment by id",
   *      @OA\Parameter(
   *          name="id",
   *          in="path"
   *      ),
   *      @OA\Response(
   *          response=204,
   *          description="Delete comment by id succeed"
   *      )
   *     )
   * 
   */
  public function delete(string $id)
  {
    return response()->json([
      $this->commentRepository->deleteComment($id)
    ], Response::HTTP_NO_CONTENT);
  }
}
