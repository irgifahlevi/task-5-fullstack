<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticlesRequest;
use App\Http\Requests\UpdateArticlesRequest;
use App\Http\Resources\Articles\DetailArticlesResource;
use App\Http\Resources\Articles\ListArticlesResource;
use App\Http\Resources\ListAllResource;
use App\Models\Articles;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use Validator;

class ArticlesController extends Controller
{
    public function index()
    {
        $data = Articles::all();
        return ListArticlesResource::collection(Articles::paginate(1));
        // ->loadMissing(['kategori:id,name'])
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user_id' => 'required',
            'category_id' => 'required|exists:categories,id'
        ]);

        if ($request->file) {

            $fileName = $this->generateRandomString();
            $extension = $request->file->extension();
            Storage::putFileAs('images', $request->file, $fileName . '.' . $extension);
        }

        $request['image'] = $fileName . '.' . $extension;
        $create_articles = Articles::create($request->all());
        return response()->json(['Category created successfully.', new ListArticlesResource($create_articles)]);
    }

    public function show($id)
    {
        $data_articles = Articles::with('kategori:id,name')->findOrFail($id);
        return new DetailArticlesResource($data_articles);
    }

    public function update(UpdateArticlesRequest $request, $id)
    {
        if ($request->file) {
            $fileName = $this->generateRandomString();
            $extension = $request->file->extension();
            Storage::putFileAs('images', $request->file, $fileName . '.' . $extension);
            $update_image = $fileName . '.' . $extension;
        }

        $request['image'] = $update_image;

        $validasi_data = Articles::findOrFail($id);
        $validasi_data->update($request->validated());
        return response()->json(['Articles update successfuly.', new ListArticlesResource($validasi_data->loadMissing(['kategori:id,name']))], 200);
        // return response()->json(['Articles update successfuly.']);
    }

    public function destroy($id)
    {

        $delete_articles = Articles::findOrFail($id);
        $delete_articles->delete();
        return response()->json(['Article delete successfully.']);
    }


    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
