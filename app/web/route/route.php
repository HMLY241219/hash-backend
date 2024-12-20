<?php

use think\facade\Route;

Route::group(function () {
    /* 路由 在此处 添加或修改 */
    //Route::get('/', 'teen_patti_hub');
    Route::get('/', 'teen_patti_hub')->domain('teenpattihub.online');
    Route::get('/', 'teen_patti_hub_agenta')->domain('agenta.teenpattihub.online');
    Route::get('/', 'teen_patti_hub_agentb')->domain('agentb.teenpattihub.online');
    Route::get('/', 'teen_patti_hub_sms')->domain('sms.teenpattihub.online');
    Route::get('/', 'teen_patti_hub_kol')->domain('kol.teenpattihub.online');
    Route::get('/', 'uno_big_flip_share')->domain('uno.teenpattihub.online');
    Route::get('/', 'teen_patti_hub_googleplay')->domain('googleplay.teenpattihub.online');
})->prefix('landing/');

Route::miss(function () {
    if (app('request')->isOptions()) {
        return \think\Response::create('ok')->code(200)->header([
            'Access-Control-Allow-Origin'  => '*',
            'Access-Control-Allow-Headers' => 'Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With',
            'Access-Control-Allow-Methods' => 'GET,POST,PUT,DELETE,OPTIONS',
        ]);
    }

    return \think\Response::create()->code(404);
});