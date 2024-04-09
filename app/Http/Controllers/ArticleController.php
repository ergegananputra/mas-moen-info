<?php

namespace App\Http\Controllers;

use App\Models\ArticlePhotoModel;
use App\Models\CategoriesModel;
use Brick\Math\BigInteger;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\ArticleModel;
use Illuminate\Support\Str;
use HTMLPurifier;
use HTMLPurifier_Config;

class ArticleController extends Controller
{

    public function __construct() {
        $this->middleware('auth')
            ->except('index', 'search', 'show', 'indexByCategory');
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

    public function indexByCategory(string $category) {
        $batas = 25;
        $jumlah_artikel = ArticleModel::where('category', $category)->count();
        $kumpulan_artikel = ArticleModel::where('category', $category)->orderBy('id', 'desc')->paginate($batas);
        $no = $batas * ($kumpulan_artikel->currentPage() - 1);
        return view('index', compact('kumpulan_artikel', 'no', 'jumlah_artikel'));
    }

    public function search(Request $request) {
        $keyword = $request->keyword;
        $kumpulan_artikel = ArticleModel::where('title', 'like', '%' . $keyword . '%')->paginate(25);
        $jumlah_artikel = ArticleModel::where('title', 'like', '%' . $keyword . '%')->count();
        $no = 0;
        return view('index', compact('kumpulan_artikel', 'no', 'jumlah_artikel'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CategoriesModel::all();
        return view('articles.create_form', compact('categories'));
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


            
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'b,strong,i,em,u,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]');
        $purifier = new HTMLPurifier($config);
        
        $clean_html = $purifier->purify($request->description);
    

        $article = new ArticleModel();
        $article->title = $request->title;
        $article->description = $clean_html;
        $article->price = $request->price;
        $article->price_by = $request->price_by;
        $article->contact_name = $request->contact_name;
        $article->whatsapp_number = $request->whatsapp_number;
        $article->address = $request->address;
        $article->link_google_maps = $request->link_google_maps;
        $article->thumbnail_name = $filename;
        $article->thumbnail_path = $filepath;
        $article->category_id = $request->category;
        $article->author_id = auth()->user()->id;

        $article->short_description = Str::limit($clean_html, 100);

        $embed_gmaps_link = $request->embed_gmaps_link;
        if ($embed_gmaps_link) {
            if (Str::startsWith($embed_gmaps_link, 'https://www.google.com/maps/embed')) {
                $article->embed_gmaps_link = $embed_gmaps_link;
            } else if (Str::startsWith($embed_gmaps_link, '<iframe')) {
                $url = explode('"', $embed_gmaps_link)[1];
                $article->embed_gmaps_link = $url;
            }
        }

        $article->save();

        $article->article_seo = Str::slug($request->title) . '-' . $article->created_at->format('YmdHis');
        $article->save();

        ArticlePhotoModel::create([
            'article_id' => $article->id,
            'filename' => $filename,
            'path' => $filepath,
            'is_thumbnail' => true,
        ]);

        if ($request->file('photos')) {
            foreach ($request -> file('photos') as $key => $file) {
                $filename = time() . $key . '.' . $file->getClientOriginalName();
                $filepath = $file->storeAs('uploads', $filename, 'public');

                ArticlePhotoModel::create([
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
    public function show(string $article_seo) {
        $artikel = ArticleModel::where('article_seo', $article_seo)->first();
        return view('articles.show', compact('artikel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $article_seo)
    {
        $categories = CategoriesModel::all();
        $artikel = ArticleModel::where('article_seo', $article_seo)->first();
        $thumbnail = $artikel->photos()->where('is_thumbnail', true)->first();
        return view('articles.edit_form', compact('artikel', 'thumbnail', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $article_seo)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'contact_name' => 'required',
            'whatsapp_number' => 'required',
        ]);

        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'b,strong,i,em,u,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]');
        $purifier = new HTMLPurifier($config);
        
        $clean_html = $purifier->purify($request->description);

        $article = ArticleModel::where('article_seo', $article_seo)->first();
        $article->title = $request->title;
        $article->description = $clean_html;
        $article->price = $request->price;
        $article->price_by = $request->price_by;
        $article->contact_name = $request->contact_name;
        $article->whatsapp_number = $request->whatsapp_number;
        $article->address = $request->address;
        $article->link_google_maps = $request->link_google_maps;
        $article->category_id = $request->category;
        $article->article_seo = Str::slug($request->title) . '-' . $article->created_at->format('YmdHis');

        $article->short_description = Str::limit($clean_html, 100);

        $embed_gmaps_link = $request->embed_gmaps_link;
        if ($embed_gmaps_link) {
            if (Str::startsWith($embed_gmaps_link, 'https://www.google.com/maps/embed')) {
                $article->embed_gmaps_link = $embed_gmaps_link;
            } else if (Str::startsWith($embed_gmaps_link, '<iframe')) {
                $url = explode('"', $embed_gmaps_link)[1];
                $article->embed_gmaps_link = $url;
            }
        }
        

        $article->save();

        if ($request->hasFile('thumbnail')) {

            

            $this->validate($request, [
                'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            ]);

            $filename = time() . '.' . $request->file('thumbnail')->getClientOriginalName();
            $filepath = $request->file('thumbnail')->storeAs('uploads', $filename, 'public');

            $old_thumbnail = $article->photos()->where('is_thumbnail', true)->first();
            if ($old_thumbnail instanceof ArticlePhotoModel) {
                $old_thumbnail->filename = $filename;
                $old_thumbnail->path = $filepath;
                $old_thumbnail->save();
            }
            
        }

        if ($request->file('photos')) {
            foreach ($request -> file('photos') as $key => $file) {
                $filename = time() . $key . '.' . $file->getClientOriginalName();
                $filepath = $file->storeAs('uploads', $filename, 'public');

                ArticlePhotoModel::create([
                    'article_id' => $article->id,
                    'filename' => $filename,
                    'path' => $filepath,
                ]);
            }
        }

        return redirect('artikel')->with('success', 'Artikel berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $artikel = ArticleModel::find($id);
        $artikel->delete();
        return redirect('artikel')->with('success', 'Artikel berhasil dihapus');
    }

    public function deletePhoto(string $article_seo, string $id) {
        $photo = ArticlePhotoModel::find($id);
        $photo->delete();
        return redirect('artikel/' . $article_seo . '/edit')->with('success', 'Foto berhasil dihapus');
    }
}
