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

        $image_name = 'B' . time() . '.' . $image->getClientOriginalExtension();

        $image->move($path, $image_name);

        return $image_name;
    }

    public function deleteImage($item)
    {
        $filePath = config('global.' . $this->modelName . '_image_path') . $item;

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }


    private function processData($request)
    {
        $data = $request->all();

        // for upload image on save item
        if ($request->hasFile('image') && !$request->has('shouldUpload')) {
            $data['image'] = $this->uploadImage($request->file('image'));
        }

        // for upload image on update item
        if ($request->hasFile('image') && $request->shouldUpload == true) {
            $model = $this->model::find($request->id);
            $this->deleteImage($model->image);
            $data['image'] = $this->uploadImage($request->file('image'));
        }

        if (isset($request->password)) {
            $data['password'] = bcrypt($request->password);
        }

        return filterEmptyValues($data);
    }

    private function getModelWithRelations($id = null)
    {
        return $data = $id
            ? $this->model::with($this->relations)->find($id)
            : $this->model::with($this->relations)->get();
    }

    public function all()
    {
        $model =  $this->getModelWithRelations();

        return $model
            ? successResponse($this->modelName . ' fetched successfully.', $model)
            : errorResponse($this->modelName . ' fetch failed.');
    }

    public function get($id)
    {
        $model = $this->getModelWithRelations($id);

        return $model
            ? successResponse($this->modelName . ' fetched successfully.', $model)
            : errorResponse($this->modelName . ' fetch failed.');
    }

    public function save($request)
    {
        $data = $this->processData($request);

        $isCreated = $this->model::create($data);

        if (!$isCreated) {
            errorResponse($this->modelName . ' save failed.');
        }

        $model = $this->getModelWithRelations();

        return $model
            ? successResponse($this->modelName . ' saved successfully.', $model)
            : errorResponse($this->modelName . ' save failed.');
    }

    public function update($request, $id)
    {
        $data = $this->processData($request);

        $isUpdated = $this->model::find($id)->update($data);

        if (!$isUpdated) {
            errorResponse($this->modelName . ' update failed.');
        }

        $model = $this->getModelWithRelations();

        return $model
            ? successResponse($this->modelName . ' updated successfully.', $model)
            : errorResponse($this->modelName . ' update failed.');
    }

    public function delete($id)
    {
        $modelData = $this->model::find($id);

        if ($modelData && isset($modelData->image)) {
            $this->deleteImage($modelData->image);
        }

        if ($modelData && isset($modelData->qr_code)) {
            $this->deleteImage($modelData->qr_code);
        }

        $isDeleted = $modelData && $modelData->delete() ;

        if (!$isDeleted) {
            errorResponse($this->modelName . ' delete failed.');
        }

        $model = $this->getModelWithRelations();

        return $model
            ? successResponse($this->modelName . ' deleted successfully.', $model)
            : errorResponse($this->modelName . ' delete failed.');
    }
}
