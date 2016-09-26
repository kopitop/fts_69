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

    public function upload($fileName)
    {
        try {
            if (!is_null($fileName)) {
                $avatarName = uniqid() . '.' . $fileName->getClientOriginalExtension();
                $path = public_path() . config('common.user.avatar_url');
                $pathAvatar = $path . $avatarName;

                if (!File::exists($pathAvatar)) {
                    $fileName->move($path, $avatarName);
                }

                return $avatarName;
            }
        } catch (Exception $e) {
            throw new Exception(trans('messages.error.upload_file_error'));
        }
    }

    public function updateAvatar($oldPath, $fileName)
    {
        try {
            $imageSytemsPath = public_path() . config('common.path_image_system') .
                config('common.user.avatar_name_default');

            if (!File::exists($oldPath) && $oldPath != $imageSytemsPath) {
                $fileName->delete($oldPath);
            }

            $this->upload($fileName);
        } catch (Exception $e) {
            throw new Exception(trans('messages.error.delete_file_error'));
        }
    }
}
