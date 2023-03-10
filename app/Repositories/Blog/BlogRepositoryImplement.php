<?php

namespace App\Repositories\Blog;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\blog;
use App\Models\detail_blog;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\BaseController;
use DB;
use File;


class BlogRepositoryImplement extends Eloquent implements BlogRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(blog $model)
    {
        $this->model = $model;
    }

    public function getFunction()
    {
        $query  = $this->model->with(['detail'])->where('status', 0)->paginate(10);

        if ($query->isEmpty()) {
            return BaseController::error(NULL, "Data tidak ditemukan", 400);
        }

        return BaseController::success($query, "Berhasil menarik data blog", 200);
    }

    public function detailFunction($id)
    {
        $query  = $this->model->with(['detail', 'comment'])->find($id);

        if ($query ==  NULL) {
            return BaseController::error(NULL, "Data tidak ditemukan", 400);
        }

        return BaseController::success($query, "Berhasil menarik data detail", 200);
    }

    public function createFunction($request)
    {


        // $img = File::get(url('storage/test.jpg'));
        // return $img;
        try {
            $imageName = time() . '.' . $request->image->extension();
            Storage::disk('public')->putFileAs('image', $request->file('image'), $imageName);

            $url = "http://127.0.0.1:8000/uploads/image/" . $imageName;

            DB::beginTransaction();

            $input = new $this->model();
            $input->judul = $request->judul;
            $input->path = $url;
            $input->short_content = $request->short_content;
            $input->save();
            $input->id;

            $detail  = new detail_blog();
            $detail->blog_id =  $input->id;
            $detail->entry = $request->entry;
            $detail->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return BaseController::error(NULL, $e->getMessage(), 400);
        }
        return BaseController::success($input, "Sukses menambah data", 200);
    }

    public function updateFunction($id, $request)
    {
        $query = $this->model->where("id", $id)->first();
        if (empty($query)) {
            return BaseController::error(NULL, "Data tidak ditemukan", 400);
        }
        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();
            Storage::disk('public')->putFileAs('image', $request->file('image'), $imageName);
        }

        $url = $request->image ? "http://127.0.0.1:8000/uploads/image/" . $imageName : $query->path;

        $query->judul = $request->judul;
        $query->path =  $url;
        $query->short_content = $request->short_content;
        $query->save();

        $detail  = detail_blog::where('blog_id', $id)->first();
        $detail->entry = $request->entry;
        $detail->save();

        return BaseController::success($query, "Sukses mengubah data", 200);
    }

    public function deleteFunction($id)
    {
        $query = $this->model->where("id", $id)->first();
        if (empty($query)) {
            return BaseController::error(NULL, "Data tidak ditemukan", 400);
        }
        $query->status = 1;
        $query->save();

        return BaseController::success($query, "Sukses menghapus data", 200);
    }

    public function restoreFunction($id)
    {
        $query = $this->model->where("id", $id)->first();
        if (empty($query)) {
            return BaseController::error(NULL, "Data tidak ditemukan", 400);
        }
        $query->status = 0;
        $query->save();

        return BaseController::success($query, "Sukses mengembalikan data", 200);
    }

    // Write something awesome :)
}
