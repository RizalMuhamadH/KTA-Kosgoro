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
                echo json_encode([
                    'code'  =>  200,
                    'text'  =>  "Member Ditemukan",
                    'data'  =>  $tmp
                ]);
            }else{
                echo json_encode([
                    'code'  =>  400,
                    'text'  =>  "Member Tidak Ditemukan",
                    'data'  =>  $tmp
                ]);
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
            $tmp_user = User::where('email',$request->email)->first();
        }else if($request->phone_number != null){
            $tmp_user = User::where('phone',$request->phone_number)->first();
        }
        if($tmp_user != null){
            $otp_before_hash = Str::random(6);
            $tmp_user->password = Hash::make($otp_before_hash);
            $tmp_user->otp_used = 0;
            $tmp_user->save();
            Mail::to($tmp_user->email)->send(new SendOTPMail($tmp_user, $otp_before_hash));
            $result = [
                'code'      =>  '200',
                'type'      =>  'success',
                'message'   =>  'Silahkan Cek Email Anda',
            ];
            echo json_encode($result);
        }else{
            if($request->email != null){
                $new_user = new User();
                $new_user->name = $request->email;
                $new_user->email = $request->email;
                $new_user->save();

                $otp_before_hash = Str::random(6);
                $new_user->password = Hash::make($otp_before_hash);
                $new_user->otp_used = 0;
                $new_user->save();
                Mail::to($new_user->email)->send(new SendOTPMail($new_user, $otp_before_hash));
                $result = [
                    'code'      =>  '200',
                    'type'      =>  'success',
                    'message'   =>  'Silahkan Cek Email Anda',
                ];
                echo json_encode($result);
            }
            else{
                $result = [
                    'code'  =>  '400',
                    'type'  =>  'error',
                ];
                echo json_encode($result);
            }
        }
    }

    public function login(Request $request){
        $request->validate([
            'password'   =>  'required'
        ]);
        if($request->email != null){
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'otp_used' => 0, 'active' => 1])){
                $tmp_user = User::where('email',$request->email)->first();
                $tmp_user->otp_used = 1;
                $tmp_user->save();
                if($request->api){
                    return json_encode([
                        'token'         => $tmp_user->token,
                        'status'        => $tmp_user->status,
                        'code'          => 200,
                        'no_member'     => $tmp_user->no_member  
                    ]);
                    die;
                }
                return redirect('/home');
            }else{
                return redirect()->back()->with('message','Login gagal, silahkan cek kembali nomor telepon/email dan otp anda');
            }
        }elseif($request->phone_number != null){
            if(Auth::attempt(['phone' => $request->phone_number, 'password' => $request->password, 'otp_used' => 0, 'active' => 1])){
                $tmp_user = User::where('phone',$request->phone_number)->first();
                $tmp_user->otp_used = 1;
                $tmp_user->save();
                if($request->api){
                    return json_encode([
                        'token'         => $tmp_user->token,
                        'status'        => $tmp_user->status,
                        'code'          => 200,
                        'no_member'     => $tmp_user->no_member  
                    ]);
                }
                return redirect('/home');
            }else{
                return redirect()->back()->with('message','Login gagal, silahkan cek kembali nomor telepon/email dan otp anda');
            }
        }else{
            return redirect()->back()->with('message','Login gagal, silahkan cek kembali nomor telepon/email dan otp anda');
        }
    }

    public function store(Request $request){
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
                'post_code'     =>  'required',
                'address'       =>  'required',
                'position'      =>  'required',
                'photo'         =>  'required|max:1024|mimes:jpg,jpeg,png',
                'id_card'       =>  'required|max:1024|mimes:jpg,jpeg,png',
            );

            $validator = Validator::make($request->all(),$rules);
            if($validator->fails()){
                    return Response([
                        'code'  =>  500,
                        'message'   =>  $validator->errors()
                    ]);
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
        $user->no_member        = Str::random(12);
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
            $photo = "Pas Photo ".$request->name;
            $photo = Str::slug($photo).'.'.$request->file('photo')->extension();
            $request->file('photo')->storeAs("data_member/".$user->id,$photo,'public');

            $ktp = "KTP ".$request->name;
            $ktp = Str::slug($ktp).'.'.$request->file('id_card')->extension();
            $request->file('id_card')->storeAs("data_member/".$user->id,$ktp,'public');

            $qr_code = "QR Code ".$request->name;
            $qr_code = Str::slug($qr_code).".svg";
            QrCode::format('svg')->generate(route('members.detail',['id'   => $user->id]), public_path('storage/data_member/'.$user->id.'/'.$qr_code));

            $tmp_user = User::where('id', $user->id)->with(['Position','Province','District','SubDistrict','Village'])->first();
            $tmp_user->photo = $photo;
            $tmp_user->id_card_photo = $ktp;
            $tmp_user->qrcode = $qr_code;
            $tmp_user->save();
            
            Mail::to($tmp_user->email)->send(new RegisteredMember($tmp_user));
            if(!$request->api){
                echo json_encode($result = array([
                    "message"   => "Member Berhasil Ditambahkan",
                    "type"      => "success",
                    "code"    => true]));
            }else{
                return Response([
                    "message"   => "Member Berhasil Ditambahkan",
                    "type"      => "success",
                    "code"    => 200]);
            }
        }else{
            if(!$request->api){
                echo json_encode($result = array([
                    "message"   => "Member Gagal Ditambahkan",
                    "type"      => "success",
                    "code"    => true]));
            }else{
                return Response([
                    "message"   => "Member Gagal Ditambahkan",
                    "type"      => "error",
                    "code"    => 500]);
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
                'position'      =>  'required',
            );

            $validator = Validator::make($request->all(),$rules);
            if($validator->fails()){
                    return Response([
                        'code'  =>  500,
                        'message'   =>  $validator->errors()
                    ]);
            }
        }

        if(!isset($request->api)){
            $user = User::find($request->id);   
            $user->no_member = $request->no_member;
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
        $user->position_id      = $request->position;

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
                            'name'          =>  $newEncrypter->encrypt($user->name),
                            'email'         =>  $newEncrypter->encrypt( $user->email ),
                            'phone'         =>  $newEncrypter->encrypt( $user->phone ),
                            'nik'           =>  $newEncrypter->encrypt( $user->nik ),
                            'position'      =>  $newEncrypter->encrypt( $user->Position['name']),
                            'province'      =>  $newEncrypter->encrypt( $user->Province['name']),
                            'district'      =>  $newEncrypter->encrypt( $user->District['name']),
                            'sub_district'  =>  $newEncrypter->encrypt( $user->SubDistrict['name']),
                            'village'       =>  $newEncrypter->encrypt( $user->Village['name']),
                            'qrcode'        =>  $newEncrypter->encrypt( $user->qrcode),
                            'address'       =>  $newEncrypter->encrypt( $user->address ),
                            'post_code'     =>  $newEncrypter->encrypt( $user->post_code ),
                            'status'        =>  $user->status,
                            'active'        =>  $user->active,
                        ]
                    ]
                ];
                $es = $this->repository->update($params);
            }

            if(!$request->api){
                echo json_encode($result = array([
                    "message"   => "Member Berhasil Diupdate",
                    "type"      => "success",
                    "code"    => true]));
            }else{
                return Response([
                    "message"   => "Member Berhasil Diupdate",
                    "type"      => "success",
                    "code"    => 200]);
            }
        }else{
            if(!$request->api){
                echo json_encode($result = array([
                    "message"   => "Member Gagal Diupdate",
                    "type"      => "error",
                    "code"    => true]));
            }else{
                return Response([
                    "message"   => "Member Gagal Diupdate",
                    "type"      => "error",
                    "code"    => 500]);
            }
        }
    }

    public function change_status(Request $request){
        $type = "";
        $user = User::find($request->id);
        $request->validate([
            'id'            =>  'required',
            'status'      =>  'required',
        ]);
        $newEncrypter = new \Illuminate\Encryption\Encrypter(  str_replace("-","",$user->token), Config::get('app.cipher') );
        
        if($request->status == "1"){
            $user->no_member = date("Y.md.").$user->id;
            $type = "Diverifikasi";
            $user->status = 1;
            Mail::to($user->email)->send(new VerifiedMember($user));

            $params = [
                'index' => 'members',
                'id'    => $user->no_member,
                'body'  => [
                    'no_member'     =>  $user->no_member,
                    'name'          =>  $newEncrypter->encrypt($user->name),
                    'email'         =>  $newEncrypter->encrypt( $user->email ),
                    'phone'         =>  $newEncrypter->encrypt( $user->phone ),
                    'nik'           =>  $newEncrypter->encrypt( $user->nik ),
                    'position'      =>  $newEncrypter->encrypt( $user->Position['name']),
                    'province'      =>  $newEncrypter->encrypt( $user->Province['name']),
                    'district'      =>  $newEncrypter->encrypt( $user->District['name']),
                    'sub_district'  =>  $newEncrypter->encrypt( $user->SubDistrict['name']),
                    'village'       =>  $newEncrypter->encrypt( $user->Village['name']),
                    'qrcode'        =>  $newEncrypter->encrypt( $user->qrcode),
                    'address'       =>  $newEncrypter->encrypt( $user->address ),
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
                        'name'          =>  $newEncrypter->encrypt($user->name),
                        'email'         =>  $newEncrypter->encrypt( $user->email ),
                        'phone'         =>  $newEncrypter->encrypt( $user->phone ),
                        'nik'           =>  $newEncrypter->encrypt( $user->nik ),
                        'position'      =>  $newEncrypter->encrypt( $user->Position['name']),
                        'province'      =>  $newEncrypter->encrypt( $user->Province['name']),
                        'district'      =>  $newEncrypter->encrypt( $user->District['name']),
                        'sub_district'  =>  $newEncrypter->encrypt( $user->SubDistrict['name']),
                        'village'       =>  $newEncrypter->encrypt( $user->Village['name']),
                        'qrcode'        =>  $newEncrypter->encrypt( $user->qrcode),
                        'address'       =>  $newEncrypter->encrypt( $user->address ),
                        'post_code'     =>  $newEncrypter->encrypt( $user->post_code ),
                        'status'        =>  $user->status,
                        'active'        =>  $user->active,
                    ]
                ]
            ];
            $es = $this->repository->update($params);
        }

        if($result){
            echo json_encode($result = array([
                "message"   => "Member Berhasil $type",
                "type"      => "success",
                "code"    => true]));
        }else{
            echo json_encode($result = array([
                "message"   => "Member Gagal $type",
                "type"      => "error",
                "code"    => false]));
        }
    }

    public function check_status(Request $request){
        $user = User::where('email',$request->email)->first();
        if($user != null){
            return json_encode([
                'code'      =>  200,
                'data'      =>  [
                    'status'    =>  $user->status,
                    'active'    =>  $user->active,
                    'no_member' =>  $user->no_member
                ],
                'message'   =>  "Data member Ditemukan"
            ]);
        }else{
            return json_encode([
                'code'      =>  500,
                'data'      =>  null,
                'message'   =>  "Data member Tidak Ditemukan"
            ]);
        }
    }
}
