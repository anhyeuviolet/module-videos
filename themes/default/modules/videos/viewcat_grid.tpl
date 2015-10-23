<!-- BEGIN: main -->
<!-- BEGIN: viewdescription -->
<div class="news_column">
	<div class="alert alert-info clearfix">
		<h3>{CONTENT.title}</h3>
		<!-- BEGIN: image -->
		<img alt="{CONTENT.title}" src="{HOMEIMG1}" width="{IMGWIDTH1}" class="img-thumbnail pull-left imghome" />
		<!-- END: image -->
		<p class="text-justify">{CONTENT.description}</p>
	</div>
</div>
<!-- END: viewdescription -->
<!-- BEGIN: viewcatloop -->
<div class="col-sm-12 col-md-8">
	<div class="thumbnail" style="min-height:{VID_HEIGHT}px">
		<!-- BEGIN: image -->
		<a title="{CONTENT.title}" href="{CONTENT.link}"><img alt="{HOMEIMGALT1}" src="{HOMEIMG1}" width="{IMGWIDTH1}" class="img-responsive"/></a>
		<!-- END: image -->
		<div class="caption text-center">
			<h4><a class="show" href="{CONTENT.link}" title="{CONTENT.title}">{CONTENT.title}</a></h4>
			<span>{ADMINLINK}</span>
		</div>
	</div>
</div>
<!-- END: viewcatloop -->
<div class="clear">&nbsp;</div>

<!-- BEGIN: generate_page -->
<div class="text-center">
	{GENERATE_PAGE}
</div>
<!-- END: generate_page -->
<!-- END: main -->