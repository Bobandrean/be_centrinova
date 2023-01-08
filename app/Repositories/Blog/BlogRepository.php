<?php

namespace App\Repositories\Blog;

use LaravelEasyRepository\Repository;

interface BlogRepository extends Repository
{

    public function getFunction();
    public function createFunction($request);
    public function updateFunction($id, $request);
    public function deleteFunction($id);
    public function detailFunction($id);
    public function restoreFunction($id);
    // Write something awesome :)
}
