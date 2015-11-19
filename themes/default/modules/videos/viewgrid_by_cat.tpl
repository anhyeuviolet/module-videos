<!-- BEGIN: main -->
<!-- BEGIN: listcat -->
<div class="news_column">
	<div class="panel panel-default clearfix">
		<div class="panel-heading">
			<ul class="list-inline sub-list-icon" style="margin: 0">
				<li><h4><a title="{CAT.title}" href="{CAT.link}"><span>{CAT.title}</span></a></h4></li>
				<!-- BEGIN: subcatloop -->
				<li class="hidden-xs"><h4><a class="dimgray" title="{SUBCAT.title}" href="{SUBCAT.link}">{SUBCAT.title}</a></h4></li>
				<!-- END: subcatloop -->
				<!-- BEGIN: subcatmore -->
				<li class="pull-right hidden-xs"><h4><a class="dimgray" title="{MORE.title}" href="{MORE.link}"><em class="fa fa-sign-out"></em></a></h4></li>
				<!-- END: subcatmore -->
			</ul>
		</div>
		<div class="panel-body">
			<div class="row">
				<!-- BEGIN: loop -->
				<div class="col-md-8 videos_list">
					<!-- BEGIN: image -->
					<a class="clearfix" title="{CONTENT.title}" href="{CONTENT.link}">
						<img src="{HOMEIMG}" alt="{HOMEIMGALT}" <!-- BEGIN: fix_size --> width="{IMGWIDTH}" height="{IMGHEIGHT}" <!-- END: fix_size --> class="pull-left imghome" />
					</a>
					<!-- END: image -->
					<h3>
						<a title="{CONTENT.title}" href="{CONTENT.link}">{CONTENT.title}</a>
						<!-- BEGIN: newday -->
						<span class="icon_new"></span>
						<!-- END: newday -->
					</h3>
					<div class="text-muted">
						<ul class="list-unstyled">
							<!-- BEGIN: author -->
							<li>{LANG.by}&nbsp;{CONTENT.author}</li>
							<!-- END: author -->
							<li class="pull-left">{CONTENT.publtime}</li>
							<!-- BEGIN: hitstotal -->
							<li class="spacer pull-left"></li>
							<li>{CONTENT.hitstotal}&nbsp;{LANG.hits_view}</li>
							<!-- END: hitstotal -->
						</ul>
					</div>
				</div>
			<!-- END: loop -->
			</div>
		</div>
	</div>
</div>
<!-- END: listcat -->
<!-- END: main -->