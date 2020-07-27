<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Stock;
use App\Models\Review;
use App\Models\Favorite;
use App\Models\Language;
use App\Models\Department;
use App\Models\UserDetail;
use App\Traits\RakutenApi;
use Illuminate\Support\Facades\DB;
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

    public function index(): View
    {
        return view('book-review.index');
    }

    public function showUserPage(AchievementService $achievementService, Favorite $favorite, int $userId): View
    {
        $user = User::findOrFail($userId)->getUser(Auth::id());
        $userReviewsCount = $user->reviews()->count();
        $achievement = $achievementService->getAchievement($user->reviews_count);
        $reviews = $this->review->getReviews($userId);
        $stocks = $this->stock->getStockBooks($userId);
        $authFavorited = $favorite->checkFavoriteDone($userId);
        $languages = Language::pluck('name', 'id');
        $departments = Department::pluck('name', 'id');
        $userProfile = $this->userDetail->getByUserProfile($userId);
        return view('book-review.user', compact(
                    'user',
                    'reviews',
                    'achievement',
                    'stocks',
                    'authFavorited',
                    'languages',
                    'departments',
                    'userProfile'
                ));
    }

    public function showMypage(AchievementService $achievementService): View
    {
        $user = User::findOrFail(Auth::id())->getUser(Auth::id());
        $userReviewsCount = $user->reviews()->count();
        $achievement = $achievementService->getAchievement($user->reviews_count);
        $reviews = $this->review->getReviews(Auth::id());
        $stocks = $this->stock->getStockBooks(Auth::id());
        $languages = Language::pluck('name', 'id');
        $departments = Department::pluck('name', 'id');
        $userProfile = $this->userDetail->getByUserProfile(Auth::id());
        return view('book-review.user', compact(
                    'user',
                    'reviews',
                    'achievement',
                    'stocks',
                    'languages',
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
        return view('book-review.detail', compact('reviews', 'book', 'isMyReview', 'isMyStock'));
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
        return view('book-review.stockList');
    }
}
