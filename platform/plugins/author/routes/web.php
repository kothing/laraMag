<?php

use Botble\Base\Facades\AdminHelper;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\Author\Http\Controllers'], function () {
    AdminHelper::registerRoutes(function () {
        Route::group(['prefix' => 'authors', 'as' => 'author.'], function () {
            Route::resource('', 'AuthorController')->parameters(['' => 'author']);
        });
    });
});
