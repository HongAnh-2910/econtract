<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite;
use Redirect;
use Session;
use URL;

class SocialAuthController extends Controller
{
    /**
     * Chuyển hướng người dùng sang OAuth Provider.
     *
     * @param $provider
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        if (!Session::has('pre_url')) {
            Session::put('pre_url', URL::previous());
        } else {
            if (URL::previous() != URL::to('login')) {
                Session::put('pre_url', URL::previous());
            }
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Lấy thông tin từ Provider, kiểm tra nếu người dùng đã tồn tại trong CSDL
     * thì đăng nhập, ngược lại nếu chưa thì tạo người dùng mới trong SCDL.
     *
     * @param $provider
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $user = $this->getProfileUserBySocialite($provider);
        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);

        return Redirect::to(Session::get('pre_url'));
    }

    /**
     * @param $provider
     *
     * @return  User
     */

    public function getProfileUserBySocialite($provider)
    {
        return Socialite::driver($provider)->stateless()->user();
    }

    /**
     * @param  $user
     * @param $provider
     *
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        $checkUser = User::where('email', $user->email)->first();
        $authUser = User::where('provider_id', $user->id)->first();
        if ($checkUser) {
            return $checkUser;
        }
        if ($authUser) {
            return $authUser;
        } else {
            $user = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'password' => 'google',
                'provider' => $provider,
                'provider_id' => $user->id
            ]);

            return $user;
        }
    }
}
