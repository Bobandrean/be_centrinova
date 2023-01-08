<?php

namespace App\Repositories\Auth;

use LaravelEasyRepository\Repository;

interface AuthRepository extends Repository
{

    // Write something awesome :)
    public function loginFunction($request);
    public function logOutFunction();
    public function profileFunction();
    public function createUser($request);
}
