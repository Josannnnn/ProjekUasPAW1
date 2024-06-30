<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(){
        $data['barang'] = Barang::get();
        return view('pages.barang', $data);
    }

    public function insert(){
        $barang = new Barang;
        $barang->nama = $_POST['nama'];
        $barang->satuan = $_POST['satuan'];
        $barang->stok = $_POST['stok'];
        $barang->exp = $_POST['exp'];
        $barang->save();

        return redirect('barang');
    }

    public function edit($id){
        $barang = Barang::find($id);
        $barang->nama = $_POST['nama'];
        $barang->satuan = $_POST['satuan'];
        $barang->stok = $_POST['stok'];
        $barang->exp = $_POST['exp'];
        $barang->save();

        return redirect('barang');
    }
    
    public function delete($id){
        $barang = Barang::find($id);
        $barang->delete();

        return redirect('barang');
    }
}
