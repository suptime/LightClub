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

/******************************************************************************************/

//会员注册
Route::get('user/register', ['uses' => 'Auth\AuthController@getRegister']);
Route::post('user/register', ['uses' => 'Auth\AuthController@postRegister']);
//会员登录
Route::get('user/login', ['uses' => 'Auth\AuthController@getLogin']);
Route::post('user/login', ['uses' => 'Auth\AuthController@postLogin']);

//会员退出
Route::get('user/logout', ['uses' => 'Auth\AuthController@getLogout']);

//用户个人中心
Route::get('space/{uid}', ['uses' => 'UserController@userSpace'])->where('uid', '[0-9]+');
Route::get('reply/{uid}', ['uses' => 'UserController@userReply'])->where('uid', '[0-9]+');

//验证用户是否已登录
Route::group(['middleware' => 'verifyLogin'], function () {
    Route::any('user/setting', ['uses' => 'UserController@userInfoSetting']);   //个人资料设置
    Route::post('attachment/upload', ['uses' => 'UploadController@uploadfile']);    //附件上传
    Route::get('user/collection', ['uses' => 'UserController@collectionList']);   //个人收藏夹

    Route::any('topic/update/{tid}', ['uses' => 'TopicController@update'])->where('tid', '[0-9]+'); //修改帖子
    Route::get('topic/remove/{tid}', ['uses' => 'TopicController@adminTopicRemove'])->where('tid', '[0-9]+');   //删除帖子

    Route::get('comment/remove/{id}', ['uses' => 'CommentController@remove'])->where('id', '[0-9]+');   //删除回帖
    Route::post('comment/upvote', ['uses' => 'CommentController@upvote']);  //点赞

    Route::post('collection/change', ['uses' => 'CollectionController@changeCollection']);

    Route::get('admin/topic/remove/{tid}', ['uses' => 'TopicController@adminTopicRemove'])->where('tid', '[0-9]+'); //后台删除帖子
    Route::get('admin/topic/examine/{tid}/{operate}', ['uses' => 'TopicController@adminTopicExamine'])->where(['tid' => '[0-9]+', 'operate' => '[a-z]+' ]);     //后台审核,加精,置顶操作
    Route::get('admin/topic/list', ['uses' => 'TopicController@adminTopicList']);   //后台帖子列表

    Route::get('admin/category/list', ['uses' => 'CategoryController@index']);
    Route::any('admin/category/add', ['uses' => 'CategoryController@add']);
    Route::any('admin/category/update/{cid}', ['uses' => 'CategoryController@update'])->where('cid', '[0-9]+');
    Route::get('admin/category/remove/{cid}', ['uses' => 'CategoryController@remove'])->where('cid', '[0-9]+');

});

/******************************************************************************************/

Route::any('topic/add', ['uses' => 'TopicController@add']);
Route::get('topic/{tid}', ['uses' => 'TopicController@detail'])->where('tid', '[0-9]+');

Route::any('comment/add', ['uses' => 'CommentController@addReply']);











