<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Las rutas dentro de este grupo pasaran por el modulo api-header y jwt, por lo que estaran protegidas por token
Route::group(['middleware' => ['jwt.auth','api-header']], function () {

  
  
    Route::resource('projects', 'ProjectsController', [
        'only' => ['index',
                   'store', 
                   'show',
                   'update',
                   'destroy']
    ]);

    Route::resource('tasks', 'TaskController', [
        'only' => ['index',
                   'store', 
                   'show',
                   'update',
                   'destroy']
    ]);


    /********************************************************************
    * 
    * Mapeo de acciones de una ruta tipo recurso
    * Route::resource('users', 'UserController'
    * 
    * Verb          Path                        Action  Route Name
    *   GET           /users                      index   users.index
    *   GET           /users/create               create  users.create
    *   POST          /users                      store   users.store
    *   GET           /users/{user}               show    users.show
    *   GET           /users/{user}/edit          edit    users.edit
    *   PUT|PATCH     /users/{user}               update  users.update
    *   DELETE        /users/{user}               destroy users.destroy
    * 
     ******************************************************************/
    
});

//Las rutas dentro de este grupo pasaran antes por el middleware api-header
//Que inyecta las cabezeras Cross Origin para que la API se consumida por terceros
//El Login y el registro de usuarios no debe estar protegido ya que en esta fase aun no se tiene un token
Route::group(['middleware' => 'api-header'], function () {
  
    
    Route::post('user/login', 'UserController@login');
    Route::post('user/register', 'UserController@register');
});
