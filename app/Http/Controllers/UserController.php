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

  public function index()
  {
    return response()->json([
      'data' => $this->userRepository->getUsers()
    ]);
  }

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

  public function show($id)
  {
    $user = $this->userRepository->getUserById($id);

    if ($user === null)
    {
      return response()->json(['message' => 'user not found'], Response::HTTP_NOT_FOUND);
    }

    return response()->json([
      'data' => [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email
      ]
    ]);
  }

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

  public function delete($id)
  {
    return response()->json([
      $this->userRepository->deleteUser($id)
    ], Response::HTTP_NO_CONTENT);
  }
}
