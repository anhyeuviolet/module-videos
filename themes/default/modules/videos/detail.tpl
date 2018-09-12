<!-- BEGIN: main -->
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/star-rating/jquery.rating.pack.js"></script>
<script src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/star-rating/jquery.MetaData.js" type="text/javascript"></script>
<link href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/star-rating/jquery.rating.css" type="text/css" rel="stylesheet"/>
<div class="detail_container col-xs-24 col-md-24 col-lg-24">
	<div class="detail_video row">
		<div class="detail_header cf">
			<h3 class="title">{DETAIL.title}</h3>
			<!-- BEGIN: socialbutton -->
			<div class="social-icon col-xs-12 col-md-12 col-lg-12 clearfix margin-bottom-lg margin-top-lg">
				<div class="fb-like" data-href="{SELFURL}" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">&nbsp;</div>
			</div>
			<div class="clearfix"></div>
			<!-- END: socialbutton -->
		</div>
		<!-- BEGIN: no_jwp_lic_admin -->
		<div class="alert alert-warning"><a href="{SETTING_LINKS}" title="{LANG.no_jwp_lic_admin}"><strong>{LANG.no_jwp_lic_admin}</strong>&nbsp;<em class="fa fa-external-link"></em></a> </div>
		<!-- END: no_jwp_lic_admin -->
		
		<!-- BEGIN: no_jwp_lic -->
		<div class="alert alert-warning"><strong>{LANG.no_jwp_lic}</strong></div>
		<!-- END: no_jwp_lic -->
		
		<div class="videoplayer cf">
			<div class="player-position">
				<!-- BEGIN: vid_jw_content -->
				<div id="videoCont_{DETAIL.id}">
					<i class="fa fa-spinner fa-pulse fa-3x fa-fw center-block"></i>
				</div>
				<!-- END: vid_jw_content -->
			</div>
		</div>
		<div class="uploader cf margin-bottom-lg margin-top-lg">
			<div class="pd0 col-xs-3 col-md-2 col-sm-2 col-lg-1">
				<a href="{DETAIL.uploader_link}" title="{DETAIL.uploader_name}">
					<img src="{DETAIL.uploader_gravatar}" alt="{DETAIL.uploader_name}" title="{DETAIL.uploader_name}" class="img-thumbnail img-responsive">
				</a>
			</div>
			
			<div class="col-md-18 col-sm-18 col-lg-18">
				<p><a href="{DETAIL.uploader_link}" title="{DETAIL.uploader_name}"><strong>{DETAIL.uploader_name}</strong></a></p>
				<p>{DETAIL.publtime}</p>
			</div>
			
			<!-- BEGIN: hitstotal -->
			<div class="hitstotal col-md-4 col-sm-4 col-lg-4 pull-right">
				{DETAIL.hitstotal}&nbsp;{LANG.hits_view}
			</div>
			<!-- END: hitstotal -->
		</div>
		<div class="media-func group fn-tabgroup">
			<a title="{LANG.playlist_add_video}"<!-- BEGIN: not_user --> onclick="nv_colapse_report(); return loginForm();"<!-- END: not_user --><!-- BEGIN: plist_is_user --> onclick="nv_colapse_report( );" data-toggle="collapse" data-target="#add_to_userlist"<!-- END: plist_is_user --> href="#" class="button-style-1 fn-tab">
			<span><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;{LANG.playlist_add_video}</span>
		</a>
		
		<a title="{LANG.video_favorite}"<!-- BEGIN: not_user --> onclick="return loginForm();"<!-- END: not_user --> <!-- BEGIN: favorite_is_user --> onclick="nv_favourite_videos('{DETAIL.id}','fav','{NEWSCHECKSS}','{DETAIL.check_session}');"<!-- END: favorite_is_user --> href="#" class="button-style-1 fn-tab">
		<span id="favourite-{DETAIL.id}"><i class="fa fa-spinner fa-pulse fa-fw center-block"></i></span>
	</a>
	
	<a title="{LANG.video_report}" href="#" class="button-style-1 fn-tab" data-toggle="collapse" data-target="#report_videos" onclick="nv_colapse_favourites( );">
		<span><i class="fa fa-flag" aria-hidden="true"></i>&nbsp;{LANG.video_report}</span>
	</a>
	
	<div id="add_to_userlist" class="show_playlist clear collapse add-playlist-region" value="{DETAIL.id}">
		<i class="fa fa-spinner fa-pulse fa-2x fa-fw center-block"></i>
	</div>
	
	<div id="report_videos" class="show_report clear collapse add-playlist-region">
		<div class="add-playlist-region report">
			<h4 class="margin-bottom-lg">
				<span class="margin-bottom-lg">{LANG.report_select}</span>
				<span title="Close" class="close fn-closetab" data-toggle="collapse" data-target="#report_videos"><i class="fa fa-times" aria-hidden="true"></i></span>
			</h4>
			<!-- BEGIN: report_videos -->
			<input type="radio" title="{REPORT.title}" name="report_videos" value="{REPORT.value}">{REPORT.title}<br>
			<!-- END: report_videos -->
			<a class="btn btn-primary fix-button fn-add margin-top-lg" onclick="nv_report_videos('{DETAIL.id}', '{NEWSCHECKSS}');">
				<span class="report-video">{LANG.report_send}</span>
			</a>
		</div>
	</div>
