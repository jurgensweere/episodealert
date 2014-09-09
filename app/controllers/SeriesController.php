<?php namespace EA\controllers;

use BaseController;
use Response;
use EA\models\Series;

class SeriesController extends BaseController
{
    public function getSeries($uniqueName){
      return Response::json(Series::where('unique_name', $uniqueName)->first());
    }

    public function getByGenre($genre){
        return Response::json(Series::where('category', 'like', '%' . $genre . '%')->take(50)->get());
    }

    public function top()
    {
        // TODO: Make this select top (followed or trending?) series, instead of the first 5
        return Response::json(Series::take(5)->get());
    }

    public function search($query)
    {
        return Response::json(Series::where('name', 'like', '%' . $query . '%')->take(50)->get());
    }

}
