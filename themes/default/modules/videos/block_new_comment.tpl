<!-- BEGIN: main -->
<!-- BEGIN: css -->
<style>
.videos-comment article > a, .videos-comment article > span {
    margin-bottom: 5px;
    display: inline-block;
}
.videos-comment article {
    margin-top: 10px;
    border-bottom: 1px dotted #ccc;
}
.ellipsis {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.videos-comment article p.link {
    font-size: 11px;
    margin: 5px 0 5px 0;
    width: 100%;
}
</style>
<!-- END: css -->
<div class="videos-comment">
	<!-- BEGIN: loop -->
	<article>
			<!-- BEGIN: avatar -->
			<img src="{COMMENT.avatar}" width="" alt="{COMMENT.post_name}" class="img-thumbnail pull-left"/>
			<!-- END: avatar -->
			<span><strong>{COMMENT.post_name}</strong></span>
			<!-- BEGIN: emailcomm -->
			<a class="cm_item" title="mailto {COMMENT.post_email}" href="mailto:{COMMENT.post_email}">{COMMENT.post_email}</a>
			<!-- END: emailcomm -->
		<div class="text-justify">{COMMENT.content}</div>
		<p class="link ellipsis">
			{COMMENT.post_time} - <a href="{COMMENT.url_comment}#idcomment" title="{COMMENT.post_title}">{COMMENT.post_title}</a>
		</p>
	</article>
	<!-- END: loop -->
</div>
<div class="text-center">
	{PAGE}
</div>
<!-- END: main -->