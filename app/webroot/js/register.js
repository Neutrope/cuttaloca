$(function() {
	$('.prefecture').change(function() {
		var $next = $(this).next().prop('disabled', true);
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
			},
			error: function() {
			}
		});
	});

	var content = [];
	function apply_content() {
	}
	$('.apply_content').find('input').click(function() {
		var val = $(this).val();
		if ($.inArray(val, content)) {
		}
		$('#apply-price');
	});

	var $hidedSchedule=$(this).find('.hideScedule');
	var $hidedScheduleWeeks=$hidedSchedule.find('.weeks');
	$hidedScheduleWeeks.css({top:'-100px'});
	$hidedSchedule.show(0);
	$hidedScheduleWeeks.animate({
		top: 0
	}, 300, 'easeOutExpo');

		//募集内容 （価格）
	$('.price').focus(function (){
		var i = $(this).index('.price');
		var disabled = $(this).prop('disabled');
		if(disabled){
			$(this).prop('disabled', false);
			if (i == 0) {
				$(this).val(val).prop('disabled', false).prop('readonly', true);
			}
			$(".unit").eq(i).show();
			$(".pricecheck").eq(i).prop('checked', true);
		}
	}).change(function() {
		var text = $(this).val();
		$(this).val(text.replace(/\D/g, ''));
	});

	$(".pricecheck").click(function(){
		var j = $(this).index(".pricecheck");
		var box_chk = $(this).prop('checked');
		if(box_chk){
			var $price = $('.price').eq(j);
			var val = $price.val();
			if (val == '' || val < 0) {
				val = 0;
			}
			$('.price').eq(j).prop('disabled', false).val(val);
			if (j == 0) {
				$('.price').eq(0).prop('readonly', true);
			}
			$('.unit').eq(j).show();
		}else{
			$('.unit').eq(j).hide();
			$('.price').eq(j).prop('disabled', true);
			$('.price').eq(j).val('');
		}
	}).each(function(index) {
		var $price = $('.price').eq(index);
		var val = $price.val();
		if (val != '') {
			$(this).prop('checked', true).trigger('click').prop('checked', true);
		}
	});

	$('.staffSelect').not('.time-end').change(function() {
		var val = parseInt($(this).val());
		if (val == 0) {
			$(this).next().next().html('<option value="0"></option>');
			return;
		}
		var num = 29 - val;
		var $option = $(this).find('option');

		if (num > 6) num = 6;
		var html = '';
		for (var i = val+1; i < val + num; i++) {
			html += '<option value="' + i + '">' + $option.eq(i).html() + '</option>';
		}
		$(this).next().next().html(html);
	});

	var style_selector = {'1':'.select1', '2':'.select2', '3':'.select3', '4':'.select1,.select2', '5':'.select1,.select3'};
	
	function load_cutmodelstyle() {
		var element = document.getElementById("CutModelStyle");
		if (element) {
			var val = element.selectedIndex;
			var selector = style_selector[val];
			$('.select').not(selector).hide('fast');
			$(selector).show('fast');
		}
	}
	load_cutmodelstyle();
	
	$('#CutModelStyle').change(function() {
		var val = $(this).val();
		var selector = style_selector[val];
		$('.select').not(selector).hide('fast');
		$(selector).show('fast');
	});
	
	function error_message($obj) {
		$obj.closest('tr').addClass('error');
	}

	$('.mailForm').submit(function() {
		$('.error').removeClass('error');
		$('.require').each(function() {
			$this = $(this);
			if ($this.attr('type') == 'checkbox') {
				if (!$this.prop('checked')) {
					$this.addClass('error');
					alert('利用規約を読み、チェックしてください。');
				}
			} else {
				var val = $(this).val();
				if ($this.closest('div').css('display') != 'none' && (val == '' || val == 0)) {
					error_message($(this));
				}
			}
		});

		if ($('.pricecheck:checked').size() == 0) {
			error_message($('.pricecheck').eq(0));
		}

		// offer（掲載登録）の場合はメールアドレスのチェックはなし
		var resArray = document.URL.split("/");
		if (resArray[4] != 'offer') {
			var email = $('.email').val();
			if (email.indexOf('..') != -1 || email.indexOf('.@') != -1) {
				window.alert('メールアドレスに不正な形式が含まれています\n例）ダブルドット(..)、ドットアット(.@)\nお手数ですが、他のメールアドレスでご登録をお願い致します。');
				error_message($('.email').eq(0));
			}
		}

		if ($('input[name="data[Stylist][apply_gender]"]:checked').size() == 0) {
			error_message($('input[name="data[Stylist][apply_gender]"]').eq(0));
		}

		var size = $('#StylistApplyStyleAll:checked').size() + $('input[name="data[Stylist][apply_style][]"]:checked').size();
		if (size == 0) {
			error_message($('#StylistApplyStyleAll'));
		}

		
		$.close = {
			'StylistOrdinaryStart': $('.week-of-days').not('.sun, .sat').find('li').not('.holiday'),
			'StylistSaturdayStart': $('.sat').find('li').not('holiday'),
			'StylistHolidayStart': $('li.sun, li.holiday')
		};

		var staff_error = true;
		var clearlist = [];
		$('.staffSelect').not('.time-end').each(function() {
			var val = $(this).val();
			var next = $(this).next().next().val();
			if (staff_error && val > 0 && next > 0) {
				staff_error = false;
			}
			if (val == 0) {
				clearlist.push($.close[$(this).attr('id')]);
			}
		});

		if (staff_error) {
			error_message($('#StylistOrdinaryStart'));
		}

		if ($('.error').size() == 0) {
			for (var key in clearlist) {
				clearlist[key].find('input[type="checkbox"]').prop('checked', false);
			}

			return true;
		}

		$('html, body').animate({scrollTop: $('.error').eq(0).offset().top - 120});
		return false;
	});
});