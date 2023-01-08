<?php

namespace App\Http\Controllers;

use App\Repositories\Auth\AuthRepository;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    private $AuthRepository;
    public function __construct(AuthRepository $AuthRepository)
    {
        $this->AuthRepository = $AuthRepository;
    }
    public function login(LoginRequest $request)
    {
        return $this->AuthRepository->loginFunction($request);
    }
    public function logout()
    {
        return $this->AuthRepository->logOutFunction();
    }
    public function profile()
    {
        return $this->AuthRepository->profileFunction();
    }

    public function create(CreateUserRequest $request)
    {
        return $this->AuthRepository->createUser($request);
    }
}
