<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Department;
use App\Models\User;
use App\Models\UserDetail;
use App\Http\Requests\UserDetailRequest;
use App\Http\Requests\UserRequest;
use App\Traits\RakutenApi;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use RakutenApi;

    private $user;
    private $userDetail;

    public function __construct(User $user, UserDetail $userDetail)
    {
        $this->user = $user;
        $this->userDetail = $userDetail;
    }

    public function showMyInfoPage()
    {
        $user = $this->userDetail->hasUserId(Auth::id());
        if ($user) {
            return redirect()->route('review');
        }
        $departments = Department::pluck('name', 'id');
        return view('auth.registerMyInfo', compact('departments'));
    }

    public function createMyInfo(UserDetailRequest $request): RedirectResponse
    {
        $userInfos = $request->all();
        $userInfos['user_id'] = Auth::id();
        $this->userDetail->fill($userInfos)->save();
        return redirect()->route('review');
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

    /**
     * Ajax非同期通信でおすすめ本を登録
     *
     * @param Book $book
     * @param string $isbn
     * @return JsonResponse
     */
    public function storeRecommend(Book $book, string $isbn): JsonResponse
    {
        $recommend = $this->fetchRakutenApiByIsbn($isbn);
        $userInfos['ISBN'] = $recommend['isbn'];
        $this->userDetail->updateUserInfos($userInfos, Auth::id());
        if (!$book->isHasIsbn($isbn)) {
            $book->storeBook($recommend);
        }
        return response()->json($recommend);
    }

    /**
     * ユーザーのおすすめ本のISBNを確認してISBNがなかったらエラーハンドル
     * ISBNがあったらおすすめ本から削除
     *
     * @param string $isbn
     * @return void
     */
    public function destroyRecommend(string $isbn)
    {
        if (!$this->userDetail->checkRecommendDone($isbn)) {
            return config('const.abort');
        }
        $recommend = $this->fetchRakutenApiByIsbn($isbn);
        $this->userDetail->destroyRecommendInfo($isbn);
        return response()->json($recommend);
    }
}
