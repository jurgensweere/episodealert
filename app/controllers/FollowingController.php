<?php namespace EA\controllers;

use BaseController;
use Response;
use EA\models\Series;
use EA\models\Following;
use EA\models\User;
use Auth;

class FollowingController extends BaseController
{
    public function follow($series_id){

    	if(Auth::user()){
    		$user_id = Auth::user()->id;

    		$followingCheck = Following::where('series_id', $series_id)->where('user_id', $user_id)->count();

    		if(!$followingCheck){

	    		$following = new Following;
	    		$following->series_id = $series_id;
	    		$following->user_id = $user_id;

	    		if($following->save()){
					return Response::json(array('follow' => 'success'));    			
	    		}else{
	    			return Response::json(array('follow' => 'fail to save'));
	    		}
	    	}else{
				return Response::json(array('follow' => 'allready following'));	    		
	    	}
	    	
	    }else{
	    	return Response::json(array('follow' => 'fail unauthorized'));
	    }

    }

    public function unfollow($series_id){
		if(Auth::user()){

			$user_id = Auth::user()->id;
			$unfollow = Following::where('series_id', $series_id)->where('user_id', $user_id)->delete();
			
			if($unfollow){
				return Response::json(array('follow' => 'unfollow'));  
			}
		}else{

	    	return Response::json(array('follow' => 'fail unauthorized'), 500);

	    }

    }

    public function getFollowingSeries(){
    	$user = Auth::user();
    	if($user){

    		return Response::json(
				Following::where('user_id', $user->id)
				->select('following.archive', 'series.*')
				->join('series', 'following.series_id', '=', 'series.id')
				->get()					

				);

    	}else{
    		return Response::json(array('flash' => 'Unauthorized, please login'));
    	}
    	
    }

}
