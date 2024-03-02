@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column align-items-center">
        <br>
        <h1 class=" mb-6">Edit Artikel Iklan</h1>

        <img 
            id="thumbnail_cover"
            src="{{asset('storage/'.$artikel->thumbnail_path)}}" 
            class="card-img-top" alt="{{$artikel->thumbnail_name}}"
            style="max-height: 50vh; object-fit: cover; width: 100%;"
        >

        <br>

        <form action="{{route('article.update', $artikel->article_seo)}}" method="POST" class="container w-100" enctype="multipart/form-data">
            @csrf


            <div class="form-group row mb-4">
                <label for="thumbnail" class="col-sm-4 col-form-label">Thumbnail</label>
                <div class="col-sm-8">
                    <button type="button" id="edit-thumbnail-button" class="btn btn-primary" style="margin-bottom: 4px">Edit Thumbnail</button>
                    <button type="button" id="cancel-edit-thumbnail-button" class="btn btn-secondary" style="margin-bottom: 4px; display: none;">Cancel Edit Thumbnail</button>
                    <input type="file" class="form-control" id="thumbnail" name="thumbnail" style="display: none;">
                </div>
            </div>


            <div class="form-group row mb-4">
                <label for="title" class="col-md-4 col-form-label text-md-right">Judul</label>
                <div class="col-md-8">
                    <input id="title" 
                        type="text" class="form-control" name="title" 
                        required 
                        autocomplete="title" 
                        autofocus
                        value="{{$artikel->title}}"
                        >
                </div>
            </div>

            <div class="form-group row  mb-4">
                <label for="description" class="col-md-4 col-form-label text-md-right">Deskripsi</label>
                <div class="col-md-8">
                    <textarea id="description" class="form-control" 
                        name="description" required 
                        autocomplete="content" autofocus
                        >{{$artikel->description}}</textarea>
                </div>
            </div>

            <div class="form-group row  mb-4">
                <label for='price' class="col-md-4 col-form-label text-md-right">Harga</label>
                <div class="col-md-6">
                    <input 
                        id="price" 
                        type="number" 
                        class="form-control" 
                        name="price" 
                        required autocomplete="price" 
                        placeholder="contoh: 150000000"
                        value="{{$artikel->price}}"
                        autofocus>
                </div>
                <div class="col-md-2">
                    <input 
                        id="price_by" 
                        type="text" 
                        class="form-control" 
                        name="price_by" 
                        required autocomplete="price_by" 
                        placeholder="Satuan harga"
                        value="{{$artikel->price_by}}"
                        autofocus>
                </div>
            </div>

            <div class="form-group row  mb-4">
                <label for="category" class="col-md-4 col-form-label text-md-right">Kategori</label>
                <div class="col-md-8">
                    <select id="category" class="form-select" name="category" required>
                        <option value="Properti" {{ $artikel->category == 'Properti' ? 'selected' : '' }}>Properti</option>
                        <option value="Lainnya" {{ $artikel->category == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
            </div>

            <hr style="margin-top: 48px; margin-bottom: 48px">

            <h2>Informasi Lokasi</h2>

            <div class="form-group row  mb-4">
                <label for="address" class="col-md-4 col-form-label text-md-right">Alamat</label>
                <div class="col-md-8">
                    <textarea id="address" class="form-control" 
                        name="address" required 
                        autocomplete="address" autofocus
                        >{{$artikel->address}}</textarea>
                </div>
            </div>

            <div class="form-group row  mb-4">
                <label for="link_google_maps" class="col-md-4 col-form-label text-md-right">Link Google Maps</label>
                <div class="col-md-8">
                    <input id="link_google_maps" 
                        type="text" 
                        class="form-control" 
                        name="link_google_maps" 
                        autocomplete="link_google_maps" 
                        autofocus
                        value="{{$artikel->link_google_maps}}"
                        >
                </div>
            </div>

            <hr style="margin-top: 48px; margin-bottom: 48px">

            <h2>Informasi Kontak</h2>


            <div class="form-group row  mb-4">
                <label for="contact_name" class="col-md-4 col-form-label text-md-right">Nama Kontak</label>
                <div class="col-md-8">
                    <input id="contact_name" 
                    type="text" 
                    class="form-control" 
                    name="contact_name" 
                    required 
                    autocomplete="contact_name" 
                    autofocus
                    value="{{$artikel->contact_name}}"
                    >
                </div>
            </div>

            <div class="form-group row  mb-4">
                <label for="whatsapp_number" class="col-md-4 col-form-label text-md-right">Nomor Whatsapp</label>
                <div class="col-md-8">
                    <input id="whatsapp_number" 
                    type="text" 
                    class="form-control" 
                    name="whatsapp_number" 
                    required 
                    autocomplete="contact_number" 
                    autofocus
                    value="{{$artikel->whatsapp_number}}"
                    >
                </div>
            </div>

            <hr style="margin-top: 48px; margin-bottom: 48px">

            {{-- Photos --}}
            <div class="mt-3">

                <div class="row align-items-center">
                    <div class="col">
                        <label for="photos" class="form-label">
                            <h2>Media Foto</h2>
                        </label>
                    </div>
    
                    <a href="javascript:void(0);" id="tambah" onclick="addFileInput()" 
                        class="btn btn-secondary col-2">Tambah Foto</a>
                </div>
                

                <div class="d-flex flex-wrap" id="fileinput_wrapper">
                    <!-- File input goes here -->
                </div>

                
                <script type="text/javascript">
                    function addFileInput () {
                        var div = document.getElementById('fileinput_wrapper');
                        var divPhotos = document.getElementById('new_photos_wrapper');

                        var fileInput = document.createElement('input');
                        fileInput.type = 'file';
                        fileInput.name = 'photos[]';
                        fileInput.id = 'photos';
                        fileInput.className = 'form-control mb-3';
                        fileInput.style.marginBottom = '5px';
                        fileInput.onchange = function (event) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                var img = document.createElement('img');
                                img.src = e.target.result;
                                img.className = 'rounded-full img-thumbnail mx-auto d-block gallery_item';
                                img.width = 400;
                                divPhotos.appendChild(img);
                            }
                            reader.readAsDataURL(event.target.files[0]);
                        };
                        div.appendChild(fileInput);
                    };
                </script>
            </div>

            <div class="d-flex flex-wrap gallery_items" id="new_photos_wrapper">
                <!-- File input goes here -->
            </div>

            <div class="d-flex flex-wrap gallery_items">
                <script type="text/javascript">
                    function deleteImage(event, photo_id) {
                        event.preventDefault();
                        var confirmation = confirm('Do you want to delete this image?');
                        if (confirmation) {
                            var form = document.getElementById('deleteForm');
                            
                            form.action = "/artikel/"+{{$artikel->article_seo}}+"/edit/photos/"+ photo_id +"/delete"
                            form.submit();

                            var container = document.getElementById('gallery_item_'+id);
                            container.remove();
                        }
                    }
                </script>
                @foreach($artikel->photos as $photo)
                    @if ($photo->id == $thumbnail->id)
                        @continue
                    @endif

                    <div class="gallery_item m-2" id="gallery_item_{{$photo->id}}">
                        <img
                            class="rounded-full img-thumbnail mx-auto d-block"
                            src="{{ asset('storage/'.$photo->path) }}"
                            alt="{{$photo->filename}}"
                            width="400"
                            />

                        <a class="btn btn-danger w-100" href="javascript:void(0);" onclick="deleteImage(event, {{$photo->id}})">Hapus</a>
                            

                    </div>
                @endforeach
            </div>

            <br>
            <div class="row justify-content-center">
                <a href="/buku" class="col-sm-2  btn btn-danger">Batal</a>
                <div class="col-sm-1"></div>
                <button type="submit" class="col-sm-2  btn btn-success">Simpan</button>
            </div>

            @if (count($errors) > 0)
                <br>
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            @endif

        </form>
    </div>

    <form id="deleteForm" action="" method="post" style="display:none">
        @csrf
    </form>

    <script>
        document.getElementById('edit-thumbnail-button').addEventListener('click', function() {
            document.getElementById('thumbnail').style.display = 'block';
            document.getElementById('cancel-edit-thumbnail-button').style.display = 'block';
            this.style.display = 'none';
        });
    
        document.getElementById('cancel-edit-thumbnail-button').addEventListener('click', function() {
            document.getElementById('thumbnail').style.display = 'none';
            document.getElementById('edit-thumbnail-button').style.display = 'block';
            this.style.display = 'none';
        });
    </script>

@endsection