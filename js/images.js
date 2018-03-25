window.onload=function()
{
	photoAdjust();
	
	$(window).resize(function(){
		photoAdjust();	
	});
}


function photoAdjust()
{
    $images = $(".photo-box");
	$num = 4;
	$imagesHeight = [];
	
	for(var i=0;i<$images.length;i++)
	{		
		if(i<$num)
		{
			$images.eq(i).css({"left":i*25+"%","top":"0px"});
			$imagesHeight.push($images.eq(i).height());
		}
		else
		{
			var Hmin=Math.min.apply(null,$imagesHeight);		
			$minIndex = getIndex($imagesHeight,Hmin);
			$imagesHeight[$minIndex] += 20;
			$images.eq(i).css("position","absolute");
			$images.eq(i).css("top",Hmin+20+'px');
			$images.eq(i).css({"left":$minIndex*25+"%"});
			$imagesHeight[$minIndex]+=$images.eq(i).height();
		}
	}
	
	$(".result").height(Math.max.apply(null,$imagesHeight));
	//console.log(Math.max.apply(null,$imagesHeight));
	
}

function getIndex($array,Hmin)
{
	for(var i=0;i<$array.length;i++)
	{
		if($array[i]==Hmin)
		{
			return i;
		}
	}

}