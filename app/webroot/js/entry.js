$(function() {
	$editable = $('.editable');
	$display = $editable.find('.display');

	var selector = {'1':'.select1', '2':'.select2', '3':'.select3', '4':'.select1,.select2', '5':'.select1,.select3'};

	$editable.click(function() {
		$this = $(this);
		if (!$this.hasClass('editing')) {
			$this.addClass('current');
			$editable.addClass('editing');
			if ($this.find('.select').size() > 0) {
				var val = $this.find('select').eq(0).val();
				$('.select').not(selector[val]).hide(0);
				$(selector[val]).show(0);
			}
		}
	}).hover(function() {
		if (!$(this).hasClass('editing')) {
			$(this).find('.display').css('background-color', '#FFAAAA');
		}
	}, function() {
		if (!$(this).hasClass('editing')) {
			$(this).find('.display').css('background-color', '');
		}
	});

	$(document).on('change', '#style', function() {
		var val = $(this).val();
		$('.select').not(selector[val]).slideUp('fast');
		$(selector[val]).slideDown('fast');
	}).on('click', '.entry-submit-cutmodel', function() {
		var $list = $(this).closest('.form').find('select,textarea').not(':hidden');
		var data = {};

		$list.each(function() {
			data[$(this).attr('name')] = $(this).val();
		});

		$.ajax({
			'url': '/json/cutmodel/entry',
			'data': data,
			'success': function(json) {
				if (json.success == 1) {
					window.location.reload(true);
				}
			}
		});
		return false;
	}).on('click', '.entry-cancel', function() {
		$('.editing').removeClass('editing');
		$('.current').removeClass('current');
		return false;
	});
});