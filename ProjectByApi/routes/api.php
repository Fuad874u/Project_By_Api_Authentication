<?php


use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController as PostController;
use App\Http\Controllers\API\V1\PostController as PostControllerV1;
use App\Http\Controllers\API\V1\AuthController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware("auth:sanctum");   

Route::get('/posts',[PostController::class,'index']);
Route::get('/posts/{id}',[PostController::class,'show']);


Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('/posts', PostControllerv1::class)->only(['store','update','destroy']);
});

//My project starting from now 
   
Route::post('/register',[AuthController::class,'register']);
                      
Route::post('/login',[AuthController::class,'login']);
                                                
Route::get('/getData', [AuthController::class,'getData']);
                                     
Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');  
                                                                                                
                                                                             
                                                                                                   
                                                                           
                                                       
                
                 