<?php

namespace App\Services;

class BookReviewApiService
{
    /**
     * ISBNを配列にまとめる
     *
     * @param Request $request
     * @return array
     */
    public function revertIsbnToArray($request): array
    {
        $books = $request->books;
        foreach ($books as $i => $book) {
            $isbnArray[$i] = (int)$book['Item']['isbn'];
        }
        return $isbnArray;
    }

    /**
     * レビュー件数をAPIにセット
     *
     * @param Collection $reviewsGroupedByIsbn
     * @param array $isbnArray
     * @return array
     */
    public function setReviewCount($reviewsGroupedByIsbn, array $isbnArray): array
    {
        $reviewArray = [];
        foreach ($reviewsGroupedByIsbn as $isbn => $reviews) {
            $reviewArray[$isbn] = count($reviews);
        }
        foreach ($isbnArray as $isbn) {
            if (!array_key_exists($isbn, $reviewArray)) {
                $reviewArray[$isbn] = 0;
            }
        }
        return $reviewArray;
    }

    /**
     * レビューの平均評価をAPIにセット
     *
     * @param Collection $evlGroupedByIsbn
     * @param array $isbnArray
     * @return array
     */
    public function setReviewEvaluation($evlGroupedByIsbn, array $isbnArray): array
    {
        $avgEvlArray = [];
        foreach ($evlGroupedByIsbn as $isbn => $reviews) {
            $avgEvl = collect($reviews)->pluck('evaluation')->avg();
            $avgEvlArray[$isbn] = round($avgEvl);
        }
        foreach ($isbnArray as $isbn) {
            if (!array_key_exists($isbn, $avgEvlArray)) {
                $avgEvlArray[$isbn] = 0;
            }
        }
        return $avgEvlArray;
    }
}
