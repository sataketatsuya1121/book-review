<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Stock;
use App\Models\Review;
use App\Models\Favorite;
use App\Models\Department;
use App\Models\UserDetail;
use App\Traits\RakutenApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\BookReviewService;
use Illuminate\Contracts\View\View;
use App\Services\AchievementService;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\BookReviewRequest;

class BookReviewController extends Controller
{
    use RakutenApi;

    private $book;
    private $stock;
    private $review;
    private $userDetail;

    public function __construct(Book $book, Stock $stock, Review $review, UserDetail $userDetail)
    {
        $this->book = $book;
        $this->stock = $stock;
        $this->review = $review;
        $this->userDetail = $userDetail;
    }

    public function index(BookReviewService $bookReviewService): View
    {
        $reviewedBooks = $this->review->getReviewGroupByIsbn(config('const.book_review.LIMIT_BOOK'));
        return view('book-review.index', compact('reviewedBooks'));
    }

    public function showResult(Request $request, string $category, BookReviewService $bookReviewService): View
    {
        if ($category === 'review') {
            $reviewedBooks = $this->review->getReviewGroupByIsbn();
            return view('book-review.result', compact('category', 'reviewedBooks'));
        } else {
            $queryParams = $request->all();
            return view('book-review.result', compact('category', 'queryParams'));
        }
    }

    public function showUserPage(AchievementService $achievementService, Favorite $favorite, int $userId): View
    {
        $user = User::findOrFail($userId)->getUser(Auth::id());
        $achievement = $achievementService->getAchievement($user->reviews_count);
        $authFavorited = $favorite->checkFavoriteDone($userId);
        $departments = Department::pluck('name', 'id');
        $userProfile = $this->userDetail->getByUserProfile($userId);
        return view('book-review.user', compact(
                    'user',
                    'achievement',
                    'authFavorited',
                    'departments',
                    'userProfile'
                ));
    }

    public function showMypage(AchievementService $achievementService): View
    {
        $user = User::findOrFail(Auth::id())->getUser(Auth::id());
        $achievement = $achievementService->getAchievement($user->reviews_count);
        $departments = Department::pluck('name', 'id');
        $userProfile = $this->userDetail->getByUserProfile(Auth::id());
        return view('book-review.user', compact(
                    'user',
                    'achievement',
                    'departments',
                    'userProfile'
                ));
    }

    public function showDetailPage(string $isbn): View
    {
        $reviews = $this->review->sortByReviews($isbn);
        $book = $this->fetchRakutenApiByIsbn($isbn);
        $isMyReview = $reviews->contains('user_id', Auth::id());
        $isMyStock = $this->stock->isStockBook(Auth::id(), $isbn);
        $isRecomend = $this->userDetail->isRecomendBook(Auth::id(), $isbn);
        $hasRecomend = $this->userDetail->hasRecomendBook(Auth::id());
        return view('book-review.detail', compact('reviews', 'book', 'isMyReview', 'isMyStock', 'isRecomend', 'hasRecomend'));
    }

    public function storeBookReview(
        BookReviewRequest $request,
        AchievementService $achievementService,
        NotificationService $notificationService
    ): RedirectResponse
    {
        $inputs = $request->all();
        $inputs['user_id'] = Auth::id();
        DB::transaction(function () use ($inputs, $request) {
            $this->review->fill($inputs)->save();
            if (!$this->book->isRequestIsbn($request->ISBN)) {
                $books = $this->fetchRakutenApiByIsbn($request->ISBN);
                $this->book->storeBook($books);
            }
        });

        // レビュー回数が到達点に達したらメール送信
        $user = User::findOrFail(Auth::id());
        $userReviewsCount = $user->reviews()->count();
        $achievementService->checkAchievement($userReviewsCount);

        // 全てのユーザーにメール通知
        $notificationService->mailReviewUsers();
        return redirect()->route('detail', $request->ISBN);
    }

    public function updateBookReview(BookReviewRequest $request, int $reviewId): RedirectResponse
    {
        $inputs = $request->all();
        $this->review->updateReview($reviewId, $inputs);
        return redirect()->route('mypage');
    }

    public function destroyBookReview(BookReviewService $bookReviewService, int $reviewId): RedirectResponse
    {
        $targetReview = $this->review->find($reviewId);
        DB::transaction(function () use ($targetReview, $bookReviewService) {
            $bookReviewService->checkDeleteBook($targetReview->ISBN);
            $targetReview->delete();
        });
        return redirect()->route('mypage');
    }

    public function showRankingPage(): View
    {
        return view('book-review.ranking');
    }

    public function showNewBookPage(): View
    {
        return view('book-review.newBook');
    }

    public function showStockListPage(): View
    {
        $stocks = $this->stock->getStockBooks(Auth::id());
        return view('book-review.stockList', compact('stocks'));
    }
}
