<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Review;
use App\Models\Stock;

class BookReviewService
{
    private $review;
    private $stock;
    private $book;

    public function __construct(Review $review, Stock $stock, Book $book)
    {
        $this->review = $review;
        $this->stock = $stock;
        $this->book = $book;
    }

    public function checkDeleteBook(string $isbn)
    {
        if (
            $this->review->countReviewByIsbn($isbn) === 0 && $this->stock->countStockByIsbn($isbn) === 1 ||
            $this->review->countReviewByIsbn($isbn) === 1 && $this->stock->countStockByIsbn($isbn) === 0
        ) {
            $this->book->deleteBookByIsbn($isbn);
        }
    }

    public function arrangeArrayReview($reviewedBooks): array
    {
        foreach ($reviewedBooks as $index => $reviewedBook) {
            $evlAvgrages[$index] = round($reviewedBook->pluck('evaluation')->avg(), 1);
        }
        return $evlAvgrages;
    }
}
