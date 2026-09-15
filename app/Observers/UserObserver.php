<?php

namespace App\Observers;

use App\Models\User;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class UserObserver
{
    public function saving(User $user)
    {
        //这样写扩展性更高，只有空的时候才指定默认头像
        if (empty($user->avatar)) {
            $user->avatar = 'http://larabbs.test:30091/uploads/images/avatars/202609/15/11_1789460600_WAqJ34eb7K.png';
        }
    }

    public function updating(User $user)
    {
        //
    }
}
