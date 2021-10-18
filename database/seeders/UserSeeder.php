<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'              =>  'Super Admin',
            'email'             =>  'superadmkasgoro@gmail.com',
            'phone'             =>  '0000000000000',
            'nik'               =>  '0000000000000000',
            'no_member'         =>  '21.0721.0',
            'photo'             =>  'photo',
            'address'           =>  'Bandung',
            'province_id'       =>  32,
            'district_id'       =>  3273,
            'sub_district_id'   =>  3273070,
            'village_id'        =>  3273070003,
            'post_code'         =>  '40264',
            'status'            =>  '1',
            'position_id'       =>  1
        ]);


        $name = "QR Code Super Admin.svg";
        Storage::disk('public')->makeDirectory('data_member/'.$user->id);
        QrCode::format('svg')->generate(route('members.detail',['id'   => $user->id]), public_path('storage/data_member/'.$user->id.'/'.$name));
        $tmp_user = User::find($user->id);
        $tmp_user->qrcode = $name;
        $tmp_user->save();

    }
}
