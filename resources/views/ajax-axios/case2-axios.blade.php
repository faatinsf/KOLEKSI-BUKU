@extends('layouts.main')

@section('content')

<div class="card">
<div class="card-body">

<h4>POS - AXIOS</h4>

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

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

let items=[]

/* reset form */

function resetForm(){

document.getElementById('kode').value=''
document.getElementById('nama').value=''
document.getElementById('harga').value=''
document.getElementById('jumlah').value=1

document.getElementById('tambah').disabled=true

}

/* jika kode diubah */

document.getElementById('kode').addEventListener('input',function(){

document.getElementById('nama').value=''
document.getElementById('harga').value=''
document.getElementById('jumlah').value=1

document.getElementById('tambah').disabled=true

})

/* cari barang */

document.getElementById('kode').addEventListener('keypress',function(e){

if(e.key==="Enter"){

let kode=this.value

axios.get('/barang/'+kode)

.then(function(response){

let data=response.data

if(data){

document.getElementById('nama').value=data.nama_barang
document.getElementById('harga').value=data.harga
document.getElementById('jumlah').value=1

document.getElementById('tambah').disabled=false

}else{

Swal.fire("Error","Barang tidak ditemukan","error")

}

})

}

})

/* tambah barang */

document.getElementById('tambah').addEventListener('click',function(){

let spinner=document.getElementById('spinnerTambah')

spinner.classList.remove('d-none')

setTimeout(function(){

let kode=document.getElementById('kode').value
let nama=document.getElementById('nama').value
let harga=parseInt(document.getElementById('harga').value)
let jumlah=parseInt(document.getElementById('jumlah').value)

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

spinner.classList.add('d-none')

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

document.getElementById('tableTransaksi').innerHTML=html
document.getElementById('total').innerText=total

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

document.getElementById('bayar').addEventListener('click',function(){

if(items.length==0){

Swal.fire("Warning","Belum ada barang","warning")
return

}

let spinner=document.getElementById('spinnerBayar')

spinner.classList.remove('d-none')

let total=document.getElementById('total').innerText

axios.post('/transaksi/simpan',{

items:items,
total:total

})

.then(function(response){

spinner.classList.add('d-none')

if(response.data.status){

Swal.fire("Berhasil","Transaksi berhasil disimpan","success")

items=[]

renderTable()

resetForm()

}

})

})

</script>

@endsection