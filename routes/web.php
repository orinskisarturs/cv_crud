<?php
$router->get('cv/index', 'CvController@index');
$router->post('cv/store', 'CvController@store');
$router->get('cv/show/{id}', 'CvController@show');
$router->patch('cv/update/{id}', 'CvController@update');
$router->get('cv/destroy/{id}', 'CvController@destroy');

$router->get('job_type/index', 'JobTypeController@index');
$router->get('education_progress/index', 'EducationProgressController@index');
$router->get('accomplishment_type/index', 'AccomplishmentTypeController@index');
$router->get('country/index', 'CountryController@index');
