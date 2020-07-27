<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function postComment(CommentRequest $request, NotificationService $notificationService): RedirectResponse
    {
        $inputs = $request->all();
        $inputs['user_id'] = Auth::id();
        $this->comment->fill($inputs)->save();

        // レビュー投稿者にメール通知
        $userId = $this->comment->review->user_id;
        $notificationService->mailCommentUser($userId);
        return redirect()->route('detail', $inputs['ISBN']);
    }

    public function editComment(CommentRequest $request, int $commentId): RedirectResponse
    {
        $inputs = $request->all();
        $isMyComment = $this->comment->isMyComment($commentId);
        if ($isMyComment) {
            $this->comment->find($commentId)->update($inputs);
        }
        return redirect()->back();
    }

    public function destroyComment(int $commentId): RedirectResponse
    {
        $isMyComment = $this->comment->isMyComment($commentId);
        if ($isMyComment) {
            $this->comment->find($commentId)->delete();
        }
        return redirect()->back();
    }
}
