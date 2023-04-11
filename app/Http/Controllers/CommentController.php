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

  public function index()
  {
    return response()->json([
      'data' => $this->commentRepository->getComments()
    ]);
  }

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

  public function show(string $id)
  {
    $comment = $this->commentRepository->getCommentById($id);

    if ($comment === null)
    {
      return response()->json(['message' => 'comment not found'], Response::HTTP_NOT_FOUND);
    }

    return response()->json($comment);
  }

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

  public function delete(string $id)
  {
    return response()->json([
      $this->commentRepository->deleteComment($id)
    ], Response::HTTP_NO_CONTENT);
  }
}
