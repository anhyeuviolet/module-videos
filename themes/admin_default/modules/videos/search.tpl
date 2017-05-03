<!-- BEGIN: main -->
<!-- BEGIN: form -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
<div class="well">
	<input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
	<input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />
	<div class="row">
	<div class="col-xs-12 col-md-6">
		<input id="query_key" name="query_key" type="text" class="form-control" maxlength="64" placeholder="{LANG.search_key}" />
	</div>
	<div class="col-xs-12 col-md-6">
		<div class="form-group">
			<input type="number" id="maxResults" name="maxResults" class="form-control" min="1" max="50" step="1" placeholder="10">
		</div>
	</div>
	<button id="button_get_videos" onclick="nv_get_from_youtube();" class="btn btn-primary">{LANG.search}</button>
	
	</div>
</div>
<div id="get_from_youtube"></div>
<!-- END: form -->

<!-- BEGIN: error -->
<div class="alert alert-danger">
	<strong>{ERROR}</strong>
</div>
<!-- END: error -->

<!-- END: main -->

