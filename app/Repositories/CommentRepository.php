<?php

namespace App\Repositories;

use App\Interfaces\CommentRepositoryInterface;
use App\Models\Comment;

class CommentRepository implements CommentRepositoryInterface
{
  public function getComments()
  {
    return Comment::all();
  }

  public function getCommentById($commentId)
  {
    return Comment::find($commentId);
  }

  public function createComment(array $commentDetails)
  {
    return Comment::create($commentDetails);
  }

  public function updateComment($commentId, array $commentDetails)
  {
    return Comment::find($commentId)->update($commentDetails);
  }

  public function deleteComment($commentId)
  {
    Comment::destroy($commentId);
  }
}