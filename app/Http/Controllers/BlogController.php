<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use Illuminate\Http\Request;
use App\Repositories\Blog\BlogRepository;

class BlogController extends Controller
{
    private $BlogRepository;
    public function __construct(BlogRepository $BlogRepository)
    {
        $this->BlogRepository = $BlogRepository;
    }
    public function index()
    {
        return $this->BlogRepository->getFunction();
    }
    public function create(BlogRequest $request)
    {
        return $this->BlogRepository->createFunction($request);
    }
    public function update($id, BlogRequest $request)
    {
        return $this->BlogRepository->updateFunction($id, $request);
    }
    public function delete($id)
    {
        return $this->BlogRepository->deleteFunction($id);
    }
    public function restore($id)
    {
        return $this->BlogRepository->restoreFunction($id);
    }
    public function detail($id)
    {
        return $this->BlogRepository->detailFunction($id);
    }
}
