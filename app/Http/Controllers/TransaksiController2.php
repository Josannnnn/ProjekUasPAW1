<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi2;
use Illuminate\Http\Request;

class TransaksiController2 extends Controller
{
    public function index(){
        $data['transaksi2'] = Transaksi2::get();
        $data['barang'] = Barang::get();
        return view('pages.transaksi2', $data);
    }

    public function insert(){
        $transaksi2 = new Transaksi2;
        $transaksi2->id_barang = $_POST['barang'];
        $transaksi2->tanggal = $_POST['tanggal'];
        $transaksi2->jumlah = $_POST['jumlah'];
        $transaksi2->status = $_POST['status'];
        $transaksi2->save();

        if($_POST['status'] == 'masuk'){
            $barang = Barang::find($_POST['barang']);
            $barang->stok = $barang->stok + $_POST['jumlah'];
            $barang->save();
        } elseif($_POST['status'] == 'keluar'){
            $barang = Barang::find($_POST['barang']);
            $barang->stok = $barang->stok - $_POST['jumlah'];
            $barang->save();
        }

        return redirect('transaksi2');
    }

    public function edit($id){
        $transaksi2 = Transaksi2::find($id);
        $transaksi2->id_barang = $_POST['barang'];
        $transaksi2->tanggal = $_POST['tanggal'];
        $transaksi2->jumlah = $_POST['jumlah'];
        $transaksi2->status = $_POST['status'];
        $transaksi2->save();
        $transaksi2 = Transaksi2::find($id);
        if($transaksi2->status == 'masuk'){
            $barang = Barang::find($transaksi2->id_barang);
            $barang->stok = $barang->stok - $transaksi2->jumlah;
            $barang->save();
        } elseif($transaksi2->status == 'keluar'){
            $barang = Barang::find($transaksi2->id_barang);
            $barang->stok = $barang->stok + $transaksi2->jumlah;
            $barang->save();
        }
        return redirect('transaksi2');
    }
    
    public function delete($id){
        $transaksi2 = Transaksi2::find($id);
        if($transaksi2->status == 'masuk'){
            $barang = Barang::find($transaksi2->id_barang);
            $barang->stok = $barang->stok - $transaksi2->jumlah;
            $barang->save();
        } elseif($transaksi2->status == 'keluar'){
            $barang = Barang::find($transaksi2->id_barang);
            $barang->stok = $barang->stok + $transaksi2->jumlah;
            $barang->save();
        }
        $transaksi2->delete();

        return redirect('transaksi2');
    }
}
