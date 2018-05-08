<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use directus;
use Illuminate\Support\Facades\Input;
class JobApplicantsNewController extends Controller
{
    public function __construct(){

        parent::__construct();
    }


    public function index(){

        $environments = $this->getEnvironment('en');
        $skills = $this->getSkill('en');
        $positions = $this->getPosition('en');
        return view('job-builder-new', compact('environments', 'skills', 'positions'));
    }

    public function getEnvironment($lang){

        $environmentEnglish = [];
        $environmentGerman = [];

        $environmentList = $this->client->getItems('job_builder_environment');
        if ($lang == 'en'){
            foreach ($environmentList as $environment){
                if ($environment->language == 'English'){
                    $environmentEnglish[$environment->environment] = $environment->environment;
                }
            }
            return $environmentEnglish;
        }
        else if($lang == 'de'){
            foreach ($environmentList as $environment){
                if ($environment->language == 'German'){
                    $environmentGerman[$environment->environment] = $environment->environment;
                }
            }
            return $environmentGerman;
        }

    }

    public function getSkill($lang){

        $skillEnglish = [];
        $skillGerman = [];

        $skillList = $this->client->getItems('job_builder_skills');
        if ($lang == 'en'){
            foreach ($skillList as $skill){
                if ($skill->language == 'English'){
                    $skillEnglish[$skill->key_skill] = $skill->key_skill;
                }
            }
            return $skillEnglish;
        }
        else if($lang == 'de'){
            foreach ($skillList as $skill){
                if ($skill->language == 'German'){
                    $skillGerman[$skill->key_skill] = $skill->key_skill;
                }
            }
            return $skillGerman;
        }
    }

    public function getPosition($lang){

        $positionEnglish = [];
        $positionGerman = [];

        $positionList = $this->client->getItems('job_builder_position');
        if ($lang == 'en'){
            foreach ($positionList as $position){
                if ($position->language == 'English'){
                    $positionEnglish[$position->position] = $position->position;
                }
            }
            return $positionEnglish;
        }
        else if($lang == 'de'){
            foreach ($positionList as $position){
                if ($position->language == 'German'){
                    $positionGerman[$position->position] = $position->position;
                }
            }
            return $positionGerman;
        }
    }

    public function postJobApplication(Request $request){

        $requestData = $request->all();
        $data['industry'] = $requestData['industry'][0];
        $data['first_name'] = $requestData['first_name'];
        $data['last_name'] = $requestData['last_name'];
        $data['email'] = $requestData['email'];
        $data['location'] = $requestData['country'];
        $data['position'] = $requestData['position'];
        $key_skills[] =  [ 'language' => 'English', 'key_skill' => $requestData['key_skills']];//$requestData['key_skills'];
        $data['key_skills'] =  1;
        $data['environment'] = $requestData['environment'];
        $data['salary_expectation'] = $requestData['budget_slider'];
        $file = $requestData['resume'];
        $filobj = new \Directus\SDK\File($file->getpathName(), []);
        $fileUploaded = $this->client->createFile($filobj);
        $data['resume'] = $fileUploaded['id'];

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
}
