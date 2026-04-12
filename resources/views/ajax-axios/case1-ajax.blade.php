@extends('layouts.main')

@section('content')

<div class="row">
<div class="col-md-6 grid-margin stretch-card">

<div class="card">
<div class="card-body">

<h4 class="card-title">Pilih Wilayah Indonesia</h4>

<div class="form-group mb-3">
<label>Provinsi</label>
<select id="provinsi" class="form-control">
<option value="">Pilih Provinsi</option>
</select>
</div>

<div class="form-group mb-3">
<label>Kota / Kabupaten</label>
<select id="kota" class="form-control">
<option value="">Pilih Kota</option>
</select>
</div>

<div class="form-group mb-3">
<label>Kecamatan</label>
<select id="kecamatan" class="form-control">
<option value="">Pilih Kecamatan</option>
</select>
</div>

<div class="form-group mb-3">
<label>Kelurahan</label>
<select id="kelurahan" class="form-control">
<option value="">Pilih Kelurahan</option>
</select>
</div>

</div>
</div>

</div>
</div>

@endsection


@section('scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

$(document).ready(function(){

    loadProvinsi();

});


function loadProvinsi(){

    $.ajax({

        url:'/wilayah/provinsi',
        type:'GET',

        success:function(data){

            $('#provinsi').html('<option value="">Pilih Provinsi</option>');

            data.forEach(function(item){

                $('#provinsi').append(
                `<option value="${item.id}">${item.name}</option>`
                );

            });

        }

    });

}



$('#provinsi').change(function(){

    let id=$(this).val();

    $('#kota').html('<option value="">Pilih Kota</option>');
    $('#kecamatan').html('<option value="">Pilih Kecamatan</option>');
    $('#kelurahan').html('<option value="">Pilih Kelurahan</option>');

    if(id!=''){

        $.get('/wilayah/kota/'+id,function(data){

            data.forEach(function(item){

                $('#kota').append(
                `<option value="${item.id}">${item.name}</option>`
                );

            });

        });

    }

});


$('#kota').change(function(){

    let id=$(this).val();

    $('#kecamatan').html('<option value="">Pilih Kecamatan</option>');
    $('#kelurahan').html('<option value="">Pilih Kelurahan</option>');

    if(id!=''){

        $.get('/wilayah/kecamatan/'+id,function(data){

            data.forEach(function(item){

                $('#kecamatan').append(
                `<option value="${item.id}">${item.name}</option>`
                );

            });

        });

    }

});


$('#kecamatan').change(function(){

    let id=$(this).val();

    $('#kelurahan').html('<option value="">Pilih Kelurahan</option>');

    if(id!=''){

        $.get('/wilayah/kelurahan/'+id,function(data){

            data.forEach(function(item){

                $('#kelurahan').append(
                `<option value="${item.id}">${item.name}</option>`
                );

            });

        });

    }

});

</script>

@endsection