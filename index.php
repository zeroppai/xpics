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
	$archives = getAll('SELECT * FROM archive WHERE 1=1 ORDER BY date DESC LIMIT 8');

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
	$items = getAll('SELECT * FROM archive WHERE 1=1 ORDER BY date DESC LIMIT '.$page_count.',40');

	include('inc_archive.php');
}

function newArchiveAction(){
	include('inc_form_new_archive.php');
}

function saveNewArchiveAction(){
	$archive_id = put('archive',array(
		'title'=>$_POST['archive_title'],
		'tags'=>$_POST['archive_tags'],
		'thumbnail_url'=>$_POST['archive_thumbnail'],
		'rate'=>'1'
	));

	if($archive_id>0){
		location('./index.php?action=editArchive&archive_id='.$archive_id);
	}else{
		location('./index.php');
	}
}

function editArchiveAction(){
	if(!isset($_SESSION['user'])) location('index.php');

	if(isset($_GET['page']) && $_GET['page']>0){
		$page_count = $_GET['page'] * 40; 
	}else{
		$page_count = 0;
	}

	$archive_params = 'archive_id='.h($_GET['archive_id']).'&page='.h($_GET['page']);

	if(isset($_GET['archive_id']) && is_numeric($_GET['archive_id'])){
		$archive = get('SELECT * FROM archive WHERE archive_id='.dq($_GET['archive_id']));
		$item_list = getAll('SELECT archive_pages.page_id, picture.id, picture.image_url, picture.thumbnail_url, picture.rate FROM archive_pages'
		    .' JOIN picture ON picture.id=archive_pages.picture_id'
		    .' WHERE archive_pages.archive_id = '.dq($_GET['archive_id']).' ORDER BY archive_pages.page_id');

		$page_max = ceil((g('SELECT id FROM picture ORDER BY id DESC')+1)/40)-1;
		$items = getAll('SELECT * FROM picture WHERE 1=1 ORDER BY id DESC LIMIT '.$page_count.',40');

		include('inc_edit_archive.php');
	}else{

		$page_max = ceil((g('SELECT archive_id FROM archive ORDER BY archive_id DESC')+1)/40)-1;
		$items = getAll('SELECT * FROM archive WHERE 1=1 ORDER BY date DESC LIMIT '.$page_count.',40');

		include('inc_edit_archive_list.php');
	}
}

function saveArchiveAction(){
	if(!isset($_SESSION['user'])) location('index.php');

	put('archive',array(
		'archive_id'=>$_POST['archive_id'],
		'title'=>$_POST['archive_title'],
		'tags'=>$_POST['archive_tags'],
		'thumbnail_url'=>$_POST['archive_thumbnail'],
		'rate'=>$_POST['rate'],
		'date'=>date('Y-m-d H:i:s')
	),array('archive_id'));

	$_SESSION['notice'] = '設定を保存しました'; 
	location('index.php?action=editArchive&'.gu('archive_id,page'));
}

function addPictureAction(){
	if(!isset($_SESSION['user'])) location('index.php');

	foreach ($_POST as $key => $value) {
		if($value==='on'){
			$id = explode('_', $key);
			put('archive_pages',array(
				'archive_id'=>$_GET['archive_id'],
				'picture_id'=>$id[1]
			));
		}
	}

	location('index.php?action=editArchive&'.gu('archive_id,page'));
}

function removePictureAction(){
	if(!isset($_SESSION['user'])) location('index.php');

	query('DELETE FROM archive_pages WHERE page_id='.dq($_GET['page_id']));

	location('index.php?action=editArchive&'.gu('archive_id,page'));
}

function uploadAction(){
	include('inc_upload.php');
}

function loginAction(){
	if(isset($_GET['user_token']) && isset($_GET['user_id'])){
		$_SESSION['user']['user_id'] = $_GET['user_id'];
		$_SESSION['user']['user_token'] = $_GET['user_token'];
		location('./index.php');
	}else{
		location('http://beluga.fm/authorize?app_id=53');
	}
}

function logoutAction(){
	unset($_SESSION['user']);
	location('./index.php');	
}

/* for ajax */

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