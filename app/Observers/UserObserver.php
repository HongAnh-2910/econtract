<?php

namespace App\Observers;


use App\Models\Folder;
use App\Models\User;
use App\Models\UserType;
use Carbon\Carbon;

class UserObserver
{
    public function created(User $user)
    {
        if (empty($user->user_type_id)) {
            $typeFree = UserType::where('key_word', '=', UserType::TYPE_FREE)->first();
            if (!empty($typeFree)) {
                $user->user_type_id = $typeFree->id;
                $user->save();
            }
        }
        Folder::create([
            'name' => 'Parent folder of ' . $user->name,
            'user_id' => $user->id,
        ]);
    }

    public function updated(User $user)
    {
        //
    }

    public function deleted(User $user)
    {
        //
    }

    public function restored(User $user)
    {
        //
    }

    public function forceDeleted(User $user)
    {
        //
    }
}
