<aside class="hideScedule">
	<nav class="navi"><ul>
		<li class="prev"><a href=""><span>PREV WEEK</span></a></li>
		<li class="next"><a href=""><span>NEXT WEEK</span></a></li>
	</ul></nav>
	
	<div class="weeksWrapper">
		<div class="weeks">
{% for calendar in calendars %}
{% set day_of_week = {'0':'sun', '1':'mon', '2':'tue', '3':'wed', '4':'thu', '5':'fri', '6':'sat'} %}
			<!-- week -->
			<div class="week">
				<p class="month">{{ calendar[0][1].year }}年&nbsp;{{ calendar[0][1].month }}月</p>
				<ol class="day">
{% for w,line in calendar %}
					<li class="{{ day_of_week[w] }} week-of-days">
						<h1><strong>{{ day_of_week[w]|capitalize }}</strong></h1>
						<ol class="hour">
{% for day in line %}
{% if day is empty %}
							<li class="empty">&nbsp;</li>
{% else %}

{% if logindata is not null and logindata.Schedule[day.year][day.month][day.day] == 0 %}
	{% set checked = '' %}
{% else %}
	{% set checked = 'checked' %}
{% endif %}

{% set name = 'Schedule.recept.'~day.year~'.'~day.month~'.'~day.day %}
							<li{% if day.holiday == 1 %} class="holiday"{% endif %}><label>{{ form.checkbox(name, {'checked':checked}) }}{{ day.day }}</label></li>
{% endif %}
{% endfor %}
						</ol>
					</li>
{% endfor %}
				</ol>
			</div>
{% endfor %}
</aside>