<?
function beluga(){
	return new Beluga();
}
function getImageItems(){
	$items = array();
	$i = 0;
	foreach (beluga()->home() as $timeline) {
		if(preg_match_all('/(?:^|[\s　]+)((?:https?|ftp):\/\/[^\s　]+)\.(png|jpg|gif)/',$timeline['text'],$matches)){
			foreach ($matches[0] as $val) {
				$item['id'] = $i++;
				$item['image_url'] = $val;

				$p_url = pathinfo($val);
				$item['thumbnail_url'] = $p_url['dirname'].'/'.$p_url['filename'].'x100.'.$p_url['extension'];
				$item['title'] = $p_url['filename'];
				$item['rate'] = 1.0;

				$items[] = $item;
			}
		}
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