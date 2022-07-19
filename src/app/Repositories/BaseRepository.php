<?php
namespace App\Repositories;
use Carbon\Carbon;
class BaseRepository {
    public $model;
    public function __construct($model){
        $this->model = $model;
    }
    public function all(){
        return $this->model->all();
    }
    public function getById($id){
        return $this->model->findorFail($id);
    }
    public function store($model){
        $model->created_at = Carbon::now();
        return $model->save();
    }
    public function update($model){
        $model->updated_at = Carbon::now();
        return $model->save();
    }
    public function destroy($model){
        return $model->delete();
    }
}
