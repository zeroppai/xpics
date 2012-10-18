/*
 * upload functions
 */
var dev_key = '01a582f5d7518e3ef620061ecb8023ac';

function uplaodToImgurl(data){
	$.ajax({
		type:'POST',
		url:'http://api.imgur.com/2/upload.json',
		data:data,
		success:function(msg){
			$('#uploadMessages').html('<strong>アップロードに成功しました。</strong>');
			registImage(msg);
		},
		error:function(msg){
			$('#uploadMessages').html('<strong>アップロードに失敗しました。</strong>');
			console.log(msg);
		}
	 });
}

function registImage(data){
	$.ajax({
		type:'POST',
		url:'./index.php?action=uploadImage',
		data:data.upload,
		success:function(msg){
			console.log(msg);
		},
		error:function(msg){
			$('#uploadMessages').html('<strong>registerに失敗しました。</strong>');
			console.log(msg);
		}
	});
}

$('#uploadButton').click(function(){
	$('#uploadMessages').children('img').each(function(){
		var data = {
			name:$(this).attr('name'),
			key:dev_key,
			type:'base64',
			image:null
		};
		var src = $(this).attr('src').split(',');
		data.image = src[1];

		console.log(data);
		uplaodToImgurl(data);
	});
});