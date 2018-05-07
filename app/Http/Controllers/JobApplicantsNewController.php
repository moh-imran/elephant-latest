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

        return view('job-builder-new');
    }

    public function postJobApplication(Request $request){

        $requestData = $request->all();

//        $flag = move_uploaded_file ( $requestData['resume'] , env('APP_URL').'public/uploads/'.$requestData['resume']);
//        var_dump($request->all());
//
//        exit;

        $data['industry'] = $requestData['industry'][0];
        $data['name'] = $requestData['first_name']. $requestData['last_name'];
        $data['email'] = $requestData['email'];
        $data['location'] = $requestData['country'];
        $data['position'] = $requestData['position'];
        $data['key_skills'] = $requestData['key_skills'];
        $data['environment'] = $requestData['environment'];
        $data['salary_expectation'] = $requestData['budget_slider'];

        $file = $requestData['resume'];
        $filobj = new \Directus\SDK\File($file, []);
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
