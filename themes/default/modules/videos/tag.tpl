<!-- BEGIN: main -->
<!-- BEGIN: topicdescription -->
<div class="news_column">
	<div class="alert alert-info clearfix">
		<h3>{TOPPIC_TITLE}</h3>
		<!-- BEGIN: image -->
		<img alt="{TOPPIC_TITLE}" src="{HOMEIMG1}" width="{IMGWIDTH1}" class="img-thumbnail pull-left imghome" />
		<!-- END: image -->
		<p class="text-justify">{TOPPIC_DESCRIPTION}</p>
	</div>
</div>
<!-- END: topicdescription -->

<!-- BEGIN: topic -->
<div class="news_column panel panel-default">
	<div class="panel-body">
		<!-- BEGIN: homethumb -->
		<div class="videos-thumbnail pull-left col-md-6 col-lg-6 col-xs-6">
			<a href="{TOPIC.link}" title="{TOPIC.title}"><img alt="{TOPIC.alt}" src="{TOPIC.src}" width="{TOPIC.width}" class="img-thumbnail pull-left imghome" /></a>
		</div>
		<!-- END: homethumb -->
		<div class="videos-thumbnail pull-left col-md-18 col-lg-18 col-xs-18">
			<h3><a href="{TOPIC.link}" title="{TOPIC.title}">{TOPIC.title}</a></h3>
			<p>
				<em>{TIME}</em>
			</p>
			<!-- BEGIN: adminlink -->
			<p class="text-right">
				{ADMINLINK}
			</p>
			<!-- END: adminlink -->
		</div>
	</div>
</div>
<!-- END: topic -->
<!-- BEGIN: other -->
<ul class="related">
	<!-- BEGIN: loop -->
	<li>
		<a title="{TOPIC_OTHER.title}" href="{TOPIC_OTHER.link}">{TOPIC_OTHER.title}</a>
		<em>({TOPIC_OTHER.publtime})</em>
	</li>
	<!-- END: loop -->
</ul>
<!-- END: other -->

<!-- BEGIN: generate_page -->
<div class="text-center">
	{GENERATE_PAGE}
</div>
<!-- END: generate_page -->
<!-- END: main -->