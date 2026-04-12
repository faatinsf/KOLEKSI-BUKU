@extends('layoutss.main')

@section('content')

<div class="row">
<div class="col-md-10 grid-margin stretch-card">

<div class="card">
<div class="card-body">

<h4 class="card-title">Input Barang</h4>

<form id="formBarang">

<div class="form-group mb-3">
<input type="text" id="nama_barang" class="form-control" placeholder="Nama Barang" required>
</div>

<div class="form-group mb-3">
<input type="number" id="harga_barang" class="form-control" placeholder="Harga Barang" required>
</div>

<button type="button" id="btnSubmit" class="btn btn-primary">
Submit
</button>

</form>

<hr>

<div class="table-responsive">

<table class="table table-bordered table-hover" id="tabelBarang">

<thead>
<tr>
<th>ID Barang</th>
<th>Nama</th>
<th>Harga</th>
</tr>
</thead>

<tbody>
</tbody>

</table>

</div>

</div>
</div>
</div>
</div>

@endsection


@section('scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
.spinner{
width:16px;
height:16px;
border:3px solid #ccc;
border-top:3px solid black;
border-radius:50%;
display:inline-block;
animation:spin 1s linear infinite;
}

@keyframes spin{
0%{transform:rotate(0deg);}
100%{transform:rotate(360deg);}
}
</style>

<script>

$(document).ready(function(){

let idBarang = 1;


// SUBMIT BARANG
$("#btnSubmit").click(function(){

let form = document.getElementById("formBarang");

if(!form.checkValidity()){
form.reportValidity();
return;
}

// spinner loading
$("#btnSubmit").html('<span class="spinner"></span>');
$("#btnSubmit").prop("disabled", true);

setTimeout(function(){

let nama = $("#nama_barang").val();
let harga = $("#harga_barang").val();

let row = `
<tr>
<td>${idBarang}</td>
<td>${nama}</td>
<td>${harga}</td>
</tr>
`;

$("#tabelBarang tbody").append(row);

idBarang++;

$("#nama_barang").val("");
$("#harga_barang").val("");

$("#btnSubmit").html("Submit");
$("#btnSubmit").prop("disabled", false);

},800);

});

});

</script>

@endsection