$(function(){
	
	// is PC
	var agent = navigator.userAgent;
	var smartphoneFlg=(agent.search(/iPhone/) != -1 || agent.search(/iPad/) != -1 || agent.search(/iPod/) != -1 || agent.search(/Android/) != -1);	
	
	// Loading show
	var lh=$(window).height()-12;
	var lw=$(window).width()-12;
	$('.loading').width(lw).height(lh).css({width:lw, height:lh}).delay(200).fadeIn(300);
	
	
	var initFunc = function(options) {
		var plugin = this;
		var winHeight, winWidth, docHeight, docWidth, photoHeight, photoBoxHeight;
		
		var mainPhotoWidth=1024, mainPhotoHeight=475;
		
		var $prevBtn=$('.photoControler .prev');
		var $nextBtn=$('.photoControler .next');
		var $photoNum=$('.photoControler .photoNum');
		var photoNumLiArray=[];
		
		
		plugin.docHeight=$(document).height();
		plugin.docWidth=$(document).width();
		plugin.winHeight=$(window).height()-12;
		plugin.winWidth=$(window).width()-12;
		plugin.photoHeight=plugin.winHeight-95-34-60;
		plugin.photoBoxHeight=plugin.winHeight-95-60;
		
		
		//
		
		
		// resize event
		plugin.windowResized = function() {			
				
			plugin.docHeight=$(document).height();
			plugin.docWidth=$(document).width();
			plugin.winHeight=$(window).height()-12;
			plugin.winWidth=$(window).width()-12;
			plugin.photoHeight=plugin.winHeight-95-34-60;
			plugin.photoBoxHeight=plugin.winHeight-95-60;
			
			
			$('.loading').width(plugin.winWidth).height(plugin.winHeight).css({width:plugin.winWidth, height:plugin.winHeight});
			
			// fit window size
			$('#indexPhoto .photoWrapper ul li img').each(function(){
				
				var pWidth, pHeight, pPer, pLeft, pTop;
				var imgNode=$(this).get(0);
				//var sizeObj=getNaturalSize(imgNode);	// sizeObj.width, sizeObj.height
				pPer=mainPhotoWidth/mainPhotoHeight;//sizeObj.width/sizeObj.height;
				
				// 幅合わせ
				if(plugin.winWidth/plugin.photoHeight > pPer){
					
					pWidth=plugin.winWidth;
					pHeight=Math.ceil(plugin.winWidth/pPer);
					pLeft=0;
					pTop=Math.ceil( (plugin.photoHeight-pHeight)*0.5 );
					
				// 高さ合わせ	
				}else{
					pHeight=plugin.photoHeight;
					pWidth=plugin.photoHeight*pPer;
					pLeft=Math.ceil( (plugin.winWidth-pWidth)*0.5 );
					pTop=0;
				}
				
				
				$(this).css({
					marginLeft:pLeft+'px',
					marginTop:pTop+'px',
					width:pWidth+'px',
					height:pHeight+'px'
				});
				
				
				$(this).parent().css({
					width:plugin.winWidth+'px',
					height:plugin.photoHeight+'px'
				})
				
			});
			
			
			// photobox height
			plugin.photoBoxHeight=plugin.winHeight-95-60;
			$('#indexPhoto').css({height:plugin.photoBoxHeight+'px'});
			
			
			// navi position
			var pnTop=Math.ceil( plugin.photoHeight*0.5 )-31;
			$prevBtn.css({top:pnTop+'px'});
			$nextBtn.css({top:pnTop+'px'});
			var pnh=plugin.photoHeight+11;
			$photoNum.css('top',pnh+'px');
			
		};
		
		
		
		// Timer Func
		var nowIndex=0, autoFlg=true, timerID, total;
		
		plugin.total=$('.photoWrapper ul li').children().length;
		
		plugin.timerFunc=function(e){
			var nextIndex=nowIndex+1;
			if(nextIndex>=plugin.total){
				nextIndex=0;
			}
			plugin.photoChangeFunc(nextIndex);
		}
		
		//change Func
		plugin.photoChangeFunc=function(val){
			
			var $nowPhoto=$('.photoWrapper ul li img:eq('+nowIndex+')');
			var $nextPhoto=$('.photoWrapper ul li img:eq('+val+')');
			
			$nowPhoto.stop(true, true).fadeOut(700, function() {
                $(this).removeClass('current');
            });
			$nextPhoto.stop(true, true).fadeIn(700, function() {
                $(this).addClass('current');

                // Android対策
                var h = $('.photoWrapper img.current').height();
                $('.photoWrapper ul.sp').height(h);
            });
			
			$photoNum.children('li:eq('+nowIndex+')').removeClass('hit');
			$photoNum.children('li:eq('+val+')').addClass('hit');
			
			nowIndex=val;
			
		};
		
		// click prev next
		$prevBtn.click(function(){
		
			if(autoFlg){
				autoFlg=false;
				clearInterval(plugin.timerID);
			}
			
			var nextIndex=nowIndex-1;
			if(nextIndex<0){
				nextIndex=plugin.total-1;
			}
			plugin.photoChangeFunc(nextIndex);
			return false;
		});
		
		$nextBtn.click(function(){
		
			if(autoFlg){
				autoFlg=false;
				clearInterval(plugin.timerID);
			}
		
			var nextIndex=nowIndex+1;
			if(nextIndex>=plugin.total){
				nextIndex=0;
			}
			plugin.photoChangeFunc(nextIndex);
			return false;
		});
		
		
		
		
		
		// set ol li
		for(var i=1; i<plugin.total+1; i++){
			var $li=$('<li>'+i+'</li>');
			$photoNum.append($li);
		}
		$photoNum.children('li:eq(0)').addClass('hit');
		
		
		// set size
		plugin.windowResized();
		
		// show
		$('.photoWrapper ul li img:eq(0)').addClass('current').show(0);
		$('.loading').delay(500).fadeOut(300);


		// timer start
		plugin.timerID = setInterval(plugin.timerFunc, 3000);
		
		
		// add event
		$(window).resize(plugin.windowResized);
		
		
		
		/* SHOW HIDE CONTENTS */
		var nowShowContents;
		plugin.nowShowContents=-1;
		plugin.showContents=function(){
			
			$('#hideContents .hide').css('visibility','visible');
			if(smartphoneFlg){
				$('html').css({height:'auto', overflow:'scroll'});
				$('body').css({height:'auto', overflow:'scroll'});
			}else{
				$('body').css({overflow:'scroll'});
			}
			jQuery('html,body').animate({
				scrollTop: plugin.photoBoxHeight
			}, 500, 'easeOutExpo');
			
			$('#showMenu ul li').addClass('hit');
			
		};
		
		/* change contents */
		plugin.changeContents=function(val){
			
			// if hide contents
			if(plugin.nowShowContents<0){
				
				plugin.showContents();
				
			}else{
				
				jQuery('html,body').animate({
					scrollTop: plugin.photoBoxHeight
				}, 500, 'easeOutExpo');
				
			}
			
			
			if(val==1){
				$('#indexContents1').show(0);
				$('#indexContents2').hide(0);
			}else{
				$('#indexContents1').hide(0);
				$('#indexContents2').show(0);
			}
			
			
			$('#showMenu ul li h1 a').removeClass('current').addClass('hidden');
			$('#showMenu ul li:eq('+(val-1)+') h1 a').removeClass('hidden').addClass('current');
			
			plugin.nowShowContents=val;
			
		};
		
		
		//add event
		$('#showMenu ul li a').click(function(){
			
			var cf=$(this).parent().parent().hasClass('c1')?1:2;
			if(cf!=plugin.nowShowContents){
				plugin.changeContents(cf);
			}
			return false;
		});
		
		
		// if not pc
		if(smartphoneFlg){
//			$('html').css({height:plugin.winHeight, overflow:'hidden'});
//			$('body').css({height:plugin.winHeight, overflow:'hidden'});
		}
		
		
	}
	
	
	
	// onload - メイン画像読み込み完了後に
	jQuery.event.add(window, "load", initFunc);
	
	jQuery('html,body').animate({scrollTop: 0});
	
	// hide scroll
	$('body').css({overflow:'hidden'});
	
	$('.loading').width($(window).width()-12).height($(window).height()-12);
	
});