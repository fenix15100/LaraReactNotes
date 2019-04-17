<?php
namespace App\Http\Controllers;
use App\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;





class ProjectsController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $projects = Projects::all();

            if (count($projects)===0) return response()->json($projects, 404);

            return response()->json($projects, 200);

        }catch(\Throwable $e){

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
            
            $start_date = \DateTime::createFromFormat('m-d-Y', $request->start_date)
                                        ->format('Y-m-d');
            
            
            if($request->finish_date === null){
                $finish_date = $request->finish_date;
            } else{
                $finish_date = \DateTime::createFromFormat('m-d-Y', $request->finish_date)
                                    ->format('Y-m-d');
            }
            
            $payload = [
                'project_id'=>$request->project_id,
                'name'=>$request->name,
                'description'=>$request->description,
                'start_date'=> $start_date,
                'finish_date'=> $finish_date
            ];
            try{
                $project = new Projects($payload);
                $project->save();

                return response()->json($project, 201);
            }catch(\Throwable $e){

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
     * @param  \String  $project_id
     * @return \Illuminate\Http\Response
     */
    public function show(String $project_id)
    {
        try {
            
            if($project = Projects::where('project_id',$project_id)->first()){

                return response()->json($project, 200);
            }else{
                $response = [
                    "Succesfull"=>false,
                    "Error"=>"Resource not Found",
                    "Code"=>404
                ];
                return response()->json($response, 404);  
            }
        }catch (\Throwable $e) {
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \String $project_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, String $project_id)
    {
      #TODO Implementar JSON PATCH porque esta chulo
      #https://github.com/mikemccabe/json-patch-php/blob/master/src/JsonPatch.php 
        try {
            
            if($project = Projects::where('project_id',$project_id)->first()){

                foreach ($request->all() as $key => $value) {

                    if($key === 'project_id') continue;
                    $project->$key = $value;
                }
                $project->save();

                return response('',204);
            }else{
                $response = [
                    "Succesfull"=>false,
                    "Error"=>"Resource not Found",
                    "Code"=>404
                ];
                return response()->json($response, 404);  
            }
        }catch (\Throwable $e) {
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
     * @param  \App\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $project_id)
    {
        try {
            
            if($project = Projects::where('project_id',$project_id)->first()){

                $project->delete();
                return response()->json('', 204);
            }else{
                $response = [
                    "Succesfull"=>false,
                    "Error"=>"Resource not Found",
                    "Code"=>404
                ];
                return response()->json($response, 404);  
            }
        }catch (\Throwable $e) {
            $response = [
                "Succesfull"=>false,
                "Error"=>$e->getMessage(),
                "Code"=>500
            ];
            return response()->json($response, 500);  
        }
        
        
    }
}
