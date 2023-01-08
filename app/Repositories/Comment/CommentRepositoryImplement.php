<?php

namespace App\Repositories\Comment;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\comment;
use App\Models\blog;
use App\Http\Controllers\BaseController;
use DB;


class CommentRepositoryImplement extends Eloquent implements CommentRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(comment $model)
    {
        $this->model = $model;
    }

    public function getFunction($id)
    {
        $query  = $this->model->where('id_detail_blog', $id)->get();

        if ($query->isEmpty()) {
            return BaseController::error(NULL, "Data tidak ditemukan", 400);
        }

        return BaseController::success($query, "Berhasil menarik data blog", 200);
    }

    public function detailFunction($id)
    {
        $query  = $this->model->find($id);

        if ($query ==  NULL) {
            return BaseController::error(NULL, "Data tidak ditemukan", 400);
        }

        return BaseController::success($query, "Berhasil menarik data detail", 200);
    }

    public function createFunction($id_blog, $request)
    {
        try {
            DB::beginTransaction();
            $input = new $this->model();
            $input->id_detail_blog = $id_blog;
            $input->nama = $request->nama;
            $input->comment = $request->comment;
            $input->email = $request->email ? $request->email : "";
            $input->save();

            $count = $this->model->where('id_detail_blog', $id_blog)->count();

            $query = blog::where("id", $id_blog)->first();
            if (empty($query)) {
                return BaseController::error(NULL, "Data tidak ditemukan", 400);
            }

            $query->jumlah_comment = $count;
            $query->save();

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
        $query->nama = $request->nama;
        $query->comment = $request->comment;
        $query->save();

        return BaseController::success($query, "Sukses mengubah data", 200);
    }

    public function deleteFunction($id, $id_blog)
    {
        try {
            $query = $this->model->find($id);
            if (empty($query)) {
                return BaseController::error(NULL, "Data tidak ditemukan", 400);
            }
            $query->destroy($id);

            $count = $this->model->where('id_detail_blog', $id_blog)->count();

            $query = blog::where("id", $id_blog)->first();
            if (empty($query)) {
                return BaseController::error(NULL, "Data tidak ditemukan", 400);
            }

            $query->jumlah_comment = $count;
            $query->save();
        } catch (\Exception $e) {
            DB::rollback();
            return BaseController::error(NULL, $e->getMessage(), 400);
        }
        return BaseController::success(NULL, "Sukses menghapus data (Permanen)", 200);
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
