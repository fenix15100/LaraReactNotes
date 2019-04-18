<?php

namespace App\Http\Controllers;

use App\Task;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        try{
            $tasks = Task::all();

            foreach ($tasks as $t){
                $projects = $t->getProject()->get();
                $relations = ['HasOne'=>['project'=>$projects]];
                $t->relations = $relations;
            }

            if (count($tasks) === 0) return response()->json($tasks, 404);

            return response()->json($tasks, 200);

        }catch(Throwable $e){

            $response = [
                "Succesfull"=>false,
                "Error"=>$e->getMessage(),
                "Code"=>500
            ];
            return response()->json($response, 500);
        }

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $prevision_finish_date = DateTime::createFromFormat('m-d-Y', $request->prevision_finish_date)
            ->format('Y-m-d');
        $payload = [
            'project_id'=>$request->project_id,
            'name'=>$request->name,
            'prevision_finish_date'=> $prevision_finish_date,
            'isCompleted'=> $request->isCompleted
        ];
        try{
            $task = new Task($payload);
            $task->save();

            return response()->json($task, 201);
        }catch(Throwable $e){

            $response = [
                "Succesfull"=>false,
                "Error"=>$e->getMessage(),
                "Code"=>500
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param String $id
     * @return Response
     */
    public function show(String $id)
    {
        try {
            if($task = Task::find($id)){
                $project = $task->getProject()->get();
                $relations = ['HasOne'=>['project'=>$project]];
                $task->relations = $relations;

                return response()->json($task,200);
            }else{
                $response = [
                    "Succesfull"=>false,
                    "Error"=>"Resource not Found",
                    "Code"=>404
                ];
                return response()->json($response, 404);
            }
        }catch (Throwable $e) {
            $response = [
                "Succesfull"=>false,
                "Error"=>$e->getMessage(),
                "Code"=>500
            ];
            return response()->json($response, 500);
        }

    }



    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param String $id
     * @return Response
     */
    public function update(Request $request,String $id)
    {
        try {
            if($task = Task::find($id)){

                foreach ($request->all() as $key => $value) {

                    if($key === 'prevision_finish_date'){
                        $prevision_finish_date = DateTime::createFromFormat('m-d-Y', $request->prevision_finish_date)
                            ->format('Y-m-d');
                        $task->$key = $prevision_finish_date;
                    }else{
                        $task->$key = $value;
                    }
                }
                $task->save();

                return response('',204);
            }else{
                $response = [
                    "Succesfull"=>false,
                    "Error"=>"Resource not Found",
                    "Code"=>404
                ];
                return response()->json($response, 404);
            }
        }catch (Throwable $e) {
            $response = [
                "Succesfull"=>false,
                "Error"=>$e->getMessage(),
                "Code"=>500
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param String $id
     * @return Response
     */
    public function destroy(String $id)
    {
        try {

            if($task = Task::where('id',$id)->first()){

                $task->delete();
                return response()->json('', 204);
            }else{
                $response = [
                    "Succesfull"=>false,
                    "Error"=>"Resource not Found",
                    "Code"=>404
                ];
                return response()->json($response, 404);
            }
        }catch (Throwable $e) {
            $response = [
                "Succesfull"=>false,
                "Error"=>$e->getMessage(),
                "Code"=>500
            ];
            return response()->json($response, 500);
        }

    }
}
