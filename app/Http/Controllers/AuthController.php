<?php

namespace App\Http\Controllers;

use App\Http\Resources\User as UserResource;
use Illuminate\Http\Request;
use App\Http\Requests\ValidateUserRegistration;
use App\Http\Requests\ValidateUserLogin;
use App\User;
use App\Models\Users as UserT;
use App\Models\Userinfo;
use App\Models\Undanganinfo;
use App\Models\Story;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function register(ValidateUserRegistration $request)
    {

        date_default_timezone_set("Asia/Jakarta");
        $tanggal = date("Y-m-d H:i:s");

        //generate simple random code 
        $set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = substr(str_shuffle($set), 0, 12);

        //generate kode user
        $query = UserT::orderBy('kode', 'DESC')->get(['kode'])->first();
        if ($query) {
            $data = $query->kode;
            $str = substr($data, -6);
            $codes = intval($str) + 1;
        } else {
            $codes = 1;
        }
        $kode_max = str_pad($codes, 6, "0", STR_PAD_LEFT);
        $kode_jadi = "DGM" . $kode_max;

        //table Users
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'pass_d' => $request->password,
            'level' => '2',
            'status' => '0',
        ]);



        //table tb_user
        UserT::create([
            'nama_user' => $request->nama,
            'email' => $request->email,
            'verifikasi' => $code,
            'kode' => $kode_jadi,
            'status' => '3',
            'tgl_reg' => $tanggal,
        ]);


        //table tb_info_user
        Userinfo::create([]);

        //table tb_info_undangan
        Undanganinfo::create([
            'latitude' => '-8.585773895457095',
            'longitude' => '116.10337828751653',
        ]);

        //table tb_story
        Story::create([]);

        return new UserResource($user);
    }
    public function login(ValidateUserLogin $request)
    {

        $credentials = request(['email', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return  response()->json([
                'errors' => [
                    'msg' => ['Incorrect username or password.']
                ]
            ], 401);
        }


        return response()->json([
            'type' => 'success',
            'message' => 'Logged in.',
            'token' => $token
        ]);
    }

    public function user()
    {
        return new UserResource(auth()->user());
    }
}
