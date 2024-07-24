<?php

namespace App\Http\Controllers;

use App\Models\T_Barang;
use App\Models\T_Beli;
use App\Models\T_Customers;
use App\Models\T_DBeli;
use App\Models\T_Jens;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PenjualanController extends Controller
{

    public function index()
    {
        // Session::flush();
        $lengthBeli = T_Beli::count() + 1;
        $nomorFaktur = 'TR' . str_pad($lengthBeli, 4, '0', STR_PAD_LEFT);
        $dataBarang = T_Barang::get();
        $currentDate =Carbon::now()->format("Y-m-d");
        $dataCustomers = T_Customers::get();
        $dataJenis = T_Jens::get();
        if (Session::has("detailBarang")) {
            // / Calculate the sum of bruto, diskon, and totalRp
            $sumBruto = 0;
            $sumDiskon = 0;
            $sumTotalRp = 0;

            foreach (Session::get("detailBarang") as $item) {
                $sumBruto += isset($item['bruto']) ? (float) str_replace(['Rp ', '.', ','], ['', '', '.'], $item['bruto'] * $item['qty']) : 0;
                $sumDiskon += isset($item['diskon']) ? (float) str_replace(['Rp ', '.', ','], ['', '', '.'], $item['diskon'] * $item['qty']) : 0;
                $sumTotalRp += isset($item['totalRp']) ? (float) str_replace(['Rp ', '.', ','], ['', '', '.'], $item['totalRp'] * $item['qty']) : 0;
            }


            // Optionally, you can save these sums in the session or use them as needed
            Session::put('sumBruto', $sumBruto);
            Session::put('sumDiskon', $sumDiskon);
            Session::put('sumTotalRp', $sumTotalRp);
        } else {
            // Optionally, you can save these sums in the session or use them as needed
            Session::put('sumBruto', 0);
            Session::put('sumDiskon', 0);
            Session::put('sumTotalRp', 0);
        }
        return view('welcome', compact('dataBarang', 'currentDate', 'dataCustomers', 'dataJenis', 'nomorFaktur'));
    }

    public function get_data_transaksi(){
        $data=DB::table("t_beli")->join("t_dbeli","t_beli.no_faktur","=","t_dbeli.no_faktur")->get();
        print_r($data);
    }

    public function add_data(Request $request)
    {
        try {
            $hasil = $request->all();
            unset($hasil["_token"]);
            $kodeBarang = $hasil['kodeBarang'];
            $results = [];
            if (Session::has("detailBarang")) {
                $res = Session::get("detailBarang");
                $check = false;
                foreach ($res as &$item) {
                    if ($item['kodeBarang'] === $kodeBarang) {
                        // Update the quantity and other fields as needed
                        $item['qty'] += $hasil['qty'];
                        $check = true;
                    }
                    $results[] = $item;
                }

                if (!$check) {
                    $results[] = $hasil;
                }
                Session::put("detailBarang", $results);
            } else {
                // Save the hasil array to the session
                Session::put('detailBarang', [$hasil]);
            }


            return "success";
        } catch (Exception $e) {
            return "error";
        }
    }

    public function remove_data(Request $request)
    {
        try {
            $hasil = $request->all();
            unset($hasil["_token"]);
            $kodeBarang = $hasil['kodeBarang'];
            $res = Session::get("detailBarang");
            $results = [];
            foreach ($res as $key => &$item) {
                if ($item['kodeBarang'] !== $kodeBarang) {
                    $results[] = $item;
                }
            }

            // Save the updated array back to the session
            Session::put("detailBarang", $results);


            return "success";
        } catch (Exception $e) {
            return "error";
        }
    }

    public function clear_data(Request $request)
    {
        try {
            Session::flush();

            return "success";
        } catch (Exception $e) {
            return "error";
        }
    }

    public function update_quantity(Request $request)
    {
        try {
            $hasil = $request->all();
            unset($hasil["_token"]);
            $kodeBarang = $hasil['kodeBarang'];
            if (Session::has("detailBarang")) {
                $res = Session::get("detailBarang");
                foreach ($res as &$item) {
                    if ($item['kodeBarang'] === $kodeBarang) {
                        // Update the quantity and other fields as needed
                        $item['qty'] = intval($hasil["quantity"]);
                        break;
                    }
                }
            }
            Session::put("detailBarang", $res);

            return "success";
        } catch (Exception $e) {
            return "error";
        }
    }
    public function save_data(Request $request)
    {
        try {
            $input = $request->all();
            $kode_customer = explode( ' - ',$input["customer"])[0];
            $jenisTransaksi = explode( ' - ',$input["jenisTransaksi"])[0];
            $nomorFaktur = $input["noFaktur"];
            $res = Session::get("detailBarang");
            $beli = new T_Beli();
            $beli->no_faktur = $nomorFaktur;
            $beli->kode_customer = $kode_customer;
            $beli->kode_tjen = $jenisTransaksi;
            $beli->tgl_faktur = $input["tanggal"];
            $beli->total_bruto = Session::get('sumBruto');
            $beli->total_diskon = Session::get('sumDiskon');
            $beli->total_jumlah = Session::get('sumTotalRp');
            $beli->save();
            foreach ($res as &$item) {
                $dbeli = new T_DBeli();
                $dbeli->no_faktur = $nomorFaktur;
                $dbeli->kode_barang = $item["kodeBarang"];
                $dbeli->harga = $item["hargaBarang"];
                $dbeli->qty = $item['qty'];
                $dbeli->diskon = $item['diskon'] * $item['qty'];
                $dbeli->bruto = $item['bruto'] * $item['qty'];
                $dbeli->jumlah = $item['totalRp'] * $item['qty'];
                $dbeli->save();
            }
            Session::flush();
            return 'success';
        } catch (Exception $e) {
            return "error " . $e;
        }
    }
}