</div>
</div>
<!-- BEGIN: no_public -->
<div class="clear">
	<div class="alert alert-warning">
		{LANG.no_public}
	</div>
</div>
<!-- END: no_public -->

<!-- BEGIN: bodyhtml -->
<div class="panel panel-default bodytext_shorten row">
	<div id="news-bodyhtml" class="bodytext panel-body">
		{DETAIL.bodyhtml}
	</div>
</div>
<!-- END: bodyhtml -->
<!-- BEGIN: author -->
<div class="clear margin-bottom-lg">
	<!-- BEGIN: name -->
	<p class="h5 text-right">
		<strong>{LANG.author}: </strong>{DETAIL.author}
	</p>
	<!-- END: name -->
	<p class="h5 text-right">
		<strong>{LANG.artist}: </strong>{DETAIL.artist}
	</p>
	<!-- BEGIN: source -->
	<p class="h5 text-right">
		<strong>{LANG.source}: </strong>{DETAIL.source}
	</p>
	<!-- END: source -->
</div>
<!-- END: author -->
<!-- BEGIN: copyright -->
<div class="row alert alert-info margin-bottom-lg">
	{COPYRIGHT}
</div>
<!-- END: copyright -->
</div>
<!-- BEGIN: allowed_rating -->
<div class="panel panel-default clear">
	<div class="news_column panel-body">
		<div class="col-md-24">
			<form id="form3B" action="">
				<div class="h5 clearfix">
					<p>{STRINGRATING}</p>
					<!-- BEGIN: data_rating -->
					<span itemscope itemtype="http://data-vocabulary.org/Review-aggregate">{LANG.rating_average}:
						<span itemprop="rating">{DETAIL.numberrating}</span> -
						<span itemprop="votes">{DETAIL.click_rating}</span> {LANG.rating_count}
					</span>
					<!-- END: data_rating -->
					<div style="padding: 5px;">
						<input class="hover-star" type="radio" value="1" title="{LANGSTAR.verypoor}" /><input class="hover-star" type="radio" value="2" title="{LANGSTAR.poor}" /><input class="hover-star" type="radio" value="3" title="{LANGSTAR.ok}" /><input class="hover-star" type="radio" value="4" title="{LANGSTAR.good}" /><input class="hover-star" type="radio" value="5" title="{LANGSTAR.verygood}" /><span id="hover-test" style="margin: 0 0 0 20px;"></span>
					</div>
				</div>
			</form>
			<script>
				$(function() {
					var sr = 0;
					$(".hover-star").rating({
						focus: function(b, c) {
							var a = $("#hover-test");
							2 != sr && (a[0].data = a[0].data || a.html(), a.html(c.title || "value: " + b), sr = 1)
						},
						blur: function(b, c) {
							var a = $("#hover-test");
							2 != sr && ($("#hover-test").html(a[0].data || ""), sr = 1)
						},
						callback: function(b, c) {
							1 == sr && (sr = 2, $(".hover-star").rating("disable"), sendrating("{NEWSID}", b, "{NEWSCHECKSS}"))
						}
					});
					$(".hover-star").rating("select", "{NUMBERRATING}");
					<!-- BEGIN: disablerating -->
					$(".hover-star").rating('disable');
					sr = 2;
					<!-- END: disablerating -->
				})
			</script>
		</div>
	</div>
</div>
<!-- END: allowed_rating -->

<!-- BEGIN: keywords -->
<div class="panel panel-default">
	<div class="news_column panel-body">
		<em class="fa fa-tags">&nbsp;</em>
		<!-- BEGIN: loop -->
		<a class="video-tags btn btn-default" title="{KEYWORD}" href="{LINK_KEYWORDS}">
			<em>{KEYWORD}</em>
		</a>
		<!-- END: loop -->
	</div>
</div>
<!-- END: keywords -->

