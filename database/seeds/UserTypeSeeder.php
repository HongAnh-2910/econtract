<?php

use App\Models\UserType;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrayTypes = [
            [
                'name' => 'Free Basic',
                'key_word' => 'free',
                'description' => 'Free Basic',
                'first_duration' => '0',
                'second_duration' => '0',
                'third_duration' => '0',
            ],
            [
                'name' => 'SmartCA Personal 1',
                'key_word' => 'paid',
                'description' => '<p>- Tốc độ ký: 1 lượt ký/giây</p><p>- Lượt ký tối đa trong 24h: 500 lượt ký</p>',
                'first_duration' => '300000',
                'second_duration' => '500000',
                'third_duration' => '700000',
            ],
            [
                'name' => 'SmartCA Personal 2',
                'key_word' => 'paid',
                'description' => '<p>- Tốc độ ký: 1 lượt ký/giây</p><p>- Lượt ký tối đa trong 24h: 500 lượt ký</p>',
                'first_duration' => '300000',
                'second_duration' => '500000',
                'third_duration' => '700000',
            ],
            [
                'name' => 'SmartCA Personal 3',
                'key_word' => 'paid',
                'description' => '<p>- Tốc độ ký: 1 lượt ký/giây</p><p>- Lượt ký tối đa trong 24h: 500 lượt ký</p>',
                'first_duration' => '300000',
                'second_duration' => '500000',
                'third_duration' => '700000',
            ],
            [
                'name' => 'SmartCA Personal 4',
                'key_word' => 'paid',
                'description' => '<p>- Tốc độ ký: 1 lượt ký/giây</p><p>- Lượt ký tối đa trong 24h: 500 lượt ký</p>',
                'first_duration' => '300000',
                'second_duration' => '500000',
                'third_duration' => '700000',
            ],
            [
                'name' => 'SmartCA Personal 5',
                'key_word' => 'paid',
                'description' => '<p>- Tốc độ ký: 1 lượt ký/giây</p><p>- Lượt ký tối đa trong 24h: 500 lượt ký</p>',
                'first_duration' => '300000',
                'second_duration' => '500000',
                'third_duration' => '700000',
            ],
            [
                'name' => 'SmartCA Personal 6',
                'key_word' => 'paid',
                'description' => '<p>- Tốc độ ký: 1 lượt ký/giây</p><p>- Lượt ký tối đa trong 24h: 500 lượt ký</p>',
                'first_duration' => '300000',
                'second_duration' => '500000',
                'third_duration' => '700000',
            ],
            [
                'name' => 'SmartCA Personal 7',
                'key_word' => 'paid',
                'description' => '<p>- Tốc độ ký: 1 lượt ký/giây</p><p>- Lượt ký tối đa trong 24h: 500 lượt ký</p>',
                'first_duration' => '300000',
                'second_duration' => '500000',
                'third_duration' => '700000',
            ],
        ];

        foreach ($arrayTypes as $value) {
            $userType                  = new UserType();
            $userType->name            = $value['name'];
            $userType->key_word        = $value['key_word'];
            $userType->description     = $value['description'];
            $userType->first_duration  = $value['first_duration'];
            $userType->second_duration = $value['second_duration'];
            $userType->third_duration  = $value['third_duration'];
            $userType->save();
        }

        $users = \App\Models\User::all();
        $typeFree = UserType::where('key_word', '=', UserType::TYPE_FREE)->first();
        foreach ($users as $user) {
            $user->user_type_id = $typeFree->id;
            $user->save();
        }
    }
}
