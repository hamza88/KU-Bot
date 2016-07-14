<?php

$app->get('/', [
    'as' => 'home',
    'uses' => 'HomeController@index'
]);

$app->post('/master', array(
    'as' => 'master',
    'uses' => 'HomeController@master'
));