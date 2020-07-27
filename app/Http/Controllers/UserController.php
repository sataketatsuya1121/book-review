<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use App\Models\UserDetail;
use App\Http\Requests\UserRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    private $user;
    private $userDetail;

    public function __construct(User $user, UserDetail $userDetail)
    {
        $this->user = $user;
        $this->userDetail = $userDetail;
    }

    public function updateUser(UserRequest $request, int $userId): RedirectResponse
    {
        if (!empty($request->file('avatar'))) {
            $avatarPath = Storage::disk('s3')->putFile('/book-review', $request->file('avatar'));
            $this->user->find(Auth::id())->update(['avatar' => Storage::disk('s3')->url($avatarPath)]);
        }
        if (!empty($request->file('header'))) {
            $headerPath = Storage::disk('s3')->putFile('/book-review', $request->file('header'));
            $this->user->find(Auth::id())->update(['header' => Storage::disk('s3')->url($headerPath)]);
        }
        $userInfos = $request->all();
        $this->userDetail->updateUserInfos($userInfos, $userId);
        $this->user->find($userId)->fill($userInfos)->save();
        return redirect()->route('mypage');
    }

    public function destroyUser(): RedirectResponse
    {
        $this->user->destroyUserInfo();
        return redirect()->route('review');
    }

    public function showUserList(Request $request): View
    {
        $departments = Department::pluck('name', 'id');
        $authUser = $this->user->getAuthUser();
        if(empty($request->all())) {
            $userInfos = $this->user->getUserByFavorite($authUser->favorites);
        } else {
            $userInfos = $this->user->getUserBySearch($request);
        }
        $usersRanking = $this->user->getUserRanking();
        $frontUsersRanking = $this->user->getUserRanking(config('const.department_name.FRONT'));
        $backUsersRanking = $this->user->getUserRanking(config('const.department_name.BACK'));
        $salesUsersRanking = $this->user->getUserRanking(config('const.department_name.SALES'));
        return view('book-review.userList', compact(
                    'request',
                    'departments',
                    'authUser',
                    'userInfos',
                    'usersRanking',
                    'frontUsersRanking',
                    'backUsersRanking',
                    'salesUsersRanking'
                ));
    }
}
