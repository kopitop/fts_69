<?php

namespace App\Repositories;

use Exception;
use DB;
use Auth;
use Carbon\Carbon;

abstract class BaseRepository
{
    protected $model;

    public function count()
    {
        return $this->model->count();
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        $data = $this->model->find($id);

        if (!$data) {
            throw new Exception(trans('messages.error.find_error', ['item' => class_basename($this->model)]));
        }

        return $data;
    }

    public function findBy($column, $option)
    {
        $data = $this->model->where($column, $option)->get();

        if (!$data) {
            throw new Exception(trans('messages.error.find_error', ['item' => class_basename($this->model)]));
        }

        return $data;
    }

    public function paginate($limit)
    {
        return $this->model->paginate($limit);
    }

    public function lists($column, $key = null)
    {
        return $this->model->lists($column, $key);
    }

    public function create($inputs)
    {
        try {
            $this->model->create($inputs);
            $message = trans('messages.success.create_success', ['item' => class_basename($this->model)]);
        } catch (Exception $ex) {
            $message = trans('messages.error.create_error', ['item' => class_basename($this->model)]);
        }

        return $message;
    }

    public function insert($inputs)
    {
        $now = Carbon::now();

        foreach ($inputs as $input) {
            $input['created_at'] = $now;
            $input['updated_at'] = $now;
        }

        return $this->model->insert($inputs);
    }

    public function update($inputs, $id)
    {
        $data = $this->model->where('id', $id)->update($inputs);

        if (!$data) {
            throw new Exception(trans('messages.error.update_error', ['item' => class_basename($this->model)]));
        }

        return $data;
    }

    public function delete($ids)
    {
        try {
            DB::beginTransaction();
            $data = $this->model->destroy($ids);

            if (!$data) {
                throw new Exception(trans('messages.error.delete_error', ['item' => class_basename($this->model)]));
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    public function search($column, $value)
    {
        return $this->model->where('$column LIKE $value');
    }

    public function store($input)
    {
        $data = $this->model->create($input);

        if (!$data) {
            throw new Exception(trans('messages.error.create_error', ['item' => class_basename($this->model)]));
        }

        return $data;
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);

        if (!$data) {
            throw new Exception(trans('messages.error.show_error', ['item' => class_basename($this->model)]));
        }

        return $data;
    }
}
