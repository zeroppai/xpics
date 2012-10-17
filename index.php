<?php
include('module/functions.php');
include('module/beluga.php');
include('functions.php');

execute();

function defaultAction(){
	$items = getImageItemsFromBeluga();
	include('inc_index.php');
}

function setupAction(){
	header('Content-type:text');
	echo file_get_contents('setup/mysql.sql');
}