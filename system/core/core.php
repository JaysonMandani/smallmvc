<?php
/*
* Core file for the MVC framework
*
*/
if(!defined('APPS')) exit ('No direct access allowed');

//require the core files of the system
require_once APPS.'config/database'.EXT;
require_once APPS.'config/autoload'.EXT;
require_once APPS.'config/config'.EXT;
require_once CORE.'loader'.EXT;
require_once CORE.'mvc_controller'.EXT;
require_once CORE.'route'.EXT;
require_once CORE.'mvc_model'.EXT;
require_once CORE.'session'.EXT;
//return the mvc global object
function getInstance(){
	return MVC_controller::getInstance();
}

//create routing object
$route = new route();

//get the controller
$controller = $route->getController();

//get the method
$method = $route->getMethod();

//get the parameters
$params = $route->getArgs();

$file = ROOT.APPS.'controllers'.DS.$controller.EXT;
if(file_exists($file)){
	require_once $file;
	$run = new $controller();
	if(isset($params)){
		if(method_exists($run,$method)){
			$run->{$method}($params);
			}else{
			require_once('error/error_.php');
		}
	}else{
		//if not run method
		if(method_exists($run,$method)){
			$run->{$method}();
		}else{
			require_once('error/error_.php');
		}
	}
}else{
	require_once('error/error_.php');
}

