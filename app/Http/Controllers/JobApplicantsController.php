<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use directus;

class JobApplicantsController extends Controller
{

    public function __construct(){

        parent::__construct();
    }

     public function postJob(Request $request){


         $data = $request->all();

         $data['industry'] = implode(",", $data['industry']);
         $data['key_skills'] = implode(",", $data['key_skills']);
         $data['position'] = implode(",", $data['position']);


         try {
             $newRequest = $this->client->createItem('job_builder', $data);

             if (isset($newRequest['id'])){
                 return Response::make('Record created successfully.', 200);
             }
             else{
                 return Response::make('Record failed to create.', 200);
             }
         }
         catch (\Exception $e) {
             return Response::make($e->getMessage(), 422);
         }



     }

    public function index(){

        $newsTickerString = $this->getNews('en');
        return view("job-builder", ["newsList" => $newsTickerString ]);
    }

    public function indexDeutsch(){
        $newsTickerString = $this->getNews('de');
        return view("job-builder-deutsch", ["newsList" => $newsTickerString ]);
    }

    public function getNews($lang){

        $newsTickers = $this->client->getItems('news_ticker');
        $newsTickerString = '';
        foreach($newsTickers as $newsTicker) {

            if( $lang == 'de'){
                $newsTickerString = $newsTickerString . $newsTicker->translations[1]->news . ',';
            }
            else{
                $newsTickerString = $newsTickerString . $newsTicker->translations[0]->news . ',';
            }

        }
        $newsTickerString = rtrim($newsTickerString, ',');

        return $newsTickerString;

    }

}
