<?php

/** @var \Laravel\Lumen\Routing\Router $router */
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(["prefix" => 'api'], function() use($router){

    // Registration
    $router->post('/registration', ['as' => 'registration', 'uses' => 'AuthController@registration']);  

    // Login
    $router->post('/login', ['as' => 'login', 'uses' => 'AuthController@login']);

    $router->group(['middleware' => 'auth'], function() use($router) {

        $router->get('/logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);

        // Route Student
        $router->group(["prefix" => 'student'], function() use($router) {
    
            // Index, get all data
            $router->get('/', ['as' => 'student', 'uses' => 'StudentController@index']);

            $router->get('/options', ['as' => 'options', 'uses' => 'StudentController@option']);

            // Route for view detail
            $router->get("/{id}", ["as" => "student_detail", "uses" => "StudentController@view"]);

            // for post / insert data student
            $router->post('add', ['as' => 'student', 'uses' => "StudentController@store"]);

            // for update data student
            $router->patch('update/{id}', ['as' => 'student', 'uses' => "StudentController@update"]);

            $router->delete("/{id}", ['as' => 'student', 'uses' => "StudentController@delete"]);
    
    
        });

        // Hobby Route
        $router->group(['prefix' => 'hobby'], function() use($router){
            $router->get('/', ['as' => 'hobbies', 'uses' => 'HobbyController@index']);
            $router->get('/options', ['as' => 'options', 'uses' => 'HobbyController@option']);
            $router->get('/{id}', ['as' => 'hobby', 'uses' => 'HobbyController@show']);
            $router->post('/add', ['as' => 'add_hobby', 'uses' => 'HobbyController@store']);
            $router->patch('/update/{id}', ['as' => 'update_hobby', 'uses' => 'HobbyController@update']);
            $router->delete('/delete/{id}', ['as' => 'delete_hobby', 'uses' => 'HobbyController@delete']);
        });

        // Student Hobby Route
        $router->group(['prefix' => 'student-hobby'], function() use($router){
            $router->get("/", ['as' => 'get_student_hobby', 'uses' => 'StudentHobbyController@index']);
            $router->get("/{id}", ["as" => 'detail_student_hobby', "uses" => "StudentHobbyController@show"]);
            $router->post('/add', ['as' => 'add_student_hobby', 'uses' => 'StudentHobbyController@store']);
            $router->patch('/update/{id}', ['as' => 'update_student_hobby', 'uses' => 'StudentHobbyController@update']);
            $router->delete("/delete/{id}", ['as' => 'delete_student_hobby', 'uses' => 'StudentHobbyController@delete']);
        });

    });

});
