// JavaScript Document
$(document).ready(function() {
	$("#btn_add_photo").click(function(){
		openPickShow();
	});
	
	$("#btn_show_photo").click(function(){
		openImageShow();
	});	

	$("#btn_upload_photo").click(function(){
		openLoadPhoto();
	});

	$("#btn_build_album").click(function(){
		openNewAlbum();
	});

	$("#btn_delete_photo").click(function(){
		openDeleteShow();
	});

	$("#btn_update_photo").click(function(){
		openUpdateShow();
	});

	$("#btn_update_album").click(function(){
		openUpdateAlbum();
	});

	$("#btn_delete_album").click(function(){
		openDeleteAlbum();
	});

});

function closeImageShow()
{
	$("body").eq(0).css({"overflow":"scroll","height":"auto"});	
	$("#show-image").remove();
}

function closePickShow()
{
	$("#show-pick").fadeOut("fast");
}

function closeDeleteShow()
{
	$("#delete-photo").fadeOut("fast");
}

function openDeleteShow()
{
	$("#delete-photo").fadeIn("fast");
}

function closeUpdateShow()
{
	$("#update-photo").fadeOut("fast");
}

function openUpdateShow()
{
	$("#update-photo").fadeIn("fast");
}

function openImageShow()
{
	$url = $(".photo-box").eq(0).find("img").eq(0).attr("src");
	$div = $("<div></div>");
	$div.addClass("show-image");
	$div.attr("id","show-image");
	$div.html("<a class='close-btn' onclick='closeImageShow()'></a><img src='"+$url+"'/>");
	$("body").eq(0).append($div);
	$("body").eq(0).css({"overflow":"hidden","height":"100%"});	
}

function openPickShow()
{
	$("#show-pick").fadeIn("fast");
}

function openLoadPhoto()
{
	$("#upload-image").fadeIn("fast");
}

function closeLoadPhoto()
{
	$("#upload-image").fadeOut("fast");
}

function openNewAlbum()
{
	$("#build-album").fadeIn("fast");
}

function closeNewAlbum()
{
	$("#build-album").fadeOut("fast");
}

function photoPreview(file)
{
   var prevDiv = document.getElementById('file-btn');

   if (!/.(gif|jpg|jpeg|png|GIF|JPG|png|BMP|bmp)$/.test(file.value))
   {
   		return false;
   }

   if (file.files && file.files[0]) {
      var reader = new FileReader();
      reader.onload = function(evt) {
        prevDiv.style = "background-image:url(" + evt.target.result + ")"; 
      }
      reader.readAsDataURL(file.files[0]);
    } else {
        prevDiv.style = "background-image:url(" + file.value + ")"; 
    }	
}

function openUpdateAlbum()
{
	$("#update-album").fadeIn("fast");
}

function closeUpdateAlbum()
{
	$("#update-album").fadeOut("fast");	
}

function openDeleteAlbum()
{
	$("#delete-album").fadeIn("fast");
}

function closeDeleteAlbum()
{
	$("#delete-album").fadeOut("fast");	
}