<!-- BEGIN: main -->
<!-- BEGIN: playlistdescription -->
<div class="news_column">
	<div class="alert alert-info clearfix">
		<h3>{PLAYLIST_TITLE}</h3>
		<!-- BEGIN: image -->
		<img alt="{PLAYLIST_TITLE}" src="{HOMEIMG1}" width="{IMGWIDTH1}" class="img-thumbnail pull-left imghome" />
		<!-- END: image -->
		<p class="text-justify">{PLAYLIST_DESCRIPTION}</p>
	</div>
</div>
<!-- END: playlistdescription -->

<!-- BEGIN: playlist -->
<div class="news_column panel panel-default">
	<div class="panel-body">
		<!-- BEGIN: homethumb -->
		<a href="{PLAYLIST.link}" title="{PLAYLIST.title}"><img alt="{PLAYLIST.alt}" src="{PLAYLIST.src}" width="{PLAYLIST.width}" class="img-thumbnail pull-left imghome" /></a>
		<!-- END: homethumb -->
		<h3><a href="{PLAYLIST.link}" title="{PLAYLIST.title}">{PLAYLIST.title}</a></h3>
		<p>
			<em class="fa fa-clock-o">&nbsp;</em><em>{TIME} {DATE}</em>
		</p>
		<p class="text-justify">
			{PLAYLIST.hometext}
		</p>
		<!-- BEGIN: adminlink -->
		<p class="text-right">
			{ADMINLINK}
		</p>
		<!-- END: adminlink -->
	</div>
</div>
<!-- END: playlist -->
<!-- BEGIN: other -->
<ul class="related">
	<!-- BEGIN: loop -->
	<li>
		<a title="{PLAYLIST_OTHER.title}" href="{PLAYLIST_OTHER.link}">{PLAYLIST_OTHER.title}</a>
		<em>({PLAYLIST_OTHER.publtime})</em>
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