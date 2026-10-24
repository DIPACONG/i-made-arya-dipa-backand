<?php

namespace App\Policies;

use App\Models\Photo;
use App\Models\User;

class PhotoPolicy
{
    // Hanya pemilik foto yang boleh mengubah / menghapus.
    public function update(User $user, Photo $photo): bool
    {
        return $user->id === $photo->user_id;
    }

    public function delete(User $user, Photo $photo): bool
    {
        return $user->id === $photo->user_id;
    }
}
