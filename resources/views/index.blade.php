@extends('layouts.app')

@section('content')

    @if (Auth::user() != null && Auth::user()->role == 'role_admin')
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('article.create') }}" class="btn btn-primary">Tambah Artikel</a>
        </div>
    @endif

    @foreach ($kumpulan_artikel as $artikel)
        <div class="card">
            <a href="{{route('article.show', [$artikel->id , $artikel->article_seo]) }}"> 
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img 
                                src="{{asset('storage/'.$artikel->thumbnail_path)}}" 
                                class="card-img-top" alt="{{$artikel->thumbnail_name}}"
                            >
                        </div>
                        <div class="col-md-8">
                            <h4 class="card-title">{{$artikel->title}}</h4>
                            <p class="card-text">{{Str::limit($artikel->description, 250)}}</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach

    

    <div>{{$kumpulan_artikel->links()}}</div>
    <div><strong> Artikel : {{$jumlah_artikel}}</strong></div>
@endsection