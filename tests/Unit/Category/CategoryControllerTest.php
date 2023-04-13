<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Interfaces\CategoryRepositoryInterface;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;

class CategoryControllerTest extends TestCase
{
  public function testIndex()
  {
    $repository = $this->createMock(CategoryRepositoryInterface::class);

    $repository
      ->expects($this->once())
      ->method('getCategories')
      ->willReturn(['data' => ['name' => 'category']]);

    $response = (new CategoryController($repository))->index();

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testShow()
  {
    $repository = $this->createMock(CategoryRepositoryInterface::class);

    $id = 2;

    $repository
      ->expects($this->once())
      ->method('getCategoryById')
      ->willReturn(['data' => ['name' => 'category']]);

    $response = (new CategoryController($repository))->show($id);

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testCategoryNotFound()
  {
    $repository = $this->createMock(CategoryRepositoryInterface::class);

    $id = 2;

    $repository
      ->expects($this->once())
      ->method('getCategoryById')
      ->willReturn(null);

    $response = (new CategoryController($repository))->show($id);

    $this->assertEquals(404, $response->getStatusCode());
  }

  public function testCreate()
  {
    $request = $this->createMock(Request::class);

    $repository = $this->createMock(CategoryRepositoryInterface::class);

    $repository
      ->expects($this->once())
      ->method('createCategory')
      ->willReturn(['data' => ['name' => 'category']]);

    $response = (new CategoryController($repository))->store($request);

    $this->assertEquals(201, $response->getStatusCode());
  }

  public function testUpdate()
  {
    $request = $this->createMock(Request::class);

    $repository = $this->createMock(CategoryRepositoryInterface::class);

    $id = 2;

    $repository
      ->expects($this->once())
      ->method('updateCategory')
      ->willReturn(['data' => ['name' => 'category']]);

    $response = (new CategoryController($repository))->update($request, $id);

    $this->assertEquals(204, $response->getStatusCode());
  }

  public function testDelete()
  {
    $request = $this->createMock(Request::class);

    $repository = $this->createMock(CategoryRepositoryInterface::class);

    $id = 2;

    $repository
      ->expects($this->once())
      ->method('deleteCategory')
      ->willReturn(['data' => ['name' => 'category']]);

    $response = (new CategoryController($repository))->delete($id);

    $this->assertEquals(204, $response->getStatusCode());
  }
}
