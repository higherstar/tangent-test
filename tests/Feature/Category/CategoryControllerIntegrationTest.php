<?php

namespace Tests\Unit;

use Tests\TestCase;

class CategoryControllerIntegrationTest extends TestCase
{
  public function testIndex()
  {
    $response = $this->get('/api/category');
    $response->assertJsonStructure(['data' => []]);
    $response->assertJsonIsObject();
    $response->assertStatus(200);
  }

  public function testShow()
  {
    $id = 2;

    $response = $this->get('/api/category/' . $id);
    $response->assertJsonStructure(['id' => []]);
    $response->assertJsonIsObject();
    $response->assertExactJson(['id' => 2, 'name' => 'Updated Category', 'created_at' => '2023-04-11T12:16:22.000000Z', 'updated_at' => '2023-04-13T14:56:06.000000Z']);
    $response->assertStatus(200);
  }

  public function testCategoryNotFound()
  {
    $id = 100;

    $response = $this->get('/api/category/' . $id);
    $response->assertNotFound();
  }

  public function testUpdate()
  {
    $id = 3;

    $content = [
      'name' => 'Updated Category'
    ];

    $response = $this->put('/api/category/' . $id, $content);
    $response->assertStatus(204);
  }

  public function testCreate()
  {
    $bodyContent = [
      'id' => 101,
      'name' => 'New category'
    ];

    $response = $this->post('/api/category', $bodyContent);
    $data = json_decode($response->getContent());
    $response->assertStatus(201);
  }

  public function testDelete()
  {
    $latestCategory = $this->get('/api/category');
    $id = end(json_decode($latestCategory->getContent())->data)->id;
    $response = $this->delete('/api/category/'.$id);
    $response->assertStatus(204);
  }
}
