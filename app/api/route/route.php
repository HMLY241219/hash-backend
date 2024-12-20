<?php

use think\facade\Route;

//Pg投付
Route::rule('/Cash/TransferInOut','api/slots.Pgslots/TransferInOut');

//获取用户钱包（转入）
Route::rule('/Cash/Get','api/slots.Pgslots/Get');

//td
Route::rule('/auth','api/slots.Tdslots/userAuth');
Route::rule('/bet','api/slots.Tdslots/userBet');
Route::rule('/cancelBet','api/slots.Tdslots/cancelBet');