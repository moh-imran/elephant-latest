<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use directus;

class CommonController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){

        $heroSlides = $this->client->getItems('hero_slideshow');
        $socialFeeds = $this->client->getItems('social_feeds');
        $newsTickerString = $this->getNews('en');
//        print_r($heroSlides);
//        exit();
        return view("index", ["slides" => $heroSlides, "feeds" => $socialFeeds, "newsList" => $newsTickerString ]);

    }

    //// Deutsch language

    public function indexDeutsch(){

        $heroSlides = $this->client->getItems('hero_slideshow');
        $socialFeeds = $this->client->getItems('social_feeds');
        $newsTickerString = $this->getNews('de');

        return view("index-deutsch", ["slides" => $heroSlides, "feeds" => $socialFeeds, "newsList" => $newsTickerString ]);

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

    public function sendEmail(Request $request){

        $data = $request->validate(
            [

                'name' => 'required',
                'email' => 'required | email',
                'message' => 'required'
            ]
        );

        try {
            $newRequest = $this->client->createItem('contact_us', $data);

            if (isset($newRequest['id'])){
                //echo 'Message sent successfully.';
                return 1;
            }
            else{
                echo 'Message could not be sent successfully.';
            }
        }
        catch (\Exception $e) {
            echo 'Message could not be sent successfully.';
        }
    }

}
