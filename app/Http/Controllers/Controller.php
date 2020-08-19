<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Page;
use App\Reference;
use Carbon\Carbon as Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function sendMessageBot($file, $method, $error)
    {
        $token = '1371182992:AAE6lCiO1W6GCy0NZLCqOHDorSqW2aNpVGg';
        $chatID = '-390857187';
        $data = [
            'text' => '#WebApp by Adi Gunawan File:'.$file.' -- Function:'.$method.' -- Message: '.$error,
            'chat_id' => $chatID,
            'parse_mode' => 'HTML',
        ];
        $url = "https://api.telegram.org/bot".$token."/sendMessage";
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data)
        ]);
        $res = curl_exec($ch);
        curl_close($ch);
    }

    public function getPage($kode) {
        return Page::where('page_code', $kode)->first();
    }

    public function storeTrue()
    {
        $response = [
            'status' => true,
            'data' => 'tambah data berhasil'
        ];
        
        return $response;
    }

    public function storeFalse()
    {
        $response = [
            'status' => false,
            'data' => 'tambah data gagal'
        ];
        
        return $response;
    }

    public function updateTrue()
    {
        $response = [
            'status' => true,
            'data' => 'edit data berhasil'
        ];
        
        return $response;
    }

    public function updateFalse()
    {
        $response = [
            'status' => false,
            'data' => 'edit data gagal'
        ];
        
        return $response;
    }

    public function destroyTrue()
    {
        $response = [
            'status' => true,
            'data' => 'hapus data berhasil'
        ];
        
        return $response;
    }

    public function destroyFalse()
    {
        $response = [
            'status' => false,
            'data' => 'hapus data gagal'
        ];
        
        return $response;
    }

    public function dataNotFound()
    {
        $response = [
            'status' => false,
            'data' => 'data tidak ditemukan'
        ];
        return $response;
    }

    public function formatCurrencyIDR($val)
    {
        return number_format($val, 0, ',', '.');
    }

    public function reference(String $code = null)
    {
        $data = Reference::where('code', $code)->first();
        if ($data) {
            $data = $data->toArray();
            return $data['value'];
        } else {
            return '';   
        }
    }
}
