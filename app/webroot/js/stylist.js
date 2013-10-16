/* for style page
 * list.html, stylist.html
*/
$(function(){
	// only stylist List page
	if($('#contentsIn').hasClass('stylistList')){

		var $leftMenu = $('#leftMenu');
		// left menu
		var $placeDiv = $leftMenu.find('.place');
		var $placeH1 = $placeDiv.find('h1');
		var $placeHideDiv = $placeDiv.find('div.hideDiv');
		var $placeHideUl = $placeDiv.find('ul.hideUl');

		var $sexDiv = $leftMenu.find('.sex');
		var $sexH1 = $sexDiv.find('h1');
		var $sexHideDiv = $sexDiv.find('div.hideDiv');
		var $sexHideUl = $sexDiv.find('ul.hideUl');

		var $termsDiv = $leftMenu.find('.terms');
		var $termsH1 = $termsDiv.find('h1');
		var $termsHideDiv = $termsDiv.find('div.hideDiv');
		var $termsHideUl = $termsDiv.find('ul.hideUl');

		$placeHideDiv.hide(0);
		$sexHideDiv.hide(0);
		$termsHideDiv.hide(0);

		// click a
		var leftMenuClicked=function(target){

			var showedDiv, showedUl, parentDiv;
			if(target.parent().hasClass('place')){
				showedUl=$placeHideUl;
				showedDiv=$placeHideDiv;
				parentDiv=$placeDiv;
			}else if(target.parent().hasClass('sex')){
				showedUl=$sexHideUl;
				showedDiv=$sexHideDiv;
				parentDiv=$sexDiv;
			}else{
				showedUl=$termsHideUl;
				showedDiv=$termsHideDiv;
				parentDiv=$termsDiv;
			}

			showedUl.css({marginTop:'-30px'}).animate({marginTop: 0}, 200, 'easeOutExpo');
			parentDiv.toggleClass('showed');
			showedDiv.toggle(0);

		};

		// click h1 a
		$placeH1.find('a').click(function(){
			var $thisParent=$(this).parent();
			leftMenuClicked($thisParent);
			return false;
		});
		$sexH1.find('a').click(function(){
			var $thisParent=$(this).parent();
			leftMenuClicked($thisParent);
			return false;
		});
		$termsH1.find('a').click(function(){
			var $thisParent=$(this).parent();
			leftMenuClicked($thisParent);
			return false;
		});

		// place selected
		$leftMenu.find('.place ul.hideUl li select').change(function(){
			 $(this).find('option.hit').removeClass('hit');
			 $(this).find('option:selected').addClass('hit');
			 
			 $(this).blur();
			 
		});

		// click place Li
		$leftMenu.find('.place ul.hideUl li').click(function(){
			var thisSelect = $(this).children();

			return false;
		});
		
			
		
		// terms selected
		$termsHideUl.find('input').click(function(){
			
			var $thisLi=$(this).parent();
			var thisInput=$(this).get(0);
			if(thisInput.checked){
				$thisLi.addClass('checked');
			}else{
				$thisLi.removeClass('checked');
			}
			
		});

		// click show schedule
		$('.stylistData').each(function(){
			
			var $hidedSchedule=$(this).find('.hideScedule');
			var $hidedScheduleWeeks=$hidedSchedule.find('.weeks');
			var showedFlg=false;

			$(this).find('.link .m2 a').click(function(){
				if(!showedFlg){
					$(this).parent().addClass('m2Hit');
					
					$hidedScheduleWeeks.css({top:'-100px'});
					$hidedSchedule.show(0);
					$hidedScheduleWeeks.animate({
						top: 0
					}, 300, 'easeOutExpo');
					
					showedFlg=true;
				}
				return false;
			});
			
		});

		$('#CutModelPrefecture, #StylistPrefecture').change(function() {
			var $next = null;
			if ($(this).attr('id') == 'CutModelPrefecture') {
				$next = $('#CutModelArea').prop('disabled', true);
			} else {
				$next = $('#StylistArea').prop('disabled', true);
			}
			$.ajax({
				url: '/json/city/get_list',
				type: 'post',
				data: {prefecture_id: $(this).val()},
				dataType: 'json',
				success: function(json) {
					$next.children().not(':first').remove().end();
					var html = '';
					for (key in json) {
						var city = json[key].City;
						html += '<option value="' + city.name + '">' + city.name + '</option>';
					}
					$next.append(html);
					if (html != '') {
						$next.prop('disabled', false);
					}
				}
			});
		});
	}

	// COMMON - Schedule Slide
	$('.hideScedule').each(function(){

		var $thisScedule = $(this);
		var $thisSceduleWeeksWrapper = $thisScedule.find('.weeksWrapper');
		var $thisSceduleWeeks = $thisScedule.find('.weeks');
		var thisSceduleHeight = 0;

		$thisScedule.find('.week').each(function(i){
			var $thisWeek = $(this);
			var wx = 696*i;
			$thisWeek.css({left:wx});

			// week height
			if($thisWeek.height() > thisSceduleHeight){
				thisSceduleHeight = $thisWeek.height();
			}
			
		});

		// set
		var ni=0;
		var ti = $thisScedule.find('.week').length;
		$thisSceduleWeeks.css({height:thisSceduleHeight, width:696*ti});
		$thisSceduleWeeksWrapper.css({height:thisSceduleHeight});
		$thisScedule.css({height:thisSceduleHeight});

		// add event - navi
		var $prev = $thisScedule.find('.navi .prev');
		var $next = $thisScedule.find('.navi .next');
		$prev.hide(0);

		// slide function
		var changeThisSchedule = function(val){
			if(val <= 0){
				$prev.hide(0);
				$next.show(0);
			}else if(val == ti-1){
				$prev.show(0);
				$next.hide(0);
			}else{
				$prev.show(0);
				$next.show(0);
			}

			var lx=-696*val;
			$thisSceduleWeeks.stop(true, true).animate({
				left: lx+'px'
			}, 500, 'easeOutExpo');

			ni=val;
		};

		$prev.click(function(){
			var nxi = ni-1;
			if(nxi<0)nxi = ti;
			changeThisSchedule(nxi);
			return false;
		});
		$next.click(function(){
			var nxi = ni+1;
			if(nxi >= ti) nxi = 0;
			changeThisSchedule(nxi);
			return false;
		});

		// if List Page hide Schedule
		if ($('#contentsIn').hasClass('stylistList')){
			$thisScedule.hide(0);
		}

		$('.dateList').hide(0);
	});
});