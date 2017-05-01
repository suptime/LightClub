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

Route::get('topic/add', ['uses' => 'TopicController@add']);
Route::get('topic/{tid}', ['uses' => 'TopicController@detail'])->where('tid', '[0-9]+');


//需要验证用户登录后操作的路由
Route::group(['middleware' => 'verifyLogin'], function () {
    Route::post('attachment/upload', ['uses' => 'UploadController@uploadfile']);    //附件上传

    Route::any('user/setting', ['uses' => 'UserController@userInfoSetting']);   //个人资料设置
    Route::get('user/messages', ['uses' => 'MessageUserController@index']);    //私信
    Route::get('user/notice', ['uses' => 'UserController@systemMessages']);    //系统消息
    Route::post('user/notice', ['uses' => 'MessageUserController@readed']);
    Route::get('user/notice/{id}', ['uses' => 'MessageUserController@removeSystemMessage'])->where('tid', '[0-9]+');

    Route::get('user/collection', ['uses' => 'UserController@collectionList']);   //个人收藏夹
    Route::post('collection/change', ['uses' => 'CollectionController@changeCollection']);
    Route::get('user/collection/remove/{tid}&{id}', ['uses' => 'CollectionController@remove'])->where(['tid'=>'[0-9]+','id','[0-9]+']);

    Route::post('topic/add', ['uses' => 'TopicController@add']);
    Route::any('topic/update/{tid}', ['uses' => 'TopicController@update'])->where('tid', '[0-9]+'); //修改帖子
    Route::get('topic/remove/{tid}', ['uses' => 'TopicController@adminTopicRemove'])->where('tid', '[0-9]+');   //删除帖子

    Route::any('comment/add', ['uses' => 'CommentController@addReply']);
    Route::get('comment/remove/{id}', ['uses' => 'CommentController@remove'])->where('id', '[0-9]+');   //删除回帖
    Route::post('comment/upvote', ['uses' => 'CommentController@upvote']);  //点赞

    Route::get('admin/topic/remove/{tid}', ['uses' => 'TopicController@adminTopicRemove'])->where('tid', '[0-9]+'); //后台删除帖子
    Route::get('admin/topic/examine/{tid}/{operate}', ['uses' => 'TopicController@adminTopicExamine'])->where(['tid' => '[0-9]+', 'operate' => '[a-z]+' ]);     //后台审核,加精,置顶操作
    Route::get('admin/topic/list', ['uses' => 'TopicController@adminTopicList']);   //后台帖子列表

    Route::get('admin/category/list', ['uses' => 'CategoryController@index']);
    Route::any('admin/category/add', ['uses' => 'CategoryController@add']);
    Route::any('admin/category/update/{cid}', ['uses' => 'CategoryController@update'])->where('cid', '[0-9]+');
    Route::get('admin/category/remove/{cid}', ['uses' => 'CategoryController@remove'])->where('cid', '[0-9]+');

    Route::any('admin/message/add', ['uses' => 'MessageMainController@add']);
    Route::any('admin/message/list', ['uses' => 'MessageMainController@index']);



});