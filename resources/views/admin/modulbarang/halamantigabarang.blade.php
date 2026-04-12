@extends('layoutss.main')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="row">

<!-- CARD 1 SELECT -->
<div class="col-md-6">
<div class="card">

<div class="card-header">
<h4>Select</h4>
</div>

<div class="card-body">

<div class="row mb-3">
<div class="col-md-3">
<label>Kota:</label>
</div>

<div class="col-md-6">
<input type="text" id="inputKota1" class="form-control">
</div>

<div class="col-md-3">
<button type="button" class="btn btn-success" id="tambahKota1">
Tambahkan
</button>
</div>
</div>


<div class="row mb-3">
<div class="col-md-3">
<label>Select Kota:</label>
</div>

<div class="col-md-9">
<select id="selectKota1" class="form-control"></select>
</div>
</div>


<div class="row">
<div class="col-md-3">
<label>Kota Terpilih:</label>
</div>

<div class="col-md-9">
<p id="hasilKota1"></p>
</div>
</div>

</div>
</div>
</div>



<!-- CARD 2 SELECT2 -->
<div class="col-md-6">
<div class="card">

<div class="card-header">
<h4>Select2</h4>
</div>

<div class="card-body">

<div class="row mb-3">
<div class="col-md-3">
<label>Kota:</label>
</div>

<div class="col-md-6">
<input type="text" id="inputKota2" class="form-control">
</div>

<div class="col-md-3">
<button type="button" class="btn btn-success" id="tambahKota2">
Tambahkan
</button>
</div>
</div>


<div class="row mb-3">
<div class="col-md-3">
<label>Select Kota:</label>
</div>

<div class="col-md-9">
<select id="selectKota2" class="form-control"></select>
</div>
</div>


<div class="row">
<div class="col-md-3">
<label>Kota Terpilih:</label>
</div>

<div class="col-md-9">
<p id="hasilKota2"></p>
</div>
</div>

</div>
</div>
</div>

</div>


@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

$(document).ready(function(){

// aktifkan select2
$('#selectKota2').select2();


// CARD 1
$("#tambahKota1").click(function(){

let kota = $("#inputKota1").val().trim();

if(kota !== ""){

$("#selectKota1").append(
'<option value="'+kota+'">'+kota+'</option>'
);

$("#inputKota1").val("");

}

});


$("#selectKota1").change(function(){

let kota = $(this).val();
$("#hasilKota1").text(kota);

});




// CARD 2
$("#tambahKota2").click(function(){

let kota = $("#inputKota2").val().trim();

if(kota !== ""){

let option = new Option(kota, kota, false, false);

$('#selectKota2').append(option).trigger('change');

$("#inputKota2").val("");

}

});


$("#selectKota2").change(function(){

let kota = $(this).val();
$("#hasilKota2").text(kota);

});

});

</script>

@endsection

@endsection


