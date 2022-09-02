<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFilterRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(UserFilterRequest $request): JsonResponse
    {
        $users = $this->userService->filter($request->all());

        return response()->json([
            'users' => $users,
        ]);
    }
}
