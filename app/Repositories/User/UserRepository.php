<?php

namespace App\Repositories\User;

use Auth;
use App\Models\User;
use File;
use Storage;
use Exception;
use App\Repositories\BaseRepository;
use App\Models\Suggestion;
use App\Models\SuggestionDetail;
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

    public function deleteAvatar($fileName)
    {
        try {
            if ($fileName != config('common.user.avatar_name_default')) {
                $path = public_path() . config('common.user.avatar_url') . $fileName;

                if (File::exists($path)) {
                    unlink($path);
                }
            }
        } catch (Exception $e) {
            throw new Exception(trans('messages.error.delete_file_error'));
        }
    }

    public function destroy($user)
    {
        try {
            DB::beginTransaction();
            $suggestions = Suggestion::where('user_id', $user->id)->pluck('id');
            SuggestionDetail::whereIn('suggestion_id', $suggestions)->delete();
            $user->suggestions()->delete();
            $user->examStatuses()->delete();
            $user->examResults()->delete();
            $user->userQuestions()->delete();
            $user->delete();
            DB::commit();
            $message = trans('messages.success.delete_success', ['item' => 'user']);
        } catch (Exception $e) {
            DB::rollBack();
            $message = trans('messages.error.delete_error', ['item' => 'user']);
        }

        return $message;
    }

    public function sendEmailResetPassword($email) {
        $token = str_random(config('common.number_random_token_password_reset'));
        $now = Carbon::now();
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => $now,
        ]);
        $link = asset('reset-password/' . $token);

        try {
            Mail::send('accounts.mail', ['link' => $link], function ($message) use($email) {
                $message->to($email)->subject(trans('accounts/forgot_passwords/names.mail.subject'));
            });
            $message = trans('messages.success.send_mail_reset_password_success');
        } catch (Exception $ex) {
            $message = trans('messages.error.send_mail_reset_password_fail');
        }

        return $message;
    }

    public function checkToken($emailToken) {
        $passwordReset = DB::table('password_resets')->where('token', $emailToken)->first();
        return $passwordReset;
    }

}
