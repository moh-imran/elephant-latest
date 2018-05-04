<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use directus;
use TwitterAPIExchange;
use LinkedIn\AccessToken;
use LinkedIn\Client;
use LinkedIn\Scope;


class CommonController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){

        $heroSlides = $this->client->getItems('hero_slideshow');
        $socialFeeds = $this->client->getItems('social_feeds');
        $newsTickerString = $this->getNews('en');
        $homeContent = $this->getHomeContent('en');

       // print_r($homeContent);
       // exit();
        return view("index", ["slides" => $heroSlides, "feeds" => $socialFeeds, "newsList" => $newsTickerString, 'homeContent' => $homeContent[0],  'homeImages' => $homeContent[1]]);

    }

    //// Deutsch language

    public function indexDeutsch(){

        $heroSlides = $this->client->getItems('hero_slideshow');
        $socialFeeds = $this->client->getItems('social_feeds');
        $newsTickerString = $this->getNews('de');
        $homeContent = $this->getHomeContent('de');
        
        return view("index-deutsch", ["slides" => $heroSlides, "feeds" => $socialFeeds, "newsList" => $newsTickerString, 'homeContent' => $homeContent[0],  'homeImages' => $homeContent[1] ]);

    }

    public function getNews($lang){

         $newsTickers = $this->client->getItems('news_ticker');
         $newsTickerString = '';
         foreach($newsTickers as $newsTicker) {

             if( $lang == 'de'){                
                 $newsTickerString = $newsTickerString . $newsTicker['translations'][0]['news'] . ',';
             }
             else{
                 $newsTickerString = $newsTickerString . $newsTicker->translations[0]->news . ',';
             }

         }
        $newsTickerString = rtrim($newsTickerString, ',');
         return $newsTickerString;

    }


    public function getHomeContent($lang = ''){

        $data = $this->client->getItems('home');

        if( $lang == 'de'){

                        $data = $data[0]['translations'][1];
                        $data1['block_1_image'] = env('API_URL').($this->client->getFile($data['block_1_image'])['url']);                        
                        $data1['block_2_image'] = env('API_URL').($this->client->getFile($data['block_2_image'])['url']);
                        $data1['block_3_image'] = env('API_URL').($this->client->getFile($data['block_3_image'])['url']);                        
                 return [$data, $data1];
             }
             else{

                        $data = $data[0]['translations'][0];
                        
                        $data1['block_1_image'] = env('API_URL').($this->client->getFile($data['block_1_image'])['url']);                        
                        $data1['block_2_image'] = env('API_URL').($this->client->getFile($data['block_2_image'])['url']);
                        $data1['block_3_image'] = env('API_URL').($this->client->getFile($data['block_3_image'])['url']);

                 return [$data, $data1];
             }
        
        // return $data[0]['translations'];

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

    public function getTweets(){

        $settings = array(
            'oauth_access_token' => env('OAUTH_ACCESS_TOKEN'),
            'oauth_access_token_secret' => env('OAUTH_ACCESS_TOKEN_SECRET'),
            'consumer_key' => env('CONSUMER_KEY'),
            'consumer_secret' => env('CONSUMER_SECRET')
        );

        $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";

        $getfield = '?username='.env('TWITTER_HANDLE').'&count=10';
        $requestMethod = 'GET';
        $twitter = new TwitterAPIExchange($settings);
          $tweets =  json_decode($twitter->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest(), true);

        foreach ($tweets as $tweet){
            // print_r($tweet['text']);
            // print_r($tweet['user']['name']); 

            
            $data['social_user'] = $tweet['user']['name'];
            $data['message'] = $tweet['text'];
            $data['source'] = 'Twitter';

            $response = $this->client->createItem('social_feeds', $data);

            if ($response) {
                            echo "Tweet saved successfully."."<br>";
                        }            
        }
    }



    public function getLinkedInFeeds(){

        $client = new Client(
            env('CLIENT_ID_LINKEDIN'),
            env('CLIENT_SECRET_LINKEDIN')
        );

        $client->setApiRoot('https://api.linkedin.com/v1/');
        $client->setRedirectUrl(env('REDIRECTION_URL_LINKEDIN'));

        $scopes = [
            Scope::READ_BASIC_PROFILE,
            Scope::READ_EMAIL_ADDRESS,
            Scope::MANAGE_COMPANY,
            Scope::SHARING,
        ];

        $loginUrl = $client->getLoginUrl($scopes); // get url on LinkedIn to start linking

        if(isset($_GET['code'])){

            $accessToken = $client->getAccessToken($_GET['code']);
            file_put_contents('token.json', json_encode($accessToken));
            $tokenString = file_get_contents('token.json');
            $tokenData = json_decode($tokenString, true);
            $accessToken = new AccessToken($tokenData['token'], $tokenData['expiresAt']);
            $client->setAccessToken($accessToken);

        }
        else{
           $page =  header('Location: '. $loginUrl);
           print_r($page);
           exit;
        }

        $companyUpdates = $client->get(
            'companies/18613718/updates?format=json'
        );

        foreach ($companyUpdates['values'] as $companyUpdate){           

            $data['social_user'] = $companyUpdate['updateContent']['company']['name'];
             $data['message'] = $companyUpdate['updateContent']['companyStatusUpdate']['share']['comment'];
             $data['source'] = 'LinkedIn';

            $response = $this->client->createItem('social_feeds', $data);

            if ($response) {
                        echo "LinkedIn post successfully."."<br>";
                } 
         
        }

    }

    public function getDropDownOptions(){

        $options = $this->client->getItems('job_builder_drop_down_options');
        return Response::json($options, 200);
    }

}
