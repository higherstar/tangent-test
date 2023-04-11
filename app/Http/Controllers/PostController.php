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

  public function index()
  {
    return response()->json([
      'data' => $this->postRepository->getPosts()
    ]);
  }

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

  public function show(string $id)
  {
    $post = $this->postRepository->getPostById($id);

    if ($post === null)
    {
      return response()->json(['message' => 'post not found'], Response::HTTP_NOT_FOUND);
    }

    return response()->json($post);
  }

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

  public function delete(string $id)
  {
    return response()->json([
      $this->postRepository->deletePost($id)
    ], Response::HTTP_NO_CONTENT);
  }
}
