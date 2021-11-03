<?php

namespace App\Http\Controllers;

use App\Mail\BlockMember;
use App\Mail\RegisteredMember;
use App\Mail\SendOTPMail;
use App\Mail\UnblockMember;
use App\Mail\VerifiedMember;
use App\Models\Position;
use App\Models\User;
use App\Repository\Elasticsearch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MemberController extends Controller
{

    private $repository;

    public function __construct(Elasticsearch $repository)
    {
        $this->repository = $repository;
    }

    public function index(){
        return view('Members.index', [
            'positions'    => Position::all()
        ]);
    }

    public function detail(Request $request){
        if($request->api){
            $tmp = User::where('email',$request->email)->with(['Province','District','SubDistrict','Village','Position'])->first();
        }else{
            $tmp = User::where('id',$request->id)->with(['Province','District','SubDistrict','Village','Position'])->first();
        }
        if(isset($request->cms)){
            echo json_encode($tmp);
        }else{
            if($tmp != null){

                $response = [
                    'code'  =>  200,
                    'text'  =>  "Member Ditemukan",
                    'data'  =>  $tmp
                ];
                return response($response, 200);
            }else{
                $response = [
                    'code'  =>  400,
                    'text'  =>  "Member Tidak Ditemukan",
                    'data'  =>  $tmp
                ];


                return response($response, 200);
            }

        }
    }

    public function datatables(Request $request){
        $tmp_query = User::select(['id','name','email','phone','no_member','address','province_id','district_id','sub_district_id','village_id','status','position_id']);
        if($request->province_id != ""){
            $tmp_query->where('province_id',$request->province_id);
        }

        if($request->district_id != ""){
            $tmp_query->where('district_id',$request->district_id);
        }

        if($request->sub_district_id != ""){
            $tmp_query->where('sub_district_id',$request->sub_district_id);
        }

        if($request->village_id != ""){
            $tmp_query->where('village_id',$request->village_id);
        }

        if($request->position_id != "All"){
            $tmp_query->where('position_id',$request->position_id);
        }

        if($request->status != "All"){
            $tmp_query->where('status',$request->status);
        }



        $result['data'] = $tmp_query->with(['Province','District','SubDistrict','Village','Position'])->get();
        echo json_encode($result);
    }

    public function generate_otp(Request $request){
        $tmp_user = "";
        if($request->email != null){
            $tmp_user = User::where('email','ilike','%'.$request->email.'%')->first();
        }else if($request->phone_number != null){
            $tmp_user = User::where('phone',$request->phone_number)->first();
        }
        if($tmp_user != null){
            $otp_before_hash = mt_rand(111111,999999);
            $tmp_user->password = Hash::make($otp_before_hash);
            $tmp_user->otp_used = 0;
            $tmp_user->save();
            Mail::to($tmp_user->email)->send(new SendOTPMail($tmp_user, $otp_before_hash));
            $result = [
                'code'      =>  200,
                'type'      =>  'success',
                'message'   =>  'Silahkan Cek Email Anda',
            ];
            return response($result, 200);
        }else{
            if($request->email != null){
                $new_user = new User();
                $new_user->name = $request->email;
                $new_user->email = $request->email;
                $new_user->save();

                $otp_before_hash = mt_rand(111111,999999);
                $new_user->password = Hash::make($otp_before_hash);
                $new_user->otp_used = 0;
                $new_user->save();
                Mail::to($new_user->email)->send(new SendOTPMail($new_user, $otp_before_hash));
                $result = [
                    'code'      =>  200,
                    'type'      =>  'success',
                    'message'   =>  'Silahkan Cek Email Anda',
                ];
                return response($result, 200);
            }
            else{
                $result = [
                    'code'  =>  400,
                    'type'  =>  'error',
                ];
                return response($result, 400);
            }
        }
    }

    public function login(Request $request){
        $request->validate([
            'password'   =>  'required'
        ]);

        if(isset($request->cms)){
            if($request->email != null){
                if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'otp_used' => 0, 'active' => 1, 'position_id' => array('1','2')])){
                    $tmp_user = User::where('email',$request->email)->first();
                    $tmp_user->otp_used = 1;
                    $tmp_user->save();
                    return redirect('/home');
                }else{
                    return redirect()->back()->with('message','Login gagal, silahkan cek kembali nomor telepon/email dan otp anda');
                }
            }elseif($request->phone_number != null){
                if(Auth::attempt(['phone' => $request->phone_number, 'password' => $request->password, 'otp_used' => 0, 'active' => 1, 'position_id' => array(',1','2')])){
                    $tmp_user = User::where('phone',$request->phone_number)->first();
                    $tmp_user->otp_used = 1;
                    $tmp_user->save();
                    return redirect('/home');
                }else{
                    return redirect()->back()->with('message','Login gagal, silahkan cek kembali nomor telepon/email dan otp anda');
                }
            }else{
                return redirect()->back()->with('message','Login gagal, silahkan cek kembali nomor telepon/email dan otp anda');
            }
        }else{
            if($request->email != null){
                if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'otp_used' => 0, 'active' => 1])){
                    $tmp_user = User::where('email',$request->email)->first();
                    $tmp_user->otp_used = 1;
                    $tmp_user->save();
                    $response = [
                        'token'         => $tmp_user->token,
                        'status'        => $tmp_user->status,
                        'code'          => 200,
                        'no_member'     => $tmp_user->no_member,
                        'message'       => "Berhasil login"
                    ];
                    return response($response, 200);
                }else{
                    $response = [
                        'token'         => null,
                        'status'        => null,
                        'code'          => 500,
                        'no_member'     => null,
                        'message'       => "Gagal login"
                    ];
                    return response($response, 200);
                }
            }elseif($request->phone_number != null){
                if(Auth::attempt(['phone' => $request->phone_number, 'password' => $request->password, 'otp_used' => 0, 'active' => 1])){
                    $tmp_user = User::where('phone',$request->phone_number)->first();
                    $tmp_user->otp_used = 1;
                    $tmp_user->save();
                    $response = [
                        'token'         => $tmp_user->token,
                        'status'        => $tmp_user->status,
                        'code'          => 200,
                        'no_member'     => $tmp_user->no_member
                    ];
                    return response($response, 200);
                }else{
                     $response = [
                        'token'         => null,
                        'status'        => null,
                        'code'          => 500,
                        'no_member'     => null,
                        'message'       => "Gagal login"
                    ];
                    return response($response, 200);
                }
            }else{
                 $response = [
                        'token'         => null,
                        'status'        => null,
                        'code'          => 500,
                        'no_member'     => null,
                        'message'       => "Gagal login"
                    ];
                    return response($response, 200);
            }
        }
    }

    public function store(Request $request){
        $is_file = 0;
        if(!isset($request->api)){
            $request->validate([
                'name'          => 'required',
                'email'         =>  'required|email|unique:members,email',
                'phone'         =>  'required|min:10|max:13|unique:members,phone',
                'nik'           =>  'required|min:16|max:16|unique:members,nik',
                'province'      =>  'required',
                'district'      =>  'required',
                'sub_district'  =>  'required',
                'village'       =>  'required',
                'post_code'     =>  'required',
                'address'       =>  'required',
                'position'      =>  'required',
                'photo'         =>  'required|max:1024|mimes:jpg,jpeg,png',
                'id_card'       =>  'required|max:1024|mimes:jpg,jpeg,png',
            ]);
        }else{
            $rules = array(
                'name'          =>  'required',
                'phone'         =>  'required|min:10|max:13|unique:members,phone',
                'nik'           =>  'required|min:16|max:16|unique:members,nik',
                'province'      =>  'required',
                'district'      =>  'required',
                'sub_district'  =>  'required',
                'village'       =>  'required',
                'address'       =>  'required',
            );

            $validator = Validator::make($request->all(),$rules);
            if($validator->fails()){
                    $response = [
                        'code'  =>  500,
                        'message'   =>  $validator->errors()->first()
                    ];

                    return response($response, 200);
            }
        }

        if(isset($request->api)){
            $user =  User::where('email',$request->email)->first();
            if($user == null){
                $user = new User();
            }
        }else{
            $user = new User();
        }
        $user->name             = $request->name;
        $user->email            = $request->email;
        $user->phone            = $request->phone;
        $user->nik              = $request->nik;
        $user->no_member        = mt_rand(111111,999999);
        $user->photo            = "Photo";
        $user->id_card_photo    = "Id Card Photo";
        $user->address          = $request->address;
        $user->post_code        = $request->post_code;
        $user->province_id      = $request->province;
        $user->district_id      = $request->district;
        $user->sub_district_id  = $request->sub_district;
        $user->village_id       = $request->village;
        $user->token            = (string) Str::orderedUuid();
        $user->qrcode           = "QR Code";
        $user->status           = 0;
        $user->position_id      = $request->api ? '3' : $request->position;

        $result = $user->save();
        if($result){
            $tmp_user = User::where('id', $user->id)->with(['Position','Province','District','SubDistrict','Village'])->first();
            if($request->hasFile('photo')){
                $photo = "Pas Photo ".$request->name;
                $photo = Str::slug($photo).'.'.$request->file('photo')->extension();
                $request->file('photo')->storeAs("data_member/".$user->id,$photo,'public');
                $tmp_user->photo = $photo;
                $is_file++;
            }

            if($request->hasFile('id_card')){
                $ktp = "KTP ".$request->name;
                $ktp = Str::slug($ktp).'.'.$request->file('id_card')->extension();
                $request->file('id_card')->storeAs("data_member/".$user->id,$ktp,'public');
                $tmp_user->id_card_photo = $ktp;
                $is_file++;
            }
            if($is_file > 0){
                $tmp_user->save();
            }

            Mail::to($tmp_user->email)->send(new RegisteredMember($tmp_user));
            if(!$request->api){
                $response = [
                    "message"   => "Member Berhasil Ditambahkan",
                    "type"      => "success",
                    "code"    => true];
                    return response($response, 200);
            }else{
                $response = [
                    "message"   => "Member Berhasil Ditambahkan",
                    "type"      => "success",
                    "data"      => [
                        "token"     => $tmp_user->token,
                        "name"      => $tmp_user->name,
                        "district"  => $tmp_user->District->name,
                    ],
                    "code"      => 200];
                    return response($response, 200);
            }
        }else{
            if(!$request->api){
                $response = [
                    "message"   => "Member Gagal Ditambahkan",
                    "type"      => "success",
                    "code"    => true];
                    return response($response, 200);
            }else{
                $response = [
                    "message"   => "Member Gagal Ditambahkan",
                    "type"      => "error",
                    "code"    => 500];
                    return response($response, 200);
            }
        }
    }

    public function update(Request $request){
        if(!isset($request->api)){
            $request->validate([
                'id'            =>  'required',
                'name'          =>  'required',
                'email'         =>  'required|email|unique:members,email,'.$request->id,
                'phone'         =>  'required|min:10|max:13|unique:members,phone,'.$request->id,
                'nik'           =>  'required|min:16|max:16|unique:members,nik,'.$request->id,
                'province'      =>  'required',
                'district'      =>  'required',
                'sub_district'  =>  'required',
                'village'       =>  'required',
                'post_code'     =>  'required',
                'address'       =>  'required',
                'position'      =>  'required',
            ]);
        }else{
            $user = User::where('email',$request->email)->first();
            $rules = array(
                'name'          =>  'required',
                'email'         =>  'required|email|unique:members,email,'.$user->id,
                'phone'         =>  'required|min:10|max:13|unique:members,phone,'.$user->id,
                'nik'           =>  'required|min:16|max:16|unique:members,nik,'.$user->id,
                'province'      =>  'required',
                'district'      =>  'required',
                'sub_district'  =>  'required',
                'village'       =>  'required',
                'post_code'     =>  'required',
                'address'       =>  'required',
            );

            $validator = Validator::make($request->all(),$rules);
            if($validator->fails()){
                    $response = [
                        'code'  =>  500,
                        'message'   =>  $validator->errors()
                    ];
                    return response($response, 200);
            }
        }

        if(!isset($request->api)){
            $user = User::find($request->id);
        }
        $user->name             = $request->name;
        $user->email            = $request->email;
        $user->phone            = $request->phone;
        $user->nik              = $request->nik;
        if($request->hasFile('photo')){
            $photo = "Pas Photo ".$request->name;
            $photo = Str::slug($photo).'.'.$request->file('photo')->extension();
            $request->file('photo')->storeAs("data_member/".$user->id,$photo,'public');
            $user->photo = $photo;
        }
        if($request->hasFile('id_card_photo')){
            $ktp = "KTP ".$request->name;
            $ktp = Str::slug($ktp).'.'.$request->file('id_card')->extension();
            $request->file('id_card')->storeAs("data_member/".$user->id,$ktp,'public');
            $user->id_card_photo = $ktp;
        }

        $user->address          = $request->address;
        $user->post_code        = $request->post_code;
        $user->province_id      = $request->province;
        $user->district_id      = $request->district;
        $user->sub_district_id  = $request->sub_district;
        $user->village_id       = $request->village;
        if(isset($request->position)){
            $user->position_id      = $request->position;
        }

        $result = $user->save();
        $newEncrypter = new \Illuminate\Encryption\Encrypter(  str_replace("-","",$user->token), Config::get('app.cipher') );
        if($result){
            if($user->status != "0"){
                $params = [
                    'index' => 'members',
                    'id'    => $user->no_member,
                    'body'  => [
                        'doc' => [
                            'no_member'     =>  $user->no_member,
                            'name'          =>  $user->name,
                            'email'         =>  $newEncrypter->encrypt( $user->email ),
                            'phone'         =>  $newEncrypter->encrypt( $user->phone ),
                            'nik'           =>  $newEncrypter->encrypt( $user->nik ),
                            'position'      =>  $user->Position['name'],
                            'province'      =>  $user->Province['name'],
                            'district'      =>  $user->District['name'],
                            'sub_district'  =>  $user->SubDistrict['name'],
                            'village'       =>  $user->Village['name'],
                            'photo'         =>  $user->id.'/'.$user->photo,
                            'qrcode'        =>  $user->id.'/'.$user->qrcode,
                            'address'       =>  $user->address,
                            'post_code'     =>  $newEncrypter->encrypt( $user->post_code ),
                            'status'        =>  $user->status,
                            'active'        =>  $user->active,
                        ]
                    ]
                ];
                $es = $this->repository->update($params);
            }

            $response = [
                "message"   => "Member Berhasil Diupdate",
                "type"      => "success",
                "code"    => true];
                return response($response, 200);
        }else{
            $response = [
                "message"   => "Member Gagal Diupdate",
                "type"      => "error",
                "code"    => 500];
                return response($response, 200);
        }
    }

    public function change_status(Request $request){
        $type = "";
        $user = User::find($request->id);
        $request->validate([
            'id'            =>  'required',
            'status'        =>  'required',
            'no_member'     =>  'required|unique:members,no_member'
        ]);
        $newEncrypter = new \Illuminate\Encryption\Encrypter(  str_replace("-","",$user->token), Config::get('app.cipher') );
        $count_user = User::count();
        if($request->status == "1"){
            if($request->option == "0"){
                $user->no_member = "NA-K57.".str_pad($user->id+15,3,"0",STR_PAD_LEFT);
            }else if($request->option == "1"){
                $request->validate([
                    'no_member' => 'required|unique:members,no_member,'.$user->id,
                ]);
                $user->no_member = $request->no_member;
            }
            $type = "Diverifikasi";
            $qr_code = "QR Code ".$user->name;
            $qr_code = Str::slug($qr_code).".svg";
            QrCode::format('svg')->generate($user->id, public_path('storage/data_member/'.$user->id.'/'.$qr_code));
            $user->qrcode = $qr_code;
            $user->status = 1;
            Mail::to($user->email)->send(new VerifiedMember($user));

            $params = [
                'index' => 'members',
                'id'    => $user->no_member,
                'body'  => [
                    'no_member'     =>  $user->no_member,
                    'name'          =>  $user->name,
                    'email'         =>  $newEncrypter->encrypt( $user->email ),
                    'phone'         =>  $newEncrypter->encrypt( $user->phone ),
                    'nik'           =>  $newEncrypter->encrypt( $user->nik ),
                    'position'      =>  $user->Position['name'],
                    'province'      =>  $user->Province['name'],
                    'district'      =>  $user->District['name'],
                    'sub_district'  =>  $user->SubDistrict['name'],
                    'village'       =>  $user->Village['name'],
                    'photo'         =>  $user->id.'/'.$user->photo,
                    'qrcode'        =>  $user->id.'/'.$user->qrcode,
                    'address'       =>  $user->address,
                    'post_code'     =>  $newEncrypter->encrypt( $user->post_code ),
                    'status'        =>  $user->status,
                    'active'        =>  $user->active,
                ]
            ];
            $es = $this->repository->create($params);

        }else if($request->status == "2"){
            $type = "Diblock";
            $user->status = 2;
            $user->active = 0;
            Mail::to($user->email)->send(new BlockMember($user));
        }else if($request->status == "3"){
            $type = "Unblock";
            $user->status = 1;
            Mail::to($user->email)->send(new UnblockMember($user));
        }

        $result = $user->save();

        if($request->status != "1"){
            $params = [
                'index' => 'members',
                'id'    => $user->no_member,
                'body'  => [
                    'doc' => [
                        'no_member'     =>  $user->no_member,
                        'name'          =>  $user->name,
                        'email'         =>  $newEncrypter->encrypt( $user->email ),
                        'phone'         =>  $newEncrypter->encrypt( $user->phone ),
                        'nik'           =>  $newEncrypter->encrypt( $user->nik ),
                        'position'      =>  $user->Position['name'],
                        'province'      =>  $user->Province['name'],
                        'district'      =>  $user->District['name'],
                        'sub_district'  =>  $user->SubDistrict['name'],
                        'village'       =>  $user->Village['name'],
                        'qrcode'        =>  $user->qrcode,
                        'address'       =>  $user->address,
                        'post_code'     =>  $newEncrypter->encrypt( $user->post_code ),
                        'status'        =>  $user->status,
                        'active'        =>  $user->active,
                    ]
                ]
            ];
            $es = $this->repository->update($params);
        }

        if($result){
            $response = [
                'code'      =>  true,
                "message"   => "Member Berhasil $type",
                "type"      => "success",
            ];
            return response($response, 200);
        }else{
            $response = [
                'code'      =>  false,
                "message"   => "Member Gagal $type",
                "type"      => "error",
            ];
            return response($response, 200);
        }
    }

    public function check_status(Request $request){
        $user = User::where('email',$request->email)->first();
        if($user != null){
            $response = [
                'code'      =>  200,
                'data'      =>  [
                    'status'    =>  $user->status,
                    'name'      =>  $user->name,
                    'district'  =>  $user->District['name'],
                    'photo'     =>  $user->id.'/'.$user->photo,
                    'token'     =>  $user->token,
                    'active'    =>  $user->active,
                    'no_member' =>  $user->no_member
                ],
                'message'   =>  "Data member Ditemukan"
            ];
            return response($response, 200);
        }else{
            $response = [
                'code'      =>  500,
                'data'      =>  null,
                'message'   =>  "Data member Tidak Ditemukan"
            ];
            return response($response, 200);
        }
    }

    public function delete(Request $request){
        $result = User::where('no_member',$request->no_member)->delete();
        if($result){
            $params = [
                'index' => 'members',
                'id'    => $request->no_member,
            ];
            $es = $this->repository->delete($params);
            echo json_encode($result = array([
                "message"   => "Data berhasil dihapus",
                "type"      => "success",
                "code"    => true]));
                
        }else{
            echo json_encode($result = array([
                "message"   => "Data gagal dihapus",
                "type"      => "error",
                "code"    => false]));
        }

        
    }
}
