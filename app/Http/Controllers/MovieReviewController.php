<?php

namespace App\Http\Controllers;

use App\Models\MovieReview;
use Illuminate\Http\Request;

class MovieReviewController extends CBaseController
{
    public function list(Request $request)
    {
        $params = [];
        if ($where = $this->getFilters($request)) $params = $where;

        $sortLib = $this->buildSorting(route('movie_review.list'), 'id');
        $sortLib->setRoute('movie_review.list');
        $sortLib->setMapping([
                        'id' => ['id'],
                        'name' => ['name'],
                    ]);

        if (!($params['order'] = $sortLib->getSort(''))) unset($params['order']);
        
        $movieReviews = MovieReview::getReviews($params);
        
        return view('movie_review.list', [
            'sort' => $sortLib,
            'movieReviews' => $movieReviews,
        ]);
    }
}