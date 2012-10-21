/*
 * upload functions
 */
var dev_key = '01a582f5d7518e3ef620061ecb8023ac';
var archive_id = 0;
var request_count = 0;

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
			if(--request_count<=0)$.unblockUI();
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
			addToArchive(archive_id,msg);
		},
		error:function(msg){
			$('#uploadMessages').html('<strong>registerに失敗しました。</strong>');
			console.log(msg);
			if(--request_count<=0)$.unblockUI();
		}
	});
}

function addToArchive(archive_id,picture_id){
	var data = {
		archive_id:archive_id,
		picture_id:picture_id
	};
	$.ajax({
		type:'POST',
		url:'./index.php?action=addToArchive',
		data:data,
		success:function(msg){
			console.log(msg);
			if(--request_count<=0)$.unblockUI();
		},
		error:function(msg){
			$('#uploadMessages').html('<strong>registerに失敗しました。</strong>');
			console.log(msg);
			if(--request_count<=0)$.unblockUI();
		}
	});
}

$('#uploadButton').click(function(){
	//upload archive
	if($('#make_archive').is(':checked')){
		var data = {
			name:$('#archive_name').attr('value'),
			tags:$('#archive_tags').attr('value')
		};
		$.post(
			'./index.php?action=makeArchive',
			data,
			function(msg){
				console.log(msg);
				archive_id = msg;
				uploadImage();
			},
			'JSON'
		);
	}else{
		uploadImage();
	}
	$.blockUI();

	function uploadImage(){
		//upload picture
		$('#uploadMessages').children('img').each(function(){
			var data = {
				name:$(this).attr('name'),
				key:dev_key,
				type:'base64',
				image:null
			};
			var src = $(this).attr('src').split(',');
			data.image = src[1];

			//console.log(data);
			request_count++;
			uplaodToImgurl(data);
		});
	}
});