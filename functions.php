<?
function beluga(){
	return new Beluga();
}
function getImageItemsFromBeluga($since_id='0',$max_id='',$count=0){
	$items = array();
	$i = 0;
	foreach (beluga()->home($since_id,$max_id) as $timeline) {
		if(preg_match_all('/(?:^|[\s　]+)((?:https?|ftp):\/\/[^\s　]+)\.(png|jpg|gif)/',$timeline['text'],$matches)){
			foreach ($matches[0] as $val) {
				$item['tl_id'] = $timeline['id'];
				$item['id'] = $i++;
				$item['image_url'] = $val;

				$p_url = pathinfo($val);
				$item['thumbnail_url'] = $p_url['dirname'].'/'.$p_url['filename'].'x100.'.$p_url['extension'];
				$item['title'] = $p_url['filename'].'.'.$p_url['extension'];
				$item['rate'] = 1.0;

				$items[] = $item;
			}
		}
		$max_id = $timeline['id'];
	}
	if($count+$i<50){
		$items = array_merge($items,getImageItemsFromBeluga($since_id,$max_id,$count+$i));
	}
	return $items;
}

/*
   $item
 	$item['id']
 	$item['image_url']
	$item['thumbnail_url']
	$item['title']
	$item['rate']
 */
function dispImageThumbnail($item){
?>
<div class="thumbBlock" id="iamge_<?=$item['id']?>">
	<div class="thumbInside">
		<div class="thumb">
			<a href="<?=$item['image_url']?>" target="_blank"><img src="<?=$item['thumbnail_url']?>" id="pic_<?=$item['id']?>"></a>
		</div>
		<p><a href="<?=$item['image_url']?>" target="_blank"><?=$item['title']?></a></p>

		<p class="metadata">
			<span class="bg">
				<span class="duration">Quality:<?=$item['rate']?></span>
			</span>
		</p>
	</div>
</div>
<?
}