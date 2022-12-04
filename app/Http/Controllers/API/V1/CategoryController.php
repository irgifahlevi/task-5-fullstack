<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\Category\DetailCategoryResource;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Http\Resources\Category\ListCategoryResource;

class CategoryController extends Controller
{
    public function index()
    {
        $data_kategori = Categories::all();
        // return response()->json(['data' => $data_kategori]);
        return ListCategoryResource::collection(Categories::paginate(1));
    }

    public function store(StoreCategoryRequest $request)
    {
        $data_create = Categories::create($request->validated());
        return response()->json(['Category created successfully.', new ListCategoryResource($data_create)]);
    }

    public function show($id)
    {
        $data_category = Categories::findOrFail($id);
        return new DetailCategoryResource($data_category);
    }

    public function update(StoreCategoryRequest $request, $id)
    {
        $update = Categories::findOrFail($id);
        $update->update($request->validated());
        return response()->json(['Category update successfully.', new ListCategoryResource($update)], 200);
    }

    public function destroy($id)
    {
        $delete_category = Categories::findOrFail($id);
        $delete_category->delete();

        return response()->json(['Category delete successfully.']);
    }
}
