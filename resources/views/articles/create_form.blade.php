@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column align-items-center">
        <h1 class=" mb-6">Tambah Artikel</h1>
        <form action="{{route('article.store')}}" method="POST" class="container w-100" enctype="multipart/form-data">
            @csrf
            <div class="form-group row mb-4">
                <label for="title" class="col-md-4 col-form-label text-md-right">Judul</label>
                <div class="col-md-6">
                    <input id="title" type="text" class="form-control" name="title" required autocomplete="title" autofocus>
                </div>
            </div>

            <div class="form-group row  mb-4">
                <label for="description" class="col-md-4 col-form-label text-md-right">Deskripsi</label>
                <div class="col-md-6">
                    <textarea id="description" class="form-control" name="description" required autocomplete="content" autofocus></textarea>
                </div>
            </div>

            <div class="form-group row  mb-4">
                <label for='price' class="col-md-4 col-form-label text-md-right">Harga</label>
                <div class="col-md-6">
                    <input id="price" type="number" class="form-control" name="price" required autocomplete="price" autofocus>
                </div>
            </div>

            <div class="form-group row  mb-4">
                <label for="thumbnail" class="col-sm-4 col-form-label">Thumbnail</label>
                <div class="col-sm-6">
                    <input type="file" class="form-control" id="thumbnail" name="thumbnail">
                </div>
            </div>


            <div class="form-group row  mb-4">
                <label for="contact_name" class="col-md-4 col-form-label text-md-right">Nama Kontak</label>
                <div class="col-md-6">
                    <input id="contact_name" type="text" class="form-control" name="contact_name" required autocomplete="contact_name" autofocus>
                </div>
            </div>

            <div class="form-group row  mb-4">
                <label for="whatsapp_number" class="col-md-4 col-form-label text-md-right">Nomor Whatsapp</label>
                <div class="col-md-6">
                    <input id="whatsapp_number" type="text" class="form-control" name="whatsapp_number" required autocomplete="contact_number" autofocus>
                </div>
            </div>

            <div class="form-group row  mb-4">
                <label for="link_google_maps" class="col-md-4 col-form-label text-md-right">Link Google Maps</label>
                <div class="col-md-6">
                    <input id="link_google_maps" type="text" class="form-control" name="link_google_maps" required autocomplete="link_google_maps" autofocus>
                </div>
            </div>

            {{-- Photos --}}
            <div class="mt-3">
                <label for="photos" class="form-label">Foto-foto</label>
                <div class="d-flex flex-wrap" id="fileinput_wrapper">
                    <!-- File input goes here -->
                </div>
                <a href="javascript:void(0);" id="tambah" onclick="addFileInput()" class="btn btn-primary">Tambah</a>
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

            <br>
            <div class="row justify-content-center">
                <a href="/buku" class="col-sm-2  btn btn-danger">Batal</a>
                <div class="col-sm-1"></div>
                <button type="submit" class="col-sm-2  btn btn-primary">Simpan</button>
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
@endsection