<!-- BEGIN: adminlink -->
<p class="text-center margin-bottom-lg">
    {ADMINLINK}
</p>
<!-- END: adminlink -->

<!-- BEGIN: comment -->
<div class="panel panel-default">
	<div class="panel-body">
		<div class="comment_box">
			{CONTENT_COMMENT}
		</div>
	</div>
</div>
<!-- END: comment -->

<!-- BEGIN: others -->
<div class="news_column panel panel-default">
	<div class="panel-body other-news">
    	<!-- BEGIN: related_new -->
    	<p class="h3"><strong>{LANG.related_new}</strong></p>
    	<div class="row clearfix related_new">
			<!-- BEGIN: loop -->
			<div class="col-md-{PER_LINE} col-lg-{PER_LINE} col-sm-12 col-xs-24 videos_list">
				<!-- BEGIN: image -->
				<div class="videos-home-thumbnail pull-left col-md-24 col-lg-24 col-xs-24">
					<a class="clearfix" title="{RELATED_NEW.title}" href="{RELATED_NEW.link}">
						<img src="{RELATED_NEW.imghome}" alt="{HOMEIMGALT}" class="imghome img-responsive" width="{IMGWIDTH}" height="{IMGHEIGHT}"/>
					</a>
				</div>
				<!-- END: image -->
				<div class="videos-home-info pull-left col-md-24 col-lg-24 col-xs-24">
					<h3 class="clearfix">
						<a title="{RELATED_NEW.title}" href="{RELATED_NEW.link}">{RELATED_NEW.title_cut}</a>
					</h3>
					<div class="text-muted">
						<ul class="list-unstyled">
							<li>{LANG.by}&nbsp;<a href="{RELATED_NEW.uploader_link}" title="{RELATED_NEW.uploader_name}">{RELATED_NEW.uploader_name}</a></li>
							<li class="pull-left">{RELATED_NEW.time}</li>
							<!-- BEGIN: hitstotal -->
							<li class="spacer pull-left"></li>
							<li>{RELATED_NEW.hitstotal}&nbsp;{LANG.hits_view}</li>
							<!-- END: hitstotal -->
						</ul>
					</div>
				</div>
			</div>
			<!-- END: loop -->
		</div>
    	<!-- END: related_new -->
		
    	<!-- BEGIN: related -->
    	<p class="h3"><strong>{LANG.related}</strong></p>
    	<div class="row clearfix related">
			<!-- BEGIN: loop -->
			<div class="col-md-{PER_LINE} col-lg-{PER_LINE} col-sm-12 col-xs-24 videos_list">
				<!-- BEGIN: image -->
				<div class="videos-home-thumbnail pull-left col-md-24 col-lg-24 col-xs-24">
					<a class="clearfix" title="{RELATED.title}" href="{RELATED.link}">
						<img src="{RELATED.imghome}" alt="{HOMEIMGALT}" class="imghome img-responsive" width="{IMGWIDTH}" height="{IMGHEIGHT}"/>
					</a>
				</div>
				<!-- END: image -->
				<div class="videos-home-info pull-left col-md-24 col-lg-24 col-xs-24">
					<h3 class="clearfix">
						<a title="{RELATED.title}" href="{RELATED.link}">{RELATED.title_cut}</a>
					</h3>
					<div class="text-muted">
						<ul class="list-unstyled">
							<li>{LANG.by}&nbsp;<a href="{RELATED.uploader_link}" title="{RELATED.uploader_name}">{RELATED.uploader_name}</a></li>
							<li class="pull-left">{RELATED.time}</li>
							<!-- BEGIN: hitstotal -->
							<li class="spacer pull-left"></li>
							<li>{RELATED.hitstotal}&nbsp;{LANG.hits_view}</li>
							<!-- END: hitstotal -->
						</ul>
					</div>
				</div>
			</div>
			<!-- END: loop -->
		</div>
    	<!-- END: related -->
	</div>
</div>
<!-- END: others -->

<!-- BEGIN: fb_comment -->
<div class="panel panel-default">
	<div class="panel-body">
		<div class="fb-comments" data-href="{SELFURL}" data-order-by="time" data-numposts="5" data-width="100%"></div>	
	</div>
</div>
<!-- END: fb_comment -->

<!-- BEGIN: jwplayer_js -->
<script type="text/javascript">var jw_lib_location = "{NV_BASE_SITEURL}themes/{TEMPLATE}/modules/{MODULE_FILE}/jwplayer/";</script>

<script type="text/javascript" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/modules/{MODULE_FILE}/jwplayer/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="{VIDEO_CONFIG.jwplayer_license}";</script>
<!-- END: jwplayer_js -->

