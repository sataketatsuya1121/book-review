<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Stock;
use App\Traits\RakutenApi;
use App\Services\BookReviewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class StockController extends Controller
{
    use RakutenApi;

    private $stock;
    private $book;

    public function __construct(Stock $stock, Book $book)
    {
        $this->stock = $stock;
        $this->book = $book;
    }

    /**
     * Ajax非同期通信でリストを登録
     *
     * @param string $isbn
     * @return JsonResponse
     */
    public function storeStock(string $isbn): JsonResponse
    {
        $stock = $this->fetchRakutenApiByIsbn($isbn);
        $this->stock->ISBN = $stock['isbn'];
        $this->stock->user_id = Auth::id();
        $this->stock->save();
        if (!$this->book->isHasIsbn($isbn)) {
            $books = $this->fetchRakutenApiByIsbn($isbn);
            $this->book->storeBook($books);
        }
        return response()->json($stock);
    }

    /**
     * Ajax非同期通信でリストを削除
     *
     * @param string $isbn
     * @return JsonResponse
     */
    public function destroyStock(string $isbn): JsonResponse
    {
        $stock = $this->fetchRakutenApiByIsbn($isbn);
        $this->stock->destroyStockInfo($isbn);
        return response()->json($stock);
    }

    /**
     * マイページからのリクエストでリストを削除
     *
     * @param BookReviewService $bookReviewService
     * @param string $isbn
     * @return RedirectResponse
     */
    public function destroyMypageStock(BookReviewService $bookReviewService, string $isbn): RedirectResponse
    {
        $bookReviewService->checkDeleteBook($isbn);
        $this->stock->destroyStockInfo($isbn);
        return redirect()->route('mypage');
    }
}
