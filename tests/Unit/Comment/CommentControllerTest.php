<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Interfaces\CommentRepositoryInterface;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;

class CommentControllerTest extends TestCase
{
  private $expectedReturn = [
    'content' => 'Second Content post from article post number one about posting one',
    'post_id' => 2
  ];

  private $expectedBody = [
    'content' => 'Six Content post from article post number one about posting one',
    'post_id' => 3
  ];

  public function testIndex()
  {
    $repository = $this->createMock(CommentRepositoryInterface::class);

    $repository
      ->expects($this->once())
      ->method('getComments')
      ->willReturn($this->expectedReturn);

    $response = (new CommentController($repository))->index();

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testShow()
  {
    $repository = $this->createMock(CommentRepositoryInterface::class);

    $userId = 2;

    $repository
      ->expects($this->once())
      ->method('getCommentById')
      ->willReturn($this->expectedReturn);

    $response = (new CommentController($repository))->show($userId);

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testCommentNotFound()
  {
    $repository = $this->createMock(CommentRepositoryInterface::class);

    $id = 2;

    $repository
      ->expects($this->once())
      ->method('getCommentById')
      ->willReturn(null);

    $response = (new CommentController($repository))->show($id);

    $this->assertEquals(404, $response->getStatusCode());
  }

  public function testCreate()
  {
    $request = $this->createMock(Request::class);
    $request->with($this->expectedBody);

    $repository = $this->createMock(CommentRepositoryInterface::class);
    $repository
      ->expects($this->once())
      ->method('createComment')
      ->willReturn($this->expectedReturn);

    $response = (new CommentController($repository))->store($request);

    $this->assertEquals(201, $response->getStatusCode());
  }

  public function testUpdate()
  {
    $request = $this->createMock(Request::class);
    $request->with($this->expectedBody);

    $repository = $this->createMock(CommentRepositoryInterface::class);

    $id = 2;

    $repository
      ->expects($this->once())
      ->method('updateComment')
      ->willReturn($this->expectedReturn);

    $response = (new CommentController($repository))->update($request, $id);

    $this->assertEquals(204, $response->getStatusCode());
  }

  public function testDelete()
  {
    $repository = $this->createMock(CommentRepositoryInterface::class);

    $id = 2;

    $repository
      ->expects($this->once())
      ->method('deleteComment')
      ->willReturn($this->expectedReturn);

    $response = (new CommentController($repository))->delete($id);

    $this->assertEquals(204, $response->getStatusCode());
  }
}
