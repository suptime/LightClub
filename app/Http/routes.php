<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', ['uses' => 'CategoryController@homePage']);
Route::get('/{catdir?}', ['uses' => 'CategoryController@homeList'])->where('catdir', '[a-zA-Z0-9]*');


//会员中心路由组
Route::group(['prefix' => 'user'], function () {
    //会员注册
    Route::get('register', ['uses' => 'UserController@getRegister']);
    Route::post('register', ['uses' => 'UserController@postRegister']);

    //会员登录
    Route::get('login', ['uses' => 'UserController@getLogin']);
    Route::post('login', ['uses' => 'UserController@postLogin']);

    //会员退出
    Route::get('logout', ['uses' => 'UserController@getLogout']);

    //会员中心首页
    Route::get('home/{uid}', ['uses' => 'UserController@main'])->where('uid', '[0-9]+');
});

//TopicController
Route::any('topic/add', ['uses' => 'TopicController@add']);
Route::get('topic/{tid}', ['uses' => 'TopicController@detail'])->where('tid', '[0-9]+');
Route::post('topic/uploadfile', ['uses' => 'TopicController@uploadfile']);
Route::any('topic/update/{tid}', ['uses' => 'TopicController@update'])->where('tid', '[0-9]+');
Route::get('topic/remove/{tid}', ['uses' => 'TopicController@adminTopicRemove'])->where('tid', '[0-9]+');

Route::get('admin/topic/list', ['uses' => 'TopicController@adminTopicList']);
Route::get('admin/topic/remove/{tid}', ['uses' => 'TopicController@adminTopicRemove'])->where('tid', '[0-9]+');
Route::get('admin/topic/examine/{tid}/{operate}', ['uses' => 'TopicController@adminTopicExamine'])->where([
    'tid' => '[0-9]+',
    'operate' => '[a-z]+'
]);

//CategoryController
Route::get('admin/category/list', ['uses' => 'CategoryController@index']);
Route::any('admin/category/add', ['uses' => 'CategoryController@add']);
Route::any('admin/category/update/{cid}', ['uses' => 'CategoryController@update'])->where('cid', '[0-9]+');
Route::get('admin/category/remove/{cid}', ['uses' => 'CategoryController@remove'])->where('cid', '[0-9]+');
//Route::get('category/{catdir}',['uses'=>'CategoryController@cateList'])->where('catdir', '[a-zA-Z0-9]+');

Route::any('comment/add', ['uses' => 'CommentController@addReply']);
Route::get('comment/remove/{id}', ['uses' => 'CommentController@remove'])->where('id','[0-9]+');
Route::post('comment/upvote', ['uses' => 'CommentController@upvote']);










