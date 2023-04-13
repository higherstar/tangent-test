<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  private UserRepositoryInterface $userRepository;

  public function __construct(UserRepositoryInterface $userRepository)
  {
    $this->userRepository = $userRepository;
  }
  
  /**
   * @OA\Get(
   *     path="/api/users",
   *     tags={"Users"},
   *     summary="Get list of users",
   *     @OA\Response(
   *          response=200,
   *          description="Get all user success"
   *      )
   *     )
   * 
   */
  public function index()
  {
    return response()->json([
      'data' => $this->userRepository->getUsers()
    ]);
  }
  
  /**
   * @OA\Post(
   *      path="/api/users",
   *      tags={"Users"},
   *      summary="Create new user",
   *      @OA\RequestBody(
   *        @OA\MediaType(
   *            mediaType="application/json",
   *            @OA\Schema(
   *                @OA\Property(
   *                    property="name",
   *                    type="string"
   *                ),
   *                @OA\Property(
   *                    property="email",
   *                    type="string"
   *                ),
   *                @OA\Property(
   *                    property="password",
   *                    type="string"
   *                ),
   *                example={"name": "user_swagger", "email": "swagger@gmail.com", "password": "password"}
   *            )
   *        )
   *      ),      
   *      @OA\Response(
   *          response=201,
   *          description="Create new user succeed"
   *      )
   *     )
   * 
   */
  public function store(Request $request)
  {
    $userDetails = [
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password)
    ];

    return response()->json(
      [
        'data' => $this->userRepository->createUser($userDetails)
      ],
      Response::HTTP_CREATED
    );
  }

  /**
   * @OA\Get(
   *      path="/api/users/{id}",
   *      tags={"Users"},
   *      summary="Get user by id",
   *      @OA\Parameter(
   *          name="id",
   *          in="path"
   *      ),
   *      @OA\Response(
   *          response=200,
   *          description="Get user by id succeed"
   *      ),
   *      @OA\Response(
   *        response=404,
   *        description="User Not Found"
   *      )
   *     )
   * 
   */
  public function show($id)
  {
    $user = $this->userRepository->getUserById($id);

    if ($user === null)
    {
      return response()->json(['message' => 'user not found'], Response::HTTP_NOT_FOUND);
    }

    return response()->json([
      'data' => [
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email']
      ]
    ]);
  }

  /**
   * @OA\Put(
   *     path="/api/users/{id}",
   *     tags={"Users"},
   *     summary="Update user",
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
   *               @OA\Property(
   *                   property="email",
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
  public function update(Request $request, $id)
  {
    $userDetail = [
      'name' => $request->name,
      'email' => $request->email
    ];

    return response()->json([
      $this->userRepository->updateUser($id, $userDetail)
    ], Response::HTTP_NO_CONTENT);
  }

  /**
   * @OA\Delete(
   *      path="/api/users/{id}",
   *      tags={"Users"},
   *      summary="Delete user by id",
   *      @OA\Parameter(
   *          name="id",
   *          in="path"
   *      ),
   *      @OA\Response(
   *          response=204,
   *          description="Delete user by id succeed"
   *      )
   *     )
   * 
   */
  public function delete($id)
  {
    return response()->json([
      $this->userRepository->deleteUser($id)
    ], Response::HTTP_NO_CONTENT);
  }
}
