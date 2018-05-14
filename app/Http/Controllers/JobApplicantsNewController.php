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

        $roles = $this->getRole('en');
        $stacks = $this->getStack('en');
        $environments = $this->getEnvironment('en');
        $skills = $this->getSkill('en');
        $positions = $this->getPosition('en');
        return view('job-builder-new', compact('environments', 'stacks', 'roles', 'skills', 'positions'));
    }

    public function indexDeutsch(){

        $roles = $this->getRole('de');
        $stacks = $this->getStack('de');
        $environments = $this->getEnvironment('de');
        $skills = $this->getSkill('de');
        $positions = $this->getPosition('de');
        return view('job-builder-new-deutsch', compact('environments', 'stacks', 'roles', 'skills', 'positions'));
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

    public function getSkillJson(){

        $lang = $_GET['lang'];
        $skillEnglish = [];
        $skillGerman = [];

        $skillList = $this->client->getItems('job_builder_skills');

        if ($lang == 'en'){
            foreach ($skillList as $id => $skill){
                if ($skill->language == 'English'){
                    $skillEnglish1['id'] = $id;
                    $skillEnglish1['skill'] = $skill->key_skill;
                    array_push($skillEnglish, $skillEnglish1);
                }
            }
            return Response::json($skillEnglish, 200);
        }
        else if($lang == 'de'){
            foreach ($skillList as $skill){
                if ($skill->language == 'German'){
                    $skillGerman[$skill->key_skill] = $skill->key_skill;
                }
            }
            return Response::json($skillGerman, 200);
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


    public function getStack($lang){

        $stackEnglish = [];
        $stackGerman = [];

        $stackList = $this->client->getItems('job_builder_stack');
        if ($lang == 'en'){
            foreach ($stackList as $stack){
                if ($stack->language == 'English'){
                    $stackEnglish[$stack->stack] = $stack->stack;
                }
            }
            return $stackEnglish;
        }
        else if($lang == 'de'){
            foreach ($stackList as $stack){
                if ($stack->language == 'German'){
                    $stackGerman[$stack->stack] = $stack->stack;
                }
            }
            return $stackGerman;
        }
    }


    public function getRole($lang){

        $roleEnglish = [];
        $roleGerman = [];

        $roleList = $this->client->getItems('job_builder_role');
        if ($lang == 'en'){
            foreach ($roleList as $role){
                if ($role->language == 'English'){
                    $roleEnglish[$role->role] = $role->role;
                }
            }
            return $roleEnglish;
        }
        else if($lang == 'de'){
            foreach ($roleList as $role){
                if ($role->language == 'German'){
                    $roleGerman[$role->role] = $role->role;
                }
            }
            return $roleGerman;
        }
    }

    public function postJobApplication(Request $request){

        $requestData = $request->all();

        print_r($requestData);
        exit;

        $data['industry'] = $requestData['industry'][0];
        $data['first_name'] = $requestData['first_name'];
        $data['last_name'] = $requestData['last_name'];
        $data['email'] = $requestData['email'];
        $data['location'] = $requestData['country'];
        $data['position'] = $requestData['position'];
        $key_skills[] =  [ 'language' => 'English', 'key_skill' => $requestData['key_skills']];//$requestData['key_skills'];
        $data['key_skills'] =  $requestData['key_skills'];
        $data['environment'] = $requestData['environment'];
        $data['salary_expectation'] = $requestData['budget_slider'];
        $data['role'] = $requestData['role'];
        $data['stack'] = $requestData['stack'];
        $file = $requestData['resume'];
        $data['work_permit'] = $requestData['permit'];

        $filobj = new \Directus\SDK\File($file->getpathName(), []);
        $fileUploaded = $this->client->createFile($filobj);
        $data['resume'] = $fileUploaded['id'];

        try {
            $newRequest = $this->client->createItem('job_builder', $data);

            if (isset($newRequest['id'])){
                return redirect()->back()->with('success-message', 'Application saved successfully.');
//                return Response::make('Record created successfully.', 200);
            }
            else{
                return redirect()->back()->with('error-message', 'Application could not be saved successfully.');
//                return Response::make('Record failed to create.', 200);
            }
        }
        catch (\Exception $e) {
            return Response::make($e->getMessage(), 422);
        }
    }
}
