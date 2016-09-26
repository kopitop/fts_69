<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function upload($fileName);
    public function updateAvatar($oldPath, $fileName);
}
