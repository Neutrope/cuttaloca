<aside class="hideScedule">
	<nav class="navi">
		<ul>
			<li class="prev"><a href=""><span>PREV WEEK</span></a></li>
			<li class="next"><a href=""><span>NEXT WEEK</span></a></li>
		</ul>
	</nav>

	<div class="weeksWrapper">
		<div class="weeks">
{% set counter = 0 %}
{% set today = 'now'|date('Ymd') %}
{% set day_of_week = {'0':'Sun','1':'Mon','2':'Tue','3':'Wed','4':'Thu','5':'Fri','6':'Sat'} %}
{% for week in weeks %}
			<!-- week -->
			<div class="week">
				<ol class="day">
{% for calendar in week %}

{% set month = '%02d'|format(calendar.Calendar.month) %}
{% set day = '%02d'|format(calendar.Calendar.day) %}
					<li class="{{ day_of_week[calendar.Calendar.day_of_week]|lower }}">
						<h1><strong>{{ day_of_week[calendar.Calendar.day_of_week] }}</strong>{{ month }}.{{ day }}</h1>
						<ol class="hour">
{% set date = calendar.Calendar.year~month~day %}
{% if stylist.Schedule[calendar.Calendar.year][calendar.Calendar.month][calendar.Calendar.day] == 1 and date >= today %}

{% if calendar.Calendar.holiday == 1 %}
	{% set start = stylist.Stylist.holiday_start %}
	{% set finish = stylist.Stylist.holiday_end %}
{% elseif calendar.Calendar.day_of_week == 6 %}
	{% set start = stylist.Stylist.saturday_start %}
	{% set finish = stylist.Stylist.saturday_end %}
{% else %}
	{% set start = stylist.Stylist.ordinary_start %}
	{% set finish = stylist.Stylist.ordinary_end %}
{% endif %}

{% for time in start..finish %}

{% if checkbox %}
{% set counter = counter + 1 %}
							<li class="empty"><input type="checkbox" value="{{ calendar.Calendar.year~'-'~month~'-'~day~' '~apply_time[time]~' '~day_of_week[calendar.Calendar.day_of_week] }}" id="time-{{ counter }}" name="data[OfferSchedule][time][]" /><label for="time-{{ counter }}">{{ apply_time[time] }}</label></li>
{% else %}
							<li class="empty">
								<input type="hidden" value="{{ calendar.Calendar.year~'-'~month~'-'~day~' '~apply_time[time]~' '~day_of_week[calendar.Calendar.day_of_week] }}" />
								<a href="#hairdresser" id="schedule-{{ hour[2] }}" class="offer-schedule"><span>{{ apply_time[time] }}</span></a>
							</li>
{% endif %}

{% endfor %}

{% else %}
							<li><span>登録なし</span></li>
{% endif %}
						</ol>
					</li>
{% endfor %}
				</ol>
			</div>
{% endfor %}
		</div>
	</div>
</aside>