<!-- BEGIN: jwplayer -->
<script type="text/javascript">
	var playerInstance_{DETAIL.id} = jwplayer("videoCont_{DETAIL.id}");
	playerInstance_{DETAIL.id}.setup({
		image: "{DETAIL.image.src}",
		autostart: {VIDEO_CONFIG.jwplayer_autoplay},
		aspectratio: "16:9",
		controls: {VIDEO_CONFIG.jwplayer_controlbar},
		displaydescription: true,
		playlist: "{DETAIL.player}",
		displaytitle: true,
		flashplayer: "{NV_BASE_SITEURL}themes/{TEMPLATE}/modules/{MODULE_FILE}/jwplayer/jwplayer.flash.swf",
		primary: "html5",
		repeat: {VIDEO_CONFIG.jwplayer_loop},
		mute: {VIDEO_CONFIG.jwplayer_mute},
		<!-- BEGIN: player_logo -->
		logo: {
			file: '{VIDEO_CONFIG.jwplayer_logo_file}',
			link: '{NV_BASE_SITEURL}',
			position: '{VIDEO_CONFIG.jwplayer_position}'
		},
		<!-- END: player_logo -->
		skin: {"name": "{VIDEO_CONFIG.jwplayer_skin}"},
		abouttext: "{LANG.jw_video_source}{VIDEO_CONFIG.site_name}",
		aboutlink: "{NV_BASE_SITEURL}",
		stagevideo: false,
		stretching: "uniform",
		<!-- BEGIN: player_sharing -->
		sharing: {
			"heading":"{LANG.video_share}",
			"sites": [
			<!-- BEGIN: loop -->
			"{SSITE.jwplayer_sharingsite}",
			<!-- END: loop -->
			]
		},
		<!-- END: player_sharing -->
		visualplaylist: true,
		width: "100%"
	});
</script>
<script type="text/javascript">
	var playerContainerEl = document.querySelector('.videoplayer');
	function getElementOffsetTop(el) {
		var boundingClientRect = el.getBoundingClientRect();
		var bodyEl = document.body;
		var docEl = document.documentElement;
		var scrollTop = window.pageYOffset || docEl.scrollTop || bodyEl.scrollTop;
		var clientTop = docEl.clientTop || bodyEl.clientTop || 0;
		return Math.round(boundingClientRect.top + scrollTop - clientTop);
	}
	function getScrollTop() {
		var docEl = document.documentElement;
		return (window.pageYOffset || docEl.scrollTop) - (docEl.clientTop || 0);
	}
	playerInstance_{DETAIL.id}.on('ready', function() {
        var config = playerInstance_{DETAIL.id}.getConfig();
        var utils = playerInstance_{DETAIL.id}.utils;
        var playerHeight = config.containerHeight;
        var playerOffsetTop = getElementOffsetTop(playerContainerEl);
        playerContainerEl.style.height = playerHeight + 'px';
        function onScrollViewHandler() {
            var minimize = getScrollTop() >= playerOffsetTop;
            utils.toggleClass(playerContainerEl, 'player-minimize', minimize);
            playerInstance_{DETAIL.id}.resize();
		}
        var isScrollTimeout = false;
        window.onscroll = function() {
            if (isScrollTimeout) return;
            isScrollTimeout = true;
            onScrollViewHandler();
            setTimeout(function() {
                isScrollTimeout = false;
			}, 80);
		};
	});
</script>
<!-- END: jwplayer -->
<script language="javascript">
	var expand_text = "{LANG.video_more_text}";
	var hide_text = "{LANG.video_less_text}";
	var report_non_check = "{LANG.report_non_check}";
	$(document).ready(function() {
		$(".bodytext_shorten").shorten({showChars: 200});
	});
	$.ajax({
		url: nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=v_funcs&mod_list=user_playlist' + '&id={DETAIL.id}' + '&fcheck={DETAIL.check_session}' + '&nocache=' + new Date().getTime(),
		type: 'post',
		dataType: 'html',
		data: {},
		success: function(data) {
			$('#add_to_userlist').html(data);
		}
	});
	
	$.ajax({
		url: nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=v_funcs&mod_list=get_fav' + '&id={DETAIL.id}' + '&fcheck={DETAIL.check_session}' + '&nocache=' + new Date().getTime(),
		type: 'post',
		dataType: 'html',
		data: {},
		success: function(data) {
			$('#favourite-{DETAIL.id}').html(data);
		}
	});
</script>
<!-- END: main -->

<!-- BEGIN: no_permission -->
<div class="alert alert-info">
	{NO_PERMISSION}
</div>
<!-- END: no_permission -->