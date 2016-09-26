<?php

namespace App\Repositories\User;

use Auth;
use App\Models\User;
use File;
use Storage;
use Exception;
use App\Repositories\BaseRepository;
Use App\Repositories\User\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function upload($file)
    {
        try {
            if (!is_null($file)) {
                $avatarName = uniqid() . '.' . $file->getClientOriginalExtension();
                $path = public_path() . config('common.user.avatar_url');
                $pathAvatar = $path . $avatarName;

                if (!File::exists($pathAvatar)) {
                    $file->move($path, $avatarName);
                }

                return $avatarName;
            }
        } catch (Exception $e) {
            throw new Exception(trans('messages.error.upload_file_error'));
        }
    }

    public function updateAvatar($oldPath, $file)
    {
        try {
            $imageSytemsPath = public_path() . config('common.path_image_system') .
                config('common.user.avatar_name_default');

            if (File::exists($oldPath) && $oldPath != $imageSytemsPath) {
                unlink($oldPath);
            }

            return $this->upload($file);
        } catch (Exception $e) {
            throw new Exception(trans('messages.error.delete_file_error'));
        }
    }
}
