<?php

namespace App\Http\Controllers;

use App\Models\ArticlePhotoModel;
use Brick\Math\BigInteger;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\ArticleModel;

class ArticleController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batas = 10;
        $jumlah_artikel = ArticleModel::count();
        $kumpulan_artikel = ArticleModel::orderBy('id', 'desc')->paginate($batas);
        $no = $batas * ($kumpulan_artikel->currentPage() - 1);
        return view('index', compact('kumpulan_artikel', 'no', 'jumlah_artikel'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.create_form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'contact_name' => 'required',
            'whatsapp_number' => 'required',

            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        $filename = time() . '.' . $request->file('thumbnail')->getClientOriginalName();
        $filepath = $request->file('thumbnail')->storeAs('uploads', $filename, 'public');

        Image::make(storage_path().'/app/public/uploads/'.$filename)
            ->save();

        $article = new ArticleModel();
        $article->title = $request->title;
        $article->description = $request->description;
        $article->price = $request->price;
        $article->contact_name = $request->contact_name;
        $article->whatsapp_number = $request->whatsapp_number;
        $article->link_google_maps = $request->link_google_maps;
        $article->article_seo = strtolower(str_replace(' ', '-', $request->title));
        $article->thumbnail_name = $filename;
        $article->thumbnail_path = $filepath;
        $article->save();

        if ($request->file('photos')) {
            foreach ($request -> file('photos') as $key => $file) {
                $filename = time() . $key . '.' . $file->getClientOriginalName();
                $filepath = $file->storeAs('uploads', $filename, 'public');

                $articlePhotos = ArticlePhotoModel::create([
                    'article_id' => $article->id,
                    'filename' => $filename,
                    'path' => $filepath,
                ]);
            }
        }

        return redirect('artikel')->with('success', 'Artikel berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id ,string $article_seo)
    {
        $artikel = ArticleModel::find($id);
        return view('articles.show', compact('artikel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
