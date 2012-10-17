<?php
include('module/hakodate.php');
include('module/beluga.php');
include('functions.php');

execute();

function defaultAction(){
	$items = getImageItems();
	include('inc_index.php');
}
function sampleAction(){

}