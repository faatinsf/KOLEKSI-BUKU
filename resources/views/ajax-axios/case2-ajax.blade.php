@extends('layouts.main')

@section('content')

<div class="card">
<div class="card-body">

<h4>POS - AJAX</h4>

<div class="row mb-3">

<div class="col-md-3">
<label>Kode Barang</label>
<input type="text" id="kode" class="form-control">
</div>

<div class="col-md-3">
<label>Nama Barang</label>
<input type="text" id="nama" class="form-control" readonly>
</div>

<div class="col-md-2">
<label>Harga</label>
<input type="text" id="harga" class="form-control" readonly>
</div>

<div class="col-md-2">
<label>Jumlah</label>
<input type="number" id="jumlah" class="form-control" value="1">
</div>

<div class="col-md-2 d-flex align-items-end">
<button id="tambah" class="btn btn-success w-100" disabled>
<span id="spinnerTambah" class="spinner-border spinner-border-sm d-none"></span>
Tambahkan
</button>
</div>

</div>

<hr>

<table class="table table-bordered">

<thead>
<tr>
<th>Kode</th>
<th>Nama</th>
<th>Harga</th>
<th>Jumlah</th>
<th>Subtotal</th>
<th>Aksi</th>
</tr>
</thead>

<tbody id="tableTransaksi"></tbody>

</table>

<h4>Total : <span id="total">0</span></h4>

<button id="bayar" class="btn btn-primary">
<span id="spinnerBayar" class="spinner-border spinner-border-sm d-none"></span>
Bayar
</button>

</div>
</div>

@endsection


@section('scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

let items=[];

/* reset form setelah tambah */
function resetForm(){

$('#kode').val('')
$('#nama').val('')
$('#harga').val('')
$('#jumlah').val(1)

$('#tambah').prop('disabled',true)

}

/* jika kode diubah */
$('#kode').on('input',function(){

$('#nama').val('')
$('#harga').val('')
$('#jumlah').val(1)

$('#tambah').prop('disabled',true)

})

/* cari barang */
$('#kode').keypress(function(e){

if(e.which==13){

let kode=$(this).val()

$.get('/barang/'+kode,function(data){

if(data){

$('#nama').val(data.nama_barang)
$('#harga').val(data.harga)
$('#jumlah').val(1)

$('#tambah').prop('disabled',false)

}else{

Swal.fire("Error","Barang tidak ditemukan","error")

}

})

}

})

/* tambah barang */
$('#tambah').click(function(){

let spinner=$("#spinnerTambah")
spinner.removeClass("d-none")

setTimeout(function(){

let kode=$('#kode').val()
let nama=$('#nama').val()
let harga=parseInt($('#harga').val())
let jumlah=parseInt($('#jumlah').val())

let subtotal=harga*jumlah

let found=false

items.forEach(function(item){

if(item.kode==kode){

item.jumlah+=jumlah
item.subtotal=item.harga*item.jumlah
found=true

}

})

if(!found){

items.push({
kode:kode,
nama:nama,
harga:harga,
jumlah:jumlah,
subtotal:subtotal
})

}

renderTable()

spinner.addClass("d-none")

resetForm()

},300)

})

/* render tabel */

function renderTable(){

let html=''
let total=0

items.forEach(function(item,index){

total+=item.subtotal

html+=`
<tr>
<td>${item.kode}</td>
<td>${item.nama}</td>
<td>${item.harga}</td>
<td>
<input type="number" value="${item.jumlah}" onchange="ubahJumlah(${index},this.value)">
</td>
<td>${item.subtotal}</td>
<td>
<button class="btn btn-danger btn-sm" onclick="hapus(${index})">Hapus</button>
</td>
</tr>
`

})

$('#tableTransaksi').html(html)
$('#total').text(total)

}

/* ubah jumlah */

function ubahJumlah(index,val){

items[index].jumlah=parseInt(val)
items[index].subtotal=items[index].harga*val

renderTable()

}

/* hapus */

function hapus(index){

items.splice(index,1)

renderTable()

}

/* bayar */

$('#bayar').click(function(){

let spinner=$("#spinnerBayar")
spinner.removeClass("d-none")

let total=$('#total').text()

$.post('/transaksi/simpan',{

items:items,
total:total,
_token:'{{ csrf_token() }}'

},function(res){

spinner.addClass("d-none")

if(res.status){

Swal.fire("Berhasil","Transaksi berhasil disimpan","success")

items=[]

renderTable()

resetForm()

}

})

})

</script>

@endsection