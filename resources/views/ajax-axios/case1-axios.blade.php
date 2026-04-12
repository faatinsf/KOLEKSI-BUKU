@extends('layouts.main')

@section('content')

<div class="row">
<div class="col-md-6 grid-margin stretch-card">

<div class="card">
<div class="card-body">

<h4 class="card-title">Pilih Wilayah Indonesia (Axios)</h4>

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

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function(){

loadProvinsi();

});


function loadProvinsi(){

axios.get('/wilayah/provinsi')

.then(function(response){

let data = response.data;

let provinsi = document.getElementById("provinsi");

provinsi.innerHTML = '<option value="">Pilih Provinsi</option>';

data.forEach(function(item){

provinsi.innerHTML += `<option value="${item.id}">${item.name}</option>`;

});

})

.catch(function(error){

console.log(error);

});

}



document.getElementById("provinsi").addEventListener("change",function(){

let id=this.value;

document.getElementById("kota").innerHTML='<option value="">Pilih Kota</option>';
document.getElementById("kecamatan").innerHTML='<option value="">Pilih Kecamatan</option>';
document.getElementById("kelurahan").innerHTML='<option value="">Pilih Kelurahan</option>';

if(id!=""){

axios.get('/wilayah/kota/'+id)

.then(function(response){

let data=response.data;

data.forEach(function(item){

document.getElementById("kota").innerHTML +=
`<option value="${item.id}">${item.name}</option>`;

});

})

.catch(function(error){

console.log(error);

});

}

});



document.getElementById("kota").addEventListener("change",function(){

let id=this.value;

document.getElementById("kecamatan").innerHTML='<option value="">Pilih Kecamatan</option>';
document.getElementById("kelurahan").innerHTML='<option value="">Pilih Kelurahan</option>';

if(id!=""){

axios.get('/wilayah/kecamatan/'+id)

.then(function(response){

let data=response.data;

data.forEach(function(item){

document.getElementById("kecamatan").innerHTML +=
`<option value="${item.id}">${item.name}</option>`;

});

})

.catch(function(error){

console.log(error);

});

}

});



document.getElementById("kecamatan").addEventListener("change",function(){

let id=this.value;

document.getElementById("kelurahan").innerHTML='<option value="">Pilih Kelurahan</option>';

if(id!=""){

axios.get('/wilayah/kelurahan/'+id)

.then(function(response){

let data=response.data;

data.forEach(function(item){

document.getElementById("kelurahan").innerHTML +=
`<option value="${item.id}">${item.name}</option>`;

});

})

.catch(function(error){

console.log(error);

});

}

});

</script>

@endsection