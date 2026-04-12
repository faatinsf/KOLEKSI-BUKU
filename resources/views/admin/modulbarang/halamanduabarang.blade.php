@extends('layoutss.main')

@section('content')

<div class="row">
<div class="col-md-10 grid-margin stretch-card">

<div class="card">
<div class="card-body">

<h4 class="card-title">Data Barang (DataTables)</h4>

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

<tr>
<td>1</td>
<td>Keyboard</td>
<td>150000</td>
</tr>

<tr>
<td>2</td>
<td>Mouse</td>
<td>50000</td>
</tr>

</tbody>

</table>

</div>
</div>
</div>
</div>
</div>


<!-- MODAL -->
<div class="modal fade" id="modalBarang">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Edit Barang</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="mb-3">
<label>ID Barang</label>
<input type="text" id="modalId" class="form-control" readonly>
</div>

<div class="mb-3">
<label>Nama Barang</label>
<input type="text" id="modalNama" class="form-control" required>
</div>

<div class="mb-3">
<label>Harga Barang</label>
<input type="number" id="modalHarga" class="form-control" required>
</div>

</div>

<div class="modal-footer d-flex justify-content-between">

<button class="btn btn-danger" id="btnHapus">
Hapus
</button>

<button class="btn btn-success" id="btnUbah">
Ubah
</button>

</div>

</div>
</div>
</div>

@endsection


@section('scripts')

<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DATATABLES -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>

$(document).ready(function(){

// AKTIFKAN DATATABLES
let table = $('#tabelBarang').DataTable();

let selectedRow;


// hover pointer
$('#tabelBarang tbody').css("cursor","pointer");


// CLICK ROW -> MODAL
$('#tabelBarang tbody').on('click','tr',function(){

selectedRow = table.row(this);

let data = selectedRow.data();

$("#modalId").val(data[0]);
$("#modalNama").val(data[1]);
$("#modalHarga").val(data[2]);

$("#modalBarang").modal("show");

});


// UPDATE DATA
$("#btnUbah").click(function(){

let namaBaru = $("#modalNama").val();
let hargaBaru = $("#modalHarga").val();

if(namaBaru=="" || hargaBaru==""){
alert("Nama dan Harga wajib diisi!");
return;
}

selectedRow.data([
$("#modalId").val(),
namaBaru,
hargaBaru
]).draw(false);

$("#modalBarang").modal("hide");

});


// DELETE DATA
$("#btnHapus").click(function(){

selectedRow.remove().draw(false);

$("#modalBarang").modal("hide");

});

});

</script>

@endsection