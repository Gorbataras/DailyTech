<?php


// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require autoload file
require("vendor/autoload.php");
session_start();
// Instantiate F3
$f3 = Base::instance();

//Debugger
$f3->set('DEBUG', 3);

//Instantiate database
$db = new Database();
$controller = new Controller($f3);

// Defining a default route
$f3->route('GET /', function ()
{
    $GLOBALS['controller']->home();
});

// Define login route
$f3->route('GET|POST /login', function ()
{
    $GLOBALS['controller']->login();
});

//Define sign-up route
$f3->route('GET|POST /signup', function ()
{
    $GLOBALS['controller']->signup();
});

//Define logout route
$f3->route('GET /logout', function ()
{
    $GLOBALS['controller']->logout();
});

//Define viewing a post route
$f3->route('GET /view/@header', function ()
{
    $GLOBALS['controller']->viewPost($GLOBALS['f3']->get('PARAMS.header'));
});

//Define viewing posts based on category route
$f3->route('GET /category/@category', function ()
{
    $GLOBALS['controller']->category($GLOBALS['f3']->get('PARAMS.category'));
});

//Define settings route
$f3->route('GET /settings', function ()
{
    $GLOBALS['controller']->settings();
});

//Define adminPage route
$f3->route('GET /adminPage', function ()
{
    $GLOBALS['controller']->admin();
});

//Define update account route
$f3->route('GET|POST /updateaccount', function ()
{
    $GLOBALS['controller']->updateaccount();
});

//Define update password route
$f3->route('GET|POST /updatepassword', function ()
{
    $GLOBALS['controller']->updatepassword();
});

//Define delete account route
$f3->route('GET|POST /deleteaccount', function ()
{
    $GLOBALS['controller']->deleteaccount();
});

//Define create an article route
$f3->route('GET|POST /createArticle', function()
{
	$GLOBALS['controller']->createarticle();
});

// Run F3
$f3->run();

