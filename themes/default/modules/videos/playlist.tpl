<!-- BEGIN: main -->
<!-- BEGIN: playlistdescription -->
<div class="news_column">
	<div class="alert alert-info clearfix">
		<h3>{PLAYLIST_TITLE}</h3>
		<p class="text-justify">{PLAYLIST_DESCRIPTION}</p>
	</div>
</div>
<!-- END: playlistdescription -->

<!-- BEGIN: player -->
<div class="detail_video">
	<div class="videoplayer">
		<div id="videoCont"></div>
	</div>
</div>
<script type="text/javascript" src="{NV_BASE_SITEURL}themes/default/modules/{MODULE_NAME}/jwplayer/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="NqPyv5C3s2LTybLMlqx3nfOJTvmRqu9cuQPTrQ==";</script>
<script type="text/javascript">
var playerInstance = jwplayer("videoCont");
playerInstance.setup({
	image: "{PLAYLIST_IMAGE}",
	autostart: false,
	aspectratio: "16:9",
	playlist : "{NV_BASE_SITEURL}{MODULE_NAME}/playlistsrss/{RAND_SS}{PLAYLIST_ID}-{PLIST_CHECKSS}/",
	controls: true,
	displaydescription: true,
	displaytitle: true,
	flashplayer: "{NV_BASE_SITEURL}themes/default/modules/{MODULE_NAME}/jwplayer/jwplayer.flash.swf",
	primary: "html5",
	repeat: false,
	skin: {"name": "stormtrooper"},
	stagevideo: false,
	stretching: "uniform",
	visualplaylist: true,
	width: "100%"
  });
</script>
<!-- END: player -->
<div class="clearfix"></div>
<!-- BEGIN: socialbutton -->
<div class="socialicon clearfix margin-bottom-lg margin-top-lg">
	<div class="fb-like" data-href="{SELFURL}" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">&nbsp;</div>
	<div class="g-plusone" data-size="medium"></div>
	<a href="http://twitter.com/share" class="twitter-share-button">Tweet</a>
</div>
<!-- END: socialbutton -->

<!-- BEGIN: playlist_loop -->
<div class="news_column panel panel-default">
	<div class="panel-body">
		<!-- BEGIN: homethumb -->
		<a href="{PLAYLIST_LOOP.link}" title="{PLAYLIST_LOOP.title}"><img alt="{PLAYLIST_LOOP.alt}" src="{PLAYLIST_LOOP.src}" width="{PLAYLIST_LOOP.width}" class="img-thumbnail pull-left imghome" /></a>
		<!-- END: homethumb -->
		<h3><a href="{PLAYLIST_LOOP.link}" title="{PLAYLIST_LOOP.title}">{PLAYLIST_LOOP.title}</a></h3>
		<p>
			<em class="fa fa-clock-o">&nbsp;</em><em>{TIME} {DATE}</em>
		</p>
		<p class="text-justify">
			{PLAYLIST_LOOP.hometext}
		</p>
		<!-- BEGIN: adminlink -->
		<p class="text-right">
			{ADMINLINK}
		</p>
		<!-- END: adminlink -->
	</div>
</div>
<!-- END: playlist_loop -->


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