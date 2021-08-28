<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MovieReview extends Model
{
    protected $table = 'movie_review';

    protected $guarded = [];

    public function getPoster()
    {
        return asset('storage/app/movie/'. $this->image);
    }

    public static function getReviews($params)
    {
        $userQuery = static::query();

        if(isset($params['order']) && ($order = $params['order'])) {
            if(is_array($order)) foreach ($order as $sortKey => $ord) {
                $userQuery->orderBy($sortKey, str_replace($sortKey." ", "",$ord));
            }
        }
        
        $perPage = 1000;

        return $userQuery->paginate($perPage);
    }

}