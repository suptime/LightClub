<?php
/**
 * 应用程序路由规则
 */

Route::get('/{catdir?}', ['uses' => 'CategoryController@homeList'])->where('catdir', '[a-zA-Z0-9]*');

//帖子搜索
Route::get('/search/{keyword?}', ['uses' => 'TopicController@topicSearch']);

/******************************************************************************************/

//会员注册
Route::get('user/register', ['uses' => 'Auth\AuthController@getRegister']);
Route::post('user/register', ['uses' => 'Auth\AuthController@postRegister']);

//会员登录
Route::get('user/login', ['uses' => 'Auth\AuthController@getLogin']);
Route::post('user/login', ['uses' => 'Auth\AuthController@postLogin']);

//会员退出
Route::get('user/logout', ['uses' => 'Auth\AuthController@getLogout']);

//用户个人空间
Route::get('space/{uid}', ['uses' => 'UserController@userSpace'])->where('uid', '[0-9]+');

//用户个人收藏
Route::get('reply/{uid}', ['uses' => 'UserController@userReply'])->where('uid', '[0-9]+');

//添加帖子独立表单页
Route::get('topic/add', ['uses' => 'TopicController@add']);

//帖子详情页
Route::get('topic/{tid}', ['uses' => 'TopicController@detail'])->where('tid', '[0-9]+');

Route::get('auth/geetest','ConfigController@getGeetest');


//需要验证用户登录后操作的路由
Route::group(['middleware' => 'verifyLogin'], function () {

    //附件上传: 图片
    Route::post('attachment/upload', ['uses' => 'UploadController@uploadfile']);

    //个人资料设置
    Route::any('user/setting', ['uses' => 'UserController@userInfoSetting']);

    //系统消息
    Route::get('user/notice', ['uses' => 'UserController@systemMessages']);
    Route::post('user/notice', ['uses' => 'MessageUserController@readed']);
    Route::get('user/notice/{id}', ['uses' => 'MessageUserController@removeSystemMessage'])->where('tid', '[0-9]+');

    //私信操作
    Route::get('user/letters', ['uses' => 'LetterController@index']);
    Route::post('user/letters/messages', ['uses' => 'LetterController@returnLetters']);
    Route::post('user/letters/send', ['uses' => 'LetterController@userSendMessage']);
    Route::post('user/letters/remove', ['uses' => 'LetterController@userDeleteMConversation']);

    //个人收藏夹
    Route::get('user/collection', ['uses' => 'UserController@collectionList']);
    Route::post('collection/change', ['uses' => 'CollectionController@changeCollection']);
    Route::get('user/collection/remove/{tid}&{id}', ['uses' => 'CollectionController@remove'])->where(['tid'=>'[0-9]+','id','[0-9]+']);

    //帖子操作
    Route::post('topic/add', ['uses' => 'TopicController@add']);
    Route::any('topic/update/{tid}', ['uses' => 'TopicController@update'])->where('tid', '[0-9]+');
    Route::get('topic/remove/{tid}', ['uses' => 'TopicController@adminTopicRemove'])->where('tid', '[0-9]+');

    //回帖操作
    Route::any('comment/add', ['uses' => 'CommentController@addReply']);
    Route::get('comment/remove/{id}', ['uses' => 'CommentController@remove'])->where('id', '[0-9]+');   //删除回帖
    Route::post('comment/upvote', ['uses' => 'CommentController@upvote']);  //点赞
});

//后台路由控制
Route::group(['middleware' => 'verifyIsAdmin'], function (){

    //后台首页
    Route::get('admin/index', ['uses' => 'UserController@adminIndex']);

    //系统配置
    Route::any('admin/config', ['uses' => 'ConfigController@index']);

    //后台帖子操作
    Route::get('admin/topic/remove/{tid}', ['uses' => 'TopicController@adminTopicRemove'])->where('tid', '[0-9]+');
    Route::get('admin/topic/examine/{tid}/{operate}', ['uses' => 'TopicController@adminTopicExamine'])->where(['tid' => '[0-9]+', 'operate' => '[a-z]+' ]);     //后台审核,加精,置顶操作
    Route::get('admin/topic', ['uses' => 'TopicController@adminTopicList']);   //后台帖子列表

    //后台分类操作
    Route::get('admin/category', ['uses' => 'CategoryController@index']);
    Route::any('admin/category/add', ['uses' => 'CategoryController@add']);
    Route::any('admin/category/update/{cid}', ['uses' => 'CategoryController@update'])->where('cid', '[0-9]+');
    Route::get('admin/category/remove/{cid}', ['uses' => 'CategoryController@remove'])->where('cid', '[0-9]+');

    //后台系统消息管理
    Route::any('admin/message/add', ['uses' => 'MessageMainController@add']);
    Route::any('admin/message', ['uses' => 'MessageMainController@index']);
    Route::any('admin/message/remove/{id}', ['uses' => 'MessageMainController@adminMessageDelete'])->where('cid', '[0-9]+');

    //后台回帖管理
    Route::get('admin/comments',['uses' => 'CommentController@adminCommentList']);
    Route::get('admin/comments/remove/{id}',['uses' => 'CommentController@remove'])->where('cid', '[0-9]+');
    Route::get('admin/comments/show/{id}',['uses' => 'CommentController@adminShow'])->where('cid', '[0-9]+');

    //后台收藏夹管理
    Route::get('admin/collections',['uses' => 'CollectionController@adminCollectionList']);
    Route::get('admin/collections/remove/{id}', ['uses' => 'CollectionController@removeCollectionData'])->where(['tid'=>'[0-9]+']);

    //后台用户管理
    Route::get('admin/users', ['uses' => 'UserController@adminUserList']);
    Route::any('admin/users/edit/{uid}', ['uses' => 'UserController@editOneUserInfo'])->where(['tid'=>'[0-9]+']);
});