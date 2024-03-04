@extends('layouts.app')

@section('content')
    <br>
    <div class="row d-flex justify-content-between align-items-center my-8">
        <div class="col">
            <h1>{{$artikel->title}}</h1>
        </div>
        @if (Auth::user() != null && Auth::user()->role == "role_admin")
            <div class="col d-flex justify-content-end">

                <a 
                    class="btn btn-danger mx-4 p-2 
                    d-flex align-items-center justify-content-center"
                    onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this article?')) { document.getElementById('delete-form').submit(); }">
                    <span class="material-symbols-outlined">
                        delete
                    </span>
                </a>
                
                <form id="delete-form" action="{{route('article.destroy', $artikel->id)}}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>

                <a href="{{route('article.edit', $artikel->article_seo)}}" 
                    class="btn btn-primary p-2
                    d-flex align-items-center justify-content-center">
                    <span class="material-symbols-outlined">
                        edit
                    </span>
                </a>
                
            </div>
            
        @endif
    </div>

    <span 
        class="badge bg-secondary my-2"
        style="font-size: 1em; padding: 10px;"
        > {{$artikel->category}} </span>
    
    <div id="carouselPreview" class="carousel slide">
        <div class="carousel-indicators">
            @foreach($artikel->photos as $index => $photo)
                <button 
                    type="button" 
                    data-bs-target="#carouselPreview" 
                    data-bs-slide-to="{{ $index }}" 
                    class="{{ $index == 0 ? 'active' : '' }}" 
                    aria-current="true" 
                    aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach($artikel->photos as $index => $photo)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <a href="{{ asset('storage/'.$photo->path) }}" 
                        data-lightbox="image-1" 
                        data-title="{{ $photo->filename }}">
                        <img src="{{ asset('storage/'.$photo->path) }}" 
                            class="d-block w-100 carousel-image" 
                            alt="{{ $photo->filename }}">
                    </a>
                </div>
            @endforeach
        </div>

        <style>
            .carousel-image {
                max-height: 50vh;
                object-fit: cover;
            }
        </style>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselPreview" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselPreview" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        </div>

        <br>
        <br>
    <div class="d-flex flex-column">

        <h2>Deskripsi</h2>

        <p>{!! nl2br(e($artikel->description)) !!}</p>


        <div class="row d-flex">

            <div class="col d-flex">
                <div class="card flex-grow-1 px-4 py-8 my-4">
                    <div class="card-body">
                        <h2>Kontak Info</h2>
                        <p><small>Klik icon WhatsApp untuk menghubungi</small> <strong>{{$artikel->contact_name}}</strong></p>
                        <a aria-label="Chat on WhatsApp" target="_blank" href="https://wa.me/{{$artikel->whatsapp_number}}"> 
                            <img 
                                alt="Chat on WhatsApp" 
                                src="{{ asset('storage/images/WhatsAppButtonGreenLarge.svg') }}" 
                                style="
                                    width: 100%; 
                                    max-width: 300px;
                                    height: auto; 
                                    object-fit: contain;
                                    "
                            />
                        </a>
                    </div>
                </div>
            </div>
        
            <div class="col d-flex">
                <div class="card flex-grow-1 bg-secondary text-white px-4 py-8 my-4">
                    <div class="card-body">
                        <h2>Harga</h2>
                        <p style="font-size: 32px; font-weight: 700">Rp{{number_format($artikel->price, 2, ',', '.')}}</p>
                        <p class="text-end">{{$artikel->price_by}}</p>
                    </div>
                </div>
            </div>
        
        </div>

        <br>
        
        @if($artikel->address != null)
            <h2>Lokasi</h2>

            <p>{{$artikel->address}}</p>

            @if($artikel->link_google_maps)
                <a href="{{$artikel->link_google_maps}}" 
                    class="btn btn-primary"
                    target="_blank">Buka di Google Maps</a>
                    <br>
            @endif

            @if($artikel->embed_gmaps_link != null)
                <iframe 
                    src="{{$artikel->embed_gmaps_link}}" 
                    width="max" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="true" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">

                </iframe>
            @endif
        
        @endif
        

    </div>


    
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox-plus-jquery.min.js"></script>
    @endpush

@endsection