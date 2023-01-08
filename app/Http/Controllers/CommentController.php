<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Repositories\Comment\CommentRepository;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    private $CommentRepository;
    public function __construct(CommentRepository $CommentRepository)
    {
        $this->CommentRepository = $CommentRepository;
    }
    public function index($id)
    {
        return $this->CommentRepository->getFunction($id);
    }
    public function create($id_blog, CommentRequest $request)
    {
        return $this->CommentRepository->createFunction($id_blog, $request);
    }
    public function delete($id, $id_blog)
    {
        return $this->CommentRepository->deleteFunction($id, $id_blog);
    }
    public function detail($id)
    {
        return $this->CommentRepository->detailFunction($id);
    }
}
