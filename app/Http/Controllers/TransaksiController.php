<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(){
        $data['transaksi'] = Transaksi::get();
        $data['barang'] = Barang::get();
        return view('pages.transaksi', $data);
    }

    public function insert(){
        $transaksi = new Transaksi;
        $transaksi->id_barang = $_POST['barang'];
        $transaksi->tanggal = $_POST['tanggal'];
        $transaksi->jumlah = $_POST['jumlah'];
        $transaksi->status = $_POST['status'];
        $transaksi->save();

        if($_POST['status'] == 'masuk'){
            $barang = Barang::find($_POST['barang']);
            $barang->stok = $barang->stok + $_POST['jumlah'];
            $barang->save();
        } elseif($_POST['status'] == 'keluar'){
            $barang = Barang::find($_POST['barang']);
            $barang->stok = $barang->stok - $_POST['jumlah'];
            $barang->save();
        }

        return redirect('transaksi');
    }

    public function edit($id){
        $transaksi = Transaksi::find($id);
        $transaksi->id_barang = $_POST['barang'];
        $transaksi->tanggal = $_POST['tanggal'];
        $transaksi->jumlah = $_POST['jumlah'];
        $transaksi->status = $_POST['status'];
        $transaksi->save();
        
        $transaksi = Transaksi::find($id);
        if($transaksi->status == 'masuk'){
            $barang = Barang::find($transaksi->id_barang);
            $barang->stok = $barang->stok - $transaksi->jumlah;
            $barang->save();
        } elseif($transaksi->status == 'keluar'){
            $barang = Barang::find($transaksi->id_barang);
            $barang->stok = $barang->stok + $transaksi->jumlah;
            $barang->save();
        }

        return redirect('transaksi');
    }
    
    public function delete($id){
        $transaksi = Transaksi::find($id);
        if($transaksi->status == 'masuk'){
            $barang = Barang::find($transaksi->id_barang);
            $barang->stok = $barang->stok - $transaksi->jumlah;
            $barang->save();
        } elseif($transaksi->status == 'keluar'){
            $barang = Barang::find($transaksi->id_barang);
            $barang->stok = $barang->stok + $transaksi->jumlah;
            $barang->save();
        }
        $transaksi->delete();

        return redirect('transaksi');
    }
}
