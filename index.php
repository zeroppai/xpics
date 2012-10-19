<?php
include('module/functions.php');
include('module/beluga.php');
include('functions.php');

execute();

function defaultAction(){
	if(isset($_GET['page']) && $_GET['page']>0){
		$page_count = $_GET['page'] * 40; 
	}else{
		$page_count = 0;
	}
	$page_max = ceil((g('SELECT id FROM picture ORDER BY id DESC')+1)/40)-1;
	$items = getAll('SELECT * FROM picture WHERE 1=1 ORDER BY id DESC LIMIT '.$page_count.',40');

	include('inc_index.php');
}

function viewerAction(){
	include('inc_viewer.php');
}

function uploadAction(){
	include('inc_upload.php');
}

function uploadImageAction(){
	put('picture',array(
		'title'=>$_POST['image']['name'],
		'thumbnail_url'=>$_POST['links']['small_square'],
		'image_url'=>$_POST['links']['original'],
		'rate'=>'1'
	));
}

function setupAction(){
	header('Content-type:text');
	echo file_get_contents('setup/mysql.sql');
}