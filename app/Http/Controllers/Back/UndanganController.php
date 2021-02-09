<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Users; // Model V1
//use App\User; //Model V2

use App\Models\Userinfo;
use App\Models\Undanganinfo;
use App\Models\Story;
use App\Models\Galeri;

use JWTAuth;


class UndanganController extends Controller
{


    public function index()
    {

        $results = Users::orderBy('id', 'DESC')->get(['id', 'nama', 'email']);


        return response()->json($results);
    }

    public function undanganData()
    {
        $results = Users::join('tb_info_user', 'tb_user.id_user', '=', 'tb_info_user.id_user')
            ->join('tb_info_undangan', 'tb_user.id_user', '=', 'tb_info_undangan.id_user')
            ->join('tb_story', 'tb_user.id_user', '=', 'tb_story.id_user')
            ->where('tb_info_user.id_user', '=', JWTAuth::user()->id)
            ->get([
                //'tb_user.id_user',
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

    public function mapdata()
    {
        $results = Users::join('tb_info_undangan', 'tb_user.id_user', '=', 'tb_info_undangan.id_user')
            ->where('tb_info_undangan.id_user', '=', JWTAuth::user()->id)
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

    public function galeridata()
    {
        $results = Users::join('tb_galeri', 'tb_user.id_user', '=', 'tb_galeri.id_user')
            ->where('tb_galeri.id_user', '=', JWTAuth::user()->id)
            ->get([
                'tb_galeri.id',
                'tb_galeri.judul_img',
                'tb_galeri.img',
                'tb_galeri.deskripsi',
                //'tb_galeri.id_user',
            ]); //filter by ID


        $data = array('listgaleri' => $results);
        return response()->json($data);
        //return response($results);
    }

    public function updateHome(Request $request)
    {

        //$res = Users::where('token', '=', $kodeToken)->first();

        $ids = JWTAuth::user()->id;

        $namap_pria = $request->input('namap_pria');
        $namap_wanita = $request->input('namap_wanita');
        $tanggal_akad = $request->input('tanggal_akad');

        Userinfo::where('id_user', $ids)
            ->update([
                'namap_pria' => $namap_pria,
                'namap_wanita' => $namap_wanita,
            ]);

        Undanganinfo::where('id_user', $ids)
            ->update([
                'tanggal_akad' => $tanggal_akad,
            ]);


        $data = ['msg' => 'sukses telah diupdate.'];

        return response()->json($data);
    }

    public function updateUndangan(Request $request)
    {

        //$res = Users::where('token', '=', $kodeToken)->first();

        $ids = JWTAuth::user()->id;

        $nama_pria = $request->input('nama_pria');
        $nama_wanita = $request->input('nama_wanita');
        $ke_pria = $request->input('ke_pria');
        $ke_wanita = $request->input('ke_wanita');
        $ayah_pria = $request->input('ayah_pria');
        $ayah_wanita = $request->input('ayah_wanita');
        $ibu_pria = $request->input('ibu_pria');
        $ibu_wanita = $request->input('ibu_wanita');


        Userinfo::where('id_user', $ids)
            ->update([
                'nama_pria' => $nama_pria,
                'nama_wanita' => $nama_wanita,
                'ke_pria' => $ke_pria,
                'ke_wanita' => $ke_wanita,
                'ayah_pria' => $ayah_pria,
                'ayah_wanita' => $ayah_wanita,
                'ibu_pria' => $ibu_pria,
                'ibu_wanita' => $ibu_wanita,
            ]);



        $data = ['msg' => 'sukses telah diupdate.'];

        return response()->json($data);
    }

    public function updateLokasi(Request $request)
    {

        //$res = Users::where('token', '=', $kodeToken)->first();

        $ids = JWTAuth::user()->id;

        $tanggal_akad = $request->input('tanggal_akad');
        $tanggal_resepsi = $request->input('tanggal_resepsi');
        $lokasi_akad = $request->input('lokasi_akad');
        $lokasi_resepsi = $request->input('lokasi_resepsi');
        $jam_akad = $request->input('jam_akad');
        $jam_resepsi = $request->input('jam_resepsi');


        Undanganinfo::where('id_user', $ids)
            ->update([
                'tanggal_akad' => $tanggal_akad,
                'tanggal_resepsi' => $tanggal_resepsi,
                'lokasi_akad' => $lokasi_akad,
                'lokasi_resepsi' => $lokasi_resepsi,
                'jam_akad' => $jam_akad,
                'jam_resepsi' => $jam_resepsi,
            ]);



        $data = ['msg' => 'sukses telah diupdate.'];

        return response()->json($data);
    }

    public function updateMap(Request $request)
    {

        //$res = Users::where('token', '=', $kodeToken)->first();

        $ids = JWTAuth::user()->id;

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');


        Undanganinfo::where('id_user', $ids)
            ->update([
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]);

        $data = ['msg' => 'sukses telah diupdate.'];

        return response()->json($data);
    }

    public function updateSocmed(Request $request)
    {

        //$res = Users::where('token', '=', $kodeToken)->first();

        $ids = JWTAuth::user()->id;

        $twit_pria = $request->input('twit_pria');
        $twit_wanita = $request->input('twit_wanita');
        $fb_pria = $request->input('fb_pria');
        $fb_wanita = $request->input('fb_wanita');
        $ig_pria = $request->input('ig_pria');
        $ig_wanita = $request->input('ig_wanita');


        Userinfo::where('id_user', $ids)
            ->update([
                'twit_pria' => $twit_pria,
                'twit_wanita' => $twit_wanita,
                'fb_pria' => $fb_pria,
                'fb_wanita' => $fb_wanita,
                'ig_pria' => $ig_pria,
                'ig_wanita' => $ig_wanita,
            ]);

        $data = ['msg' => 'sukses telah diupdate.'];

        return response()->json($data);
    }

    public function updateStory(Request $request)
    {

        //$res = Users::where('token', '=', $kodeToken)->first();

        $ids = $ids = JWTAuth::user()->id;

        $judul1 = $request->input('judul1');
        $judul2 = $request->input('judul2');
        $judul3 = $request->input('judul3');
        $tanggal1 = $request->input('tanggal1');
        $tanggal2 = $request->input('tanggal2');
        $tanggal3 = $request->input('tanggal3');
        $story1 = $request->input('story1');
        $story2 = $request->input('story2');
        $story3 = $request->input('story3');


        Story::where('id_user', $ids)
            ->update([
                'judul1' => $judul1,
                'judul2' => $judul2,
                'judul3' => $judul3,
                'tanggal1' => $tanggal1,
                'tanggal2' => $tanggal2,
                'tanggal3' => $tanggal3,
                'story1' => $story1,
                'story2' => $story2,
                'story3' => $story3,
            ]);

        $data = ['msg' => 'sukses telah diupdate.'];

        return response()->json($data);
    }

    public function postImageMan(Request $request)
    {
        $this->validate($request, [
            'img' => 'required|file|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        //$res = Users::where('token', '=', $kodeToken)->first();

        $ids = JWTAuth::user()->id;

        $img = Userinfo::where('id_user', $ids)->first();
        $imgx = $img->foto_pria;

        if ($imgx) {
            unlink("D:/data-php/kantor/ayomerariq/assets/image_file/$imgx");
        }

        $file = $request->file('img');

        $nama_file = time() . "_" . $file->getClientOriginalName();

        // isi dengan nama folder tempat kemana file diupload 
        // $_SERVER['DOCUMENT_ROOT'] . "/kantor/demo/" . $top['img_product']; //file path jika di satu server
        $tujuan_upload = 'D:\data-php\kantor\ayomerariq\assets\image_file';
        $file->move($tujuan_upload, $nama_file);

        Userinfo::where('id_user', $ids)
            ->update([
                'foto_pria' => $nama_file,
            ]);

        $data = ['msg' => 'sukses telah diupdate.'];

        return response()->json($data);
    }

    public function postImageWoman(Request $request)
    {

        $this->validate($request, [
            'img' => 'required|file|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        //$res = Users::where('token', '=', $kodeToken)->first();

        $ids = JWTAuth::user()->id;

        $img = Userinfo::where('id_user', $ids)->first();
        $imgx = $img->foto_wanita;

        if ($imgx) {
            unlink("D:/data-php/kantor/ayomerariq/assets/image_file/$imgx");
        }

        $file = $request->file('img');

        $nama_file = time() . "_" . $file->getClientOriginalName();

        // isi dengan nama folder tempat kemana file diupload 
        // $_SERVER['DOCUMENT_ROOT'] . "/kantor/demo/" . $top['img_product']; //file path jika di satu server
        $tujuan_upload = 'D:\data-php\kantor\ayomerariq\assets\image_file';
        $file->move($tujuan_upload, $nama_file);

        Userinfo::where('id_user', $ids)
            ->update([
                'foto_wanita' => $nama_file,
            ]);

        $data = ['msg' => 'sukses telah diupdate.'];

        return response()->json($data);
    }

    public function postGaleri(Request $request)
    {

        $this->validate($request, [
            'img' => 'required|file|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        //$res = Users::where('token', '=', $kodeToken)->first();

        $ids = JWTAuth::user()->id;

        $file = $request->file('img');

        $nama_file = 'Gal_' . time() . '_' . $ids . '_' . $file->getClientOriginalName();

        // isi dengan nama folder tempat kemana file diupload 
        // $_SERVER['DOCUMENT_ROOT'] . "/kantor/demo/" . $top['img_product']; //file path jika di satu server
        $tujuan_upload = 'D:\data-php\kantor\ayomerariq\assets\galeri';
        $file->move($tujuan_upload, $nama_file);

        Galeri::create([
            'id_user' => $ids,
            'img' => $nama_file,
            'judul_img' => $nama_file,
            'deskripsi' => 'Prewedding_Galery_' . $nama_file,
        ]);

        $data = ['msg' => 'sukses telah diupdate.'];

        return response()->json($data);
    }

    public function deletegaleri($id)
    {
        $img = Galeri::where('id', $id)->first();
        $imgx = $img->img;

        $result = Galeri::where('id', $id)->delete();
        if ($result) {

            unlink("D:/data-php/kantor/ayomerariq/assets/galeri/$imgx");

            $data = ['msg' => 'berhasil'];

            return response()->json($data);
        } else {

            $data = ['msg' => 'gagal'];

            return response()->json($data);
        }
    }
}
