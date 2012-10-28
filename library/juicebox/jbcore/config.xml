<?
include('../../../module/functions.php');
include('../../../module/beluga.php');
include('../../../functions.php');

$params = getURLParams($_SERVER['HTTP_REFERER']);

if(isset($params['archive_id']) && $params['archive_id']>0){
  $items = getAll('SELECT picture.image_url, picture.thumbnail_url, picture.rate FROM archive_pages'
    .' JOIN picture ON picture.id=archive_pages.picture_id'
    .' WHERE archive_pages.archive_id = '.dq($params['archive_id']).' ORDER BY archive_pages.page_id' );
}else{
  $items = getAll('SELECT * FROM picture WHERE id<='.dq($params['id']).' ORDER BY id DESC LIMIT 100');
}

//header
header('Content-Type:application/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>'.chr(10);
?>
<juiceboxgallery 
	galleryTitle=""
	useFlickr="false"
	resizeOnImport="true"
	cropToFit="false"
	galleryWidth="100%"
	showOpenButton="true"
	backgroundColor="rgba(51,51,51,1)"
>
<?foreach($items as $item){?>
  <image imageURL="<?=trim($item['image_url'])?>"
	thumbURL="<?=trim($item['thumbnail_url'])?>"
	linkURL="<?=trim($item['image_url'])?>"
	linkTarget="_blank">
    <title><?=h(trim($item['title']))?></title>
    <caption></caption>
  </image>
<?}?>
</juiceboxgallery>