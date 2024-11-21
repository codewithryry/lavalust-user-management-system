<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------
| Here is where you can register web routes for your application.
|
*/

$router->get('/', 'User::login'); // Set User::read as the default route
$router->get('/about-us', 'Welcome::about_us');
$router->get('/contact-us', function() use ($router){
    echo 'OKAY LANG AKO';
});

$router->get('/users/display', 'User::read');
$router->match('/users/create', 'User::create', array('GET', 'POST'));
$router->match('/users/update/{id}', 'User::update', array('GET', 'POST'));
$router->get('/users/delete/{id}', 'User::delete');

$router->match('/users/register', 'User::register', array('GET', 'POST')); // Registration route
$router->match('/users/login', 'User::login', array('GET', 'POST')); // Login route
$router->post('/users/login', 'User::login');

$router->match('/users/send_email', 'User::send_email', array('GET', 'POST')); // Route to display the send email form and handle submission
$router->post('/users/send_email_action', 'User::send_email_action'); // Route to process the send email action
