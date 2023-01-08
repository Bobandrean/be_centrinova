<?php

namespace App\Repositories\Comment;

use LaravelEasyRepository\Repository;

interface CommentRepository extends Repository
{
    public function getFunction($id);
    public function createFunction($id_blog, $request);
    public function updateFunction($id, $request);
    public function deleteFunction($id, $id_blog);
    public function detailFunction($id);
    public function restoreFunction($id);
    // Write something awesome :)
}
