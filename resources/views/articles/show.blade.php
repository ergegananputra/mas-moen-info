@extends('layouts.app')

@section('content')

    <h1 class=" mb-6">{{$artikel->title}}</h1>

    <img src="{{asset('storage/'.$artikel->thumbnail_path)}}" 
        alt="{{$artikel->thumbnail_name}}" 
        class="img-fluid"
        >

    <div class="d-flex flex-column">

        <h4>Deskripsi</h4>
        <p>{{$artikel->description}}</p>

        <h4>Harga</h4>
        <p>Rp{{number_format($artikel->price, 2, ',', '.')}}</p>

        <h4>Kontak Info</h4>
        <p>{{$artikel->contact_name}}</p>

        <p>{{$artikel->whatsapp_number}}</p>

        <a aria-label="Chat on WhatsApp" href="https://wa.me/{{$artikel->whatsapp_number}}"> 
            <img 
                alt="Chat on WhatsApp" 
                src="{{ asset('storage/images/WhatsAppButtonGreenLarge.svg') }}" 
                width="150"
                />
        </a>

        <br>

        <h4>Lokasi</h4>
        <iframe 
            src="{{$artikel->link_google_maps}}" 
            width="max" 
            height="450" 
            style="border:0;" 
            allowfullscreen="true" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">

        </iframe>

    </div>



@endsection