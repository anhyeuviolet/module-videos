<!-- BEGIN: main -->
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/star-rating/jquery.rating.pack.js"></script>
<script src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/star-rating/jquery.MetaData.js" type="text/javascript"></script>
<link href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/star-rating/jquery.rating.css" type="text/css" rel="stylesheet"/>
<div class="panel panel-default">
	<div class="panel-body">
		<h3 class="title margin-bottom-lg">{DETAIL.title}</h3>
		<div class="row margin-bottom-lg">
            <div class="col-md-12">
                <span class="h5">{DETAIL.publtime}</span>
            </div>
        </div>
		<div class="detail_video">
			<div class="videoplayer">
				<!-- BEGIN: vid_jw_content -->
				<div id="videoCont">
					<img src="{NV_BASE_SITEURL}themes/default/images/{MODULE_NAME}/loading.gif" class="center-block mar_rgt_auto" alt="Loading player" />
				</div>
				<!-- END: vid_jw_content -->
				
				<!-- BEGIN: vid_facebook_content -->
				<div class="fb-video" data-href="{DETAIL.vid_path}" data-width="auto" data-allowfullscreen="true"></div>				
				<!-- END: vid_facebook_content -->
			</div>
			<div class="clearfix"></div>
			<!-- BEGIN: socialbutton -->
			<div class="socialicon clearfix margin-bottom-lg margin-top-lg">
				<div class="fb-like" data-href="{SELFURL}" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">&nbsp;</div>
				<div class="g-plusone" data-size="medium"></div>
				<a href="http://twitter.com/share" class="twitter-share-button">Tweet</a>
			</div>
			<!-- END: socialbutton -->
		</div>
		
		<!-- BEGIN: no_public -->
		<div class="alert alert-warning">
			{LANG.no_public}
		</div>
		<!-- END: no_public -->
		<!-- BEGIN: showhometext -->
		<div class="clearfix margin-bottom-lg">
            <div class="hometext">{DETAIL.hometext}</div>
		</div>
		<!-- END: showhometext -->
		<div id="news-bodyhtml" class="bodytext margin-bottom-lg">
			{DETAIL.bodytext}
		</div>
		<!-- BEGIN: author -->
        <div class="margin-bottom-lg">
    		<!-- BEGIN: name -->
    		<p class="h5 text-right">
    			<strong>{LANG.author}: </strong>{DETAIL.author}
    		</p>
    		<!-- END: name -->
    		<!-- BEGIN: source -->
    		<p class="h5 text-right">
    			<strong>{LANG.source}: </strong>{DETAIL.source}
    		</p>
    		<!-- END: source -->
        </div>
		<!-- END: author -->
		<!-- BEGIN: copyright -->
		<div class="alert alert-info margin-bottom-lg">
			{COPYRIGHT}
		</div>
		<!-- END: copyright -->
    </div>
</div>

<!-- BEGIN: keywords -->
<div class="news_column panel panel-default">
	<div class="panel-body">
        <div class="h5">
            <em class="fa fa-tags">&nbsp;</em><strong>{LANG.keywords}: </strong><!-- BEGIN: loop --><a title="{KEYWORD}" href="{LINK_KEYWORDS}"><em>{KEYWORD}</em></a>{SLASH}<!-- END: loop -->
        </div>
    </div>
</div>
<!-- END: keywords -->

<!-- BEGIN: adminlink -->
<p class="text-center margin-bottom-lg">
    {ADMINLINK}
</p>
<!-- END: adminlink -->

<!-- BEGIN: allowed_rating -->
<div class="news_column panel panel-default">
	<div class="panel-body">
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
                    <input class="hover-star" type="radio" value="1" title="{LANGSTAR.verypoor}" /><input class="hover-star" type="radio" value="2" title="{LANGSTAR.poor}" /><input class="hover-star" type="radio" value="3" title="{LANGSTAR.ok}" /><input class="hover-star" type="radio" value="4" title="{LANGSTAR.good}" /><input class="hover-star" type="radio" value="5" title="{LANGSTAR.verygood}" /><span id="hover-test" style="margin: 0 0 0 20px;">{LANGSTAR.note}</span>
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
<!-- END: allowed_rating -->

