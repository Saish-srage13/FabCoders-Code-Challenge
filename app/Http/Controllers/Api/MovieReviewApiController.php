<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Shared\ApiController;
use App\Models\MovieReview;

class MovieReviewApiController extends ApiController
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'movie_name' => 'required|string',
            'movie_poster' => 'required|mimes:png,jpg,jpeg',
            'movie_rating' => 'required|numeric|min:0:max:10',
            'review' => 'required|string',
            'review_date' => 'required'
        ]);

        $movieReview = MovieReview::create([
            'movie_name' => $request->input('movie_name'),
            'image' => $this->uploadImage($request->file('movie_poster'), $request->input('movie_name')),
            'rating' => $request->input('movie_rating'),
            'date_of_review' => $request->input('review_date'),
            'review' => $request->input('review')
        ]);

        return $this->respondCreated($movieReview, 'Movie review added.');
        
    }

    public function getMovieReview($id)
    {
        $movieReview = MovieReview::find($id);

        if (!$movieReview) {
            return $this->respondNotFound('Movie review not found.');
        }

        $movieReview->poster_url = $movieReview->getPoster();

        return $this->respondOk($movieReview);
    }

    public function update($id, Request $request)
    {
        $movieReview = MovieReview::find($id);

        if (!$movieReview) {
            return $this->respondNotFound('Movie review not found.');
        }

        $movieReview->movie_name = $request->input('movie_name', $movieReview->movie_name);
        $movieReview->image = $request->has('movie_poster') 
            ? $this->uploadImage($request->file('movie_poster'), $request->input('movie_name'))
            : $movieReview->movie_name;
        $movieReview->rating = $request->input('movie_rating', $movieReview->rating);
        $movieReview->review = $request->input('review', $movieReview->review);
        $movieReview->date_of_review = $request->input('review_date', $movieReview->date_of_review);

        $movieReview->save();

        return $this->respondOk($movieReview, 'Movie review updated.');
    }

    public function delete($id)
    {
        $movieReview = MovieReview::find($id);

        if (!$movieReview) {
            return $this->respondNotFound('Movie review not found.');
        }

        $movieReview->delete();

        return $this->respondOk('Movie review deleted.');
    }
}