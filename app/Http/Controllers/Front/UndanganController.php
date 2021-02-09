<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Users; // Model V1
//use App\User; //Model V2


class UndanganController extends Controller
{

    public function index()
    {

        $results = Users::orderBy('id', 'DESC')->get(['id', 'nama', 'email']);


        return response()->json($results);
    }

    public function filterKode($kodeUndangan)
    {
        $results = Users::join('tb_info_user', 'tb_user.id_user', '=', 'tb_info_user.id_user')
            ->join('tb_info_undangan', 'tb_user.id_user', '=', 'tb_info_undangan.id_user')
            ->join('tb_story', 'tb_user.id_user', '=', 'tb_story.id_user')
            ->where('kode', '=', $kodeUndangan)
            ->get([
                'tb_user.id_user',
                'kode',
                'nama_user',
                'email',
                'template',
                'status',
                //info user pria
                'tb_info_user.nama_pria',
                'tb_info_user.namap_pria',
                'tb_info_user.ayah_pria',
                'tb_info_user.ibu_pria',
                'tb_info_user.ke_pria',
                'tb_info_user.foto_pria',
                'tb_info_user.twit_pria',
                'tb_info_user.fb_pria',
                'tb_info_user.ig_pria',
                //info user wanita
                'tb_info_user.nama_wanita',
                'tb_info_user.namap_wanita',
                'tb_info_user.ayah_wanita',
                'tb_info_user.ibu_wanita',
                'tb_info_user.ke_wanita',
                'tb_info_user.foto_wanita',
                'tb_info_user.twit_wanita',
                'tb_info_user.fb_wanita',
                'tb_info_user.ig_wanita',
                //info undangan akad
                'tb_info_undangan.hari_akad',
                'tb_info_undangan.tanggal_akad',
                'tb_info_undangan.jam_akad',
                'tb_info_undangan.hari_akad',
                'tb_info_undangan.lokasi_akad',
                //info undangan resepsi
                'tb_info_undangan.hari_resepsi',
                'tb_info_undangan.tanggal_resepsi',
                'tb_info_undangan.jam_resepsi',
                'tb_info_undangan.hari_resepsi',
                'tb_info_undangan.lokasi_resepsi',
                //map koordinat
                'tb_info_undangan.latitude',
                'tb_info_undangan.longitude',
                //story
                'tb_story.judul1',
                'tb_story.judul2',
                'tb_story.judul3',
                'tb_story.judul4',
                'tb_story.tanggal1',
                'tb_story.tanggal2',
                'tb_story.tanggal3',
                'tb_story.tanggal4',
                'tb_story.story1',
                'tb_story.story2',
                'tb_story.story3',
                'tb_story.story4',
            ])
            ->first(); //filter by ID

        return response($results);
    }

    public function mapdata($kodeUndangan)
    {
        $results = Users::join('tb_info_undangan', 'tb_user.id_user', '=', 'tb_info_undangan.id_user')
            ->where('kode', '=', $kodeUndangan)
            ->get([
                'tb_info_undangan.latitude',
                'tb_info_undangan.longitude',
            ])
            ->first(); //filter by ID

        $lat = $results->latitude;
        $lon = $results->longitude;

        $data = [$lat, $lon];
        return response()->json($data);
    }

    public function galeridata($kodeUndangan)
    {
        $results = Users::join('tb_galeri', 'tb_user.id_user', '=', 'tb_galeri.id_user')
            ->where('kode', '=', $kodeUndangan)
            ->get([
                'tb_galeri.id',
                'tb_galeri.judul_img',
                'tb_galeri.img',
                'tb_galeri.deskripsi',
                'tb_galeri.id_user',
            ]); //filter by ID


        $data = array('listgaleri' => $results);
        return response()->json($data);
        //return response($results);
    }
}
