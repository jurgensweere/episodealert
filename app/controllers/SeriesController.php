<?php namespace EA\controllers;

use BaseController;
use Response;
use EA\models\Series;

class SeriesController extends BaseController
{
    public function top()
    {
        // TODO: Make this select top series, instead of the first 5
        return Response::json(Series::take(5)->get());
    }
}