<!-- BEGIN: comment -->
<div class="news_column panel panel-default">
	<div class="panel-body">
	{CONTENT_COMMENT}
    </div>
</div>
<!-- END: comment -->

<!-- BEGIN: others -->
<div class="panel panel-default">
	<div class="panel-body other-news">
    	<!-- BEGIN: playlist -->
        <div class="clearfix">
        	<p class="h3"><strong>{LANG.playlist}</strong></p>
            <div class="clearfix">
            	<ul class="related">
            		<!-- BEGIN: loop -->
            		<li>
            			<em class="fa fa-angle-right">&nbsp;</em>
            			<a href="{PLAYLIST.link}"<!-- BEGIN: tooltip --> data-placement="{TOOLTIP_POSITION}" data-content="{PLAYLIST.hometext}" data-img="{PLAYLIST.imghome}" data-rel="tooltip"<!-- END: tooltip --> title="{PLAYLIST.title}">{PLAYLIST.title}</a>
            			<em>({PLAYLIST.time})</em>
            			<!-- BEGIN: newday -->
            			<span class="icon_new">&nbsp;</span>
            			<!-- END: newday -->
            		</li>
            		<!-- END: loop -->
            	</ul>
            </div>
        	<p class="text-right">
        		<a title="{PLAYLIST.playlisttitle}" href="{PLAYLIST.playlistlink}">{LANG.more}</a>
        	</p>
        </div>
    	<!-- END: playlist -->
        
    	<!-- BEGIN: related_new -->
    	<p class="h3"><strong>{LANG.related_new}</strong></p>
    	<div class="clearfix">
            <ul class="related">
        		<!-- BEGIN: loop -->
        		<li>
        			<em class="fa fa-angle-right">&nbsp;</em>
        			<a href="{RELATED_NEW.link}"<!-- BEGIN: tooltip --> data-placement="{TOOLTIP_POSITION}" data-content="{RELATED_NEW.hometext}" data-img="{RELATED_NEW.imghome}" data-rel="tooltip"<!-- END: tooltip -->>{RELATED_NEW.title}</a>
        			<em>({RELATED_NEW.time})</em>
        			<!-- BEGIN: newday -->
        			<span class="icon_new">&nbsp;</span>
        			<!-- END: newday -->
        		</li>
        		<!-- END: loop -->
        	</ul>
        </div>
    	<!-- END: related_new -->
        
    	<!-- BEGIN: related -->
    	<p class="h3"><strong>{LANG.related}</strong></p>
    	<div class="clearfix">
            <ul class="related">
        		<!-- BEGIN: loop -->
        		<li>
        			<em class="fa fa-angle-right">&nbsp;</em>
        			<a class="list-inline" href="{RELATED.link}"<!-- BEGIN: tooltip --> data-placement="{TOOLTIP_POSITION}" data-content="{RELATED.hometext}" data-img="{RELATED.imghome}" data-rel="tooltip"<!-- END: tooltip -->>{RELATED.title}</a>
        			<em>({RELATED.time})</em>
        			<!-- BEGIN: newday -->
        			<span class="icon_new">&nbsp;</span>
        			<!-- END: newday -->
        		</li>
        		<!-- END: loop -->
        	</ul>
        </div>
    	<!-- END: related -->
    </div>
</div>
<!-- END: others -->

<!-- BEGIN: jwplayer -->
<script type="text/javascript" src="{NV_BASE_SITEURL}themes/default/modules/{MODULE_NAME}/jwplayer/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="NqPyv5C3s2LTybLMlqx3nfOJTvmRqu9cuQPTrQ==";</script>
<script type="text/javascript">
var playerInstance = jwplayer("videoCont");
playerInstance.setup({
	image: "{DETAIL.image.src}",
	autostart: false,
	aspectratio: "16:9",
	controls: true,
	displaydescription: true,
	playlist: "{NV_BASE_SITEURL}{MODULE_NAME}/player/{RAND_SS}{DETAIL.fake_pl_id}-{DETAIL.newscheckss}-{RAND_SS}{DETAIL.id}/",
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
<!-- END: jwplayer -->
<!-- END: main -->

<!-- BEGIN: no_permission -->
<div class="alert alert-info">
	{NO_PERMISSION}
</div>
<!-- END: no_permission -->