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
	if(isset($_GET['archive_id'])){
		$item = get('SELECT * FROM archive WHERE archive_id='.dq($_GET['archive_id']));
	}else{
		$item = get('SELECT * FROM picture WHERE id='.dq($_GET['id']));
	}
	include('inc_viewer.php');
}

function archiveAction(){
	if(isset($_GET['page']) && $_GET['page']>0){
		$page_count = $_GET['page'] * 40; 
	}else{
		$page_count = 0;
	}
	$page_max = ceil((g('SELECT archive_id FROM archive ORDER BY archive_id DESC')+1)/40)-1;
	$items = getAll('SELECT * FROM archive WHERE 1=1 ORDER BY archive_id DESC LIMIT '.$page_count.',40');
	include('inc_archive.php');
}

function uploadAction(){
	include('inc_upload.php');
}

function makeArchiveAction(){
	echo put('archive',array(
		'title'=>$_POST['name'],
		'tags'=>$_POST['tags'],
		'thumbnail_url'=>'./img/none.jpeg',
		'rate'=>'1'
	));
}

function addToArchiveAction(){	
	echo put('archive_pages',array(
		'archive_id'=>$_POST['archive_id'],
		'picture_id'=>$_POST['picture_id']
	));
}

function uploadImageAction(){
	echo put('picture',array(
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