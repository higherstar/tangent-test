<?php

namespace Tests\Unit;

use Tests\TestCase;

class PostControllerIntegrationTest extends TestCase
{
  public function testIndex()
  {
    $response = $this->get('/api/post');
    $response->assertJsonStructure(['data' => []]);
    $response->assertJsonIsObject();
    $response->assertStatus(200);
  }

  public function testShow()
  {
    $id = 2;

    $returnResponse = [
      'id' => 2,
      'title' => "post2",
      'content' => "Content post from article post number two about posting second",
      'user_id' => 2,
      'category_id' => 4,
      'created_at' => "2023-04-11T12:45:39.000000Z",
      'updated_at' => "2023-04-11T12:45:39.000000Z"
    ];

    $response = $this->get('/api/post/' . $id);
    $response->assertJsonStructure(['id' => []]);
    $response->assertJsonIsObject();
    $response->assertExactJson($returnResponse);
    $response->assertStatus(200);
  }

  public function testPostNotFound()
  {
    $id = 100;

    $response = $this->get('/api/post/' . $id);
    $response->assertNotFound();
  }

  public function testUpdate()
  {
    $id = 3;

    $content = [
      'title' => 'post5_updated',
      'content' => 'Semi Content post from article post number four about posting forth',
      'user_id' => 1,
      'category_id' => 1
    ];

    $response = $this->put('/api/post/' . $id, $content);
    $response->assertStatus(204);
  }

  public function testCreate()
  {
    $bodyContent = [
      'title' => 'post5',
      'content' => 'Content post from article post number four about posting forth',
      'user_id' => 1,
      'category_id' => 3
    ];

    $response = $this->post('/api/post', $bodyContent);
    $data = json_decode($response->getContent());
    $response->assertStatus(201);
  }

  public function testDelete()
  {
    $lastUser = $this->get('/api/post');
    $id = end(json_decode($lastUser->getContent())->data)->id;
    $response = $this->delete('/api/post/'.$id);
    $response->assertStatus(204);
  }
}
