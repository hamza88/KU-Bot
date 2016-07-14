<?php

$app->get('/', [
    'as' => 'home',
    'uses' => 'HomeController@index'
]);

$app->post('/ask', array(
    'as' => 'master',
    'uses' => 'HomeController@master'
));