<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;

use Illuminate\Validation\ValidationException;

class BaseService
{
    private $model;
    private $modelName;
    private $relations;

    public function initialize($model, $modelName, $relations)
    {
        $this->model = $model;
        $this->modelName = $modelName;
        $this->relations = $relations;
        return $this;
    }


    public function uploadImage($image)
    {
        $path = config('global.' . $this->modelName . '_image_path');

        $image_name = 'bvend-' . $image_path . '-' . time() . '.' . $image->getClientOriginalExtension();

        $image->move($path, $image_name);

        return $image_name;
    }

    public function deleteImage($item)
    {
        $file = config('global.' . $this->modelName . '_image_path') . $item->image;

        return file_exists($file) ? unlink($file) : false;

    }

    private function processData($inputData)
    {
        $data = $inputData->all();

        // if ($data && $inputData->has('image')) {
        //     $data['image'] = $this->uploadImage($inputData->file('image'));
        // }

        if (isset($inputData->is_active)) {
            $data['is_active'] = $inputData->is_active === true ? 1 : 0;
        }

        if (isset($inputData->password)) {
            $data['password'] = bcrypt($inputData->password);
        }

        return $data;
    }

    private function getModelWithRelations($message = null, $id = null)
    {
        $data = $id
            ? $this->model::with($this->relations)->find($id)
            : $this->model::with($this->relations)->get();

        return $data ? successResponse($message, $data) : errorResponse($message);
    }

    public function all()
    {
        return $this->getModelWithRelations();
    }

    public function get($id)
    {
        return $this->getModelWithRelations($id);
    }

    public function save($userData)
    {

        $data = $this->processData($userData);

        $this->model::create($data);

        return $this->getModelWithRelations($this->modelName . ' saved');
    }

    public function update($userData, $id)
    {
        $data = $this->processData($userData);

        $this->model::find($id)->update($data);

        return $this->getModelWithRelations($this->modelName . ' updated');
    }

    public function delete($id)
    {
        $modelData = $this->model::find($id);

        if ($modelData && isset($modelData->image)) {
            $this->deleteImage($modelData->image);
        }

        if ($modelData && isset($modelData->{'qr-code'})) {
            $this->deleteImage($modelData->{'qr-code'});
        }

        $isDeleted = $modelData->delete() ? true : false;

        return $isDeleted ? $this->getModelWithRelations($this->modelName . ' deleted') : errorResponse($this->modelName . ' delete');
    }
}
