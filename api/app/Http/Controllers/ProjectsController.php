<?php
namespace App\Http\Controllers;
use App\Projects;
use Illuminate\Http\Request;






class ProjectsController extends Controller
{
   

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
            } catch(\Exception $e){

                $response = [
                    "Succesfull"=>false,
                    "Error"=>$e->getMessage(),
                    "Code"=>500
                ];
                return response()->json($response, 500);
            }       
            
                


        

        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function show(Projects $projects)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Projects $projects)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function destroy(Projects $projects)
    {
        //
    }
}
