$(function(){
	$.ajaxSetup({
		'type' : 'post',
		'dataType' : 'json'
	});

	var agent = navigator.userAgent;
	var spFlg = (agent.search(/iPhone/) != -1 || agent.search(/iPad/) != -1 || agent.search(/iPod/) != -1 || agent.search(/Android/) != -1);
	
	
	// PAGE TOP
	$('#footer .pagetop a').bind({
		'mouseover':function(e){
			$(this).stop(true, true).animate({
				backgroundPositionY: '-50px'
			}, 400, 'easeOutExpo' )
		},
		'mouseout':function(e){
			$(this).stop(true, true).animate({ 
				backgroundPositionY: '0'
			}, 200, 'easeOutCubic' )
		},
		'click':function(e){
			jQuery('html,body').animate({scrollTop: 0}, 500, 'easeOutExpo');
			return false;
		}
	});


	$.stylist = {
		content: ['','カット','カラー','パーマ','リタッチ','縮毛矯正','白髪染め','ストレートパーマ','セット'],
		correspondence: {'color': [2, 4, 6], 'perm': [3, 5, 7]}
	};

	$.cutmodel = {
		offer: function(obj, contents) {
			var html = '';
			var schedule = [];
			contents.each(function() {
				var $this = $(this);
				var val = $this.val();
				var w = $this.closest('ol').closest('li').attr('class');
				var data = val.split(' ');
				var date = data[0].split('-');
				var time = data[1];
				schedule.push(val);
				
				html += '<li class="' + w + '"><span class="dateSpan"><strong>';
				html += w.charAt(0).toUpperCase() + w.slice(1);
				html += '</strong>' + date[1] + '.' + date[2] + '</span>';
				html += '<span class="timeSpan">' + time + '</span></li>';
			});

			$('#fancy-week').html(html).find('li:first').append('<input type="hidden" name="data[OfferSchedule][time]" value="' + schedule.join(',') + '" />');

			var $div = $(obj).closest('.stylistData');
			if ($div.size() == 0) {
				$div = $('.stylistData');
			}

			var $id = $div.find('.stylist-id');
			if ($id.size() > 0) {
				$('#fancy-stylist').val($id.val());
				// 募集内容
				contents = $div.find('.apply-content').val().split(',');
				html = '<select name="data[Offer][style]" class="fancy-content">';
				html += '<option value="1">カット</option>';
				var color = false;
				var perm = false;
				for (var i in contents) {
					var num = parseInt(contents[i]);
					if (!color && $.inArray(num, $.stylist.correspondence.color) != -1) {
						color = true;
					}
					if (!perm && $.inArray(num, $.stylist.correspondence.perm) != -1) {
						perm = true;
					}
				}
				if (color) {
					html += '<option value="2">カラー</option>';
				}
				if (perm) {
					html += '<option value="3">パーマ</option>';
				}
				if (color) {
					html += '<option value="4">カット＋カラー</option>';
				}
				if (perm) {
					html += '<option value="5">カット＋パーマ</option>';
				}
				html += '</select>';
				$('#fancy-content').html(html);

				$('.select2, .select3').hide();
			} else {
				$('#fancy-cutmodel').val($div.find('.cutmodel-id').val());
				if (window.confirm('カットモデルにオファーしてもよろしいですか？')) {
					$('#offer-form').submit();
				}
				return false;
			}
			return true;
		}
	}

	$('.offer').fancybox({
		'titlePosition': 'inside',
		'transitionIn': 'none',
		'transitionOut': 'none',
		'onStart': function(links, index) {
			// 希望日時
			var contents = $('.weeks').find('input[type="checkbox"]:checked');
			if (contents.size() > 3) {
				alert('希望日時は3つまでにしてください。');
				return false;
			}
			return $.cutmodel.offer(links[index], contents);
		}
	});

	$('.offer-schedule').fancybox({
		'titlePosition': 'inside',
		'transitionIn': 'none',
		'transitionOut': 'none',
		'onStart': function(links, index) {
			// 希望日時
			var contents = $(links[index]).prev('input');
			if (contents.size() > 3) {
				alert('希望日時は3つまでにしてください。');
				return false;
			}
			return $.cutmodel.offer(links[index], contents);
		}
	});

	$('.adjust-stylist').fancybox({
		'titlePosition': 'inside',
		'transitionIn': 'none',
		'transitionOut': 'none',
		'onStart': function(links, index) {
			var offer = $(links[index]).attr('id').split('-');
			$('#fancy-offer-id').val(offer[1]);
			$('#dateList').show(0);
		},
		'onCleanup': function() {
			$('#dateList').hide(0);
		}
	});

	$('.adjust-cutmodel').fancybox({
		'titlePosition': 'inside',
		'transitionIn': 'none',
		'transitionOut': 'none',
		'onStart': function(links, index) {
			console.log($(links[index]).attr('id'));
			var stylist = $(links[index]).attr('id').split('-');
			$('#dateList-' + stylist[1]).show(0).find('.fancy-offer-id').val(stylist[2]);;
		},
		'onCleanup': function(links, index) {
			var stylist = $(links[index]).attr('id').split('-');
			$('#dateList-' + stylist[1]).hide(0);
		}
	});

	$('.offer-accept').click(function() {
		$form = $(this).closest('aside').find('.form-accept');
		$radio = $form.find('input[type="radio"]:checked');
		if ($radio.size() == 0) {
			alert('スケジュールを選択してください。');
		} else {
			var url = $form.attr('action') + $radio.val() + '/';
			window.location.href = url;
		}
		return false;
	});

	$('.offer-cancel').click(function() {
		if (window.confirm('本当にやめてもよろしいですか？')) {
			$(this).closest('.form-cancel').submit();
		}
		return false;
	});

	$('#offer-submit').click(function() {
		$('#offer-form').submit();
		return false;
	});

	$('.offer-adjust').click(function() {
		$form = $(this).closest('form');
		if ($form.find('input[type="checkbox"]:checked').size() > 3) {
			alert('希望日時は3つまでにしてください。');
			return false;
		}
		
		$form.submit();
		return false;
	});

	// fade
	$('.fadeBtn').hover(
		function(){
			$(this).stop(true, true).fadeTo(0, 0.3);
		},
		function(){
			$(this).stop(true, true).fadeTo(0, 1);
		}
	);

	$('#search-refinement').click(function() {
		$(this).closest('form').submit();
		return false;
	});

	var $btn = $('.cutUl').find('.fadeBtn');
	$btn.click(function() {
		if ($(this).closest('li').hasClass('offer-checked')) {
			return false;
		}
		var index = $btn.index(this);
		var val = index == 0 ? 1 : 0;
		$.ajax({
			'url':'/json/offer/accept/',
			'data':{'accept':val},
			'success': function(json) {
				if (json.success == 1) {
					$('.offer-checked').removeClass('offer-checked');
					$('.cutUl').find('li').eq(index).addClass('offer-checked');
				}
			}
		});
	});

	// drow border
	var winHeight, winWidth, $borderTopDiv, $borderLeftDiv, $borderRightDiv, $borderBottomDiv;
	$borderTopDiv=$('<div class="outerBorder" />');
	$borderLeftDiv=$('<div class="outerBorder" />');
	$borderRightDiv=$('<div class="outerBorder" />');
	$borderBottomDiv=$('<div class="outerBorder" />');
	$('body').append($borderTopDiv).append($borderLeftDiv).append($borderRightDiv).append($borderBottomDiv);
	
	var resizeBorder=function(){
		
		winHeight=$(window).height();
		winWidth=$(window).width();
		
				
		$borderTopDiv.css({
			top:0,
			left:0,
			height:6,
			width:winWidth,
			borderLeft:'#AAFF11 5px solid'
		});
		$borderLeftDiv.css({
			top:0,
			left:0,
			height:winHeight,
			width:6
		});
		$borderRightDiv.css({
			top:0,
			right:0,
			height:winHeight,
			width:6
		});
		$borderBottomDiv.css({
			bottom:0,
			left:0,
			height:6,
			width:winWidth
		});
		
	};

	$(document).on('click', '.fancy-date', function() {
		$('#offer-box').stop().animate({opacity: 1}, 200);
		return false;
	}).on('click', '.close-offer', function() {
		$('#offer-box').stop().animate({opacity: 0}, 200);
		return false;
	}).on('mouseenter', '.txtSpan', function() {
		$(this).find('.pupBox').fadeIn();
	}).on('mouseleave', '.txtSpan', function() {
		$(this).find('.pupBox').hide();
	}).on('change', '.fancy-content', function() {
		var val = $(this).val();
		if (val == 2 || val == 3) {
			$('.select1').slideUp('fast');
		} else {
			$('.select1').slideDown('fast');
		}
		
		if (val == 2 || val == 4) {
			$('.select2').slideDown('fast');
		} else {
			$('.select2').slideUp('fast');
		}

		if (val == 3 || val == 5) {
			$('.select3').slideDown('fast');
		} else {
			$('.select3').slideUp('fast');
		}
	});

	// add event
	$(window).resize(resizeBorder);
	// onload
	resizeBorder();
	jQuery.event.add(window, "load", resizeBorder);
	
});

function getUrlVars() {
	var vars = [], hash; 
	var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&'); 
	for(var i = 0; i < hashes.length; i++) { 
		hash = hashes[i].split('='); 
		vars.push(hash[0]); 
		vars[hash[0]] = hash[1]; 
	} 
	return vars;
} 