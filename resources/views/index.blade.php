@extends('layouts.app')

@section('content')
    <br>

    <form action="{{route('article.search')}}" method="GET" class="container searchbar">
        <div class="input-group w-100 h-inherit">
            <input id="keyword" type="text" class="form-control" name="keyword" placeholder="Cari ...">
            <button class="btn btn-outline-secondary d-flex align-items-center" 
                type="submit" id="button-search"
                >
                <span class="material-symbols-outlined mr-4">
                    search
                    </span>
                Cari
            </button>
        </div>
    </form>

    @if (Auth::user() != null && Auth::user()->role == 'role_admin')
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('article.create') }}" 
            class="btn btn-primary"
            style="position: fixed; bottom: 20px; right: 20px; padding: 20px; font-size: 20px;"
            >
                <span class="material-symbols-outlined" style="vertical-align: middle;">add</span>
                Tambah Artikel
            </a>
        </div>
    @endif

    @foreach ($kumpulan_artikel as $artikel)
        <div class="card article">
            <a href="{{route('article.show', $artikel->article_seo) }}"
                style="color: inherit; text-decoration: none;"> 
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img 
                                src="{{asset('storage/'.$artikel->thumbnail_path)}}" 
                                class="card-img-top thumbnail" alt="{{$artikel->thumbnail_name}}"
                            >
                        </div>
                        <div class="col-md-8">
                            <h4 class="card-title">{{$artikel->title}}</h4>
                            <p class="card-text">{{Str::limit($artikel->description, 250)}}</p>

                            <span 
                                class="badge bg-secondary my-2"
                                style="font-size: 1em; padding: 10px;"
                                > {{$artikel->category}} </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach

    

    <br>
    <div>{{$kumpulan_artikel->links()}}</div>
    <div><strong> Artikel : {{$jumlah_artikel}}</strong></div>
@endsection