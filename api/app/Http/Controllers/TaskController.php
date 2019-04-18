<?php

namespace App\Http\Controllers;

use App\Task;
use DateTime;
use Illuminate\Http\Request;
use Throwable;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $prevision_finish_date = DateTime::createFromFormat('m-d-Y', $request->prevision_finish_date)
            ->format('Y-m-d');
        $payload = [
            'project_id'=>$request->project_id,
            'name'=>$request->name,
            'prevision_finish_date'=> $request->prevision_finish_date,
            'isCompleted'=> $request->$prevision_finish_date
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
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
