<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>

<div class="well">
	<form action="{NV_BASE_ADMINURL}index.php" method="get">
		<input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
		<input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />

		<div class="row">
			<div class="col-xs-12 col-md-6">
				<div class="form-group">
					<input class="form-control" type="text" value="{Q}" maxlength="64" name="q" placeholder="{LANG.search_key}" />
				</div>
			</div>
			<div class="col-xs-12 col-md-4">
				<div class="form-group">
					<select class="form-control" name="stype">
						<!-- BEGIN: search_type -->
						<option value="{SEARCH_TYPE.key}" {SEARCH_TYPE.selected} >{SEARCH_TYPE.value}</option>
						<!-- END: search_type -->
					</select>
				</div>
			</div>
			<div class="col-xs-12 col-md-6">
				<div class="form-group">
					<select class="form-control" name="catid" id="catid">
						<!-- BEGIN: cat_content -->
						<option value="{CAT_CONTENT.value}" {CAT_CONTENT.selected} >{CAT_CONTENT.title}</option>
						<!-- END: cat_content -->
					</select>
				</div>
			</div>
			<div class="col-xs-12 col-md-3">
				<div class="form-group">
					<select class="form-control" name="sstatus">
						<option value="-1"> -- {LANG.search_status} -- </option>
						<!-- BEGIN: search_status -->
						<option value="{SEARCH_STATUS.key}" {SEARCH_STATUS.selected} >{SEARCH_STATUS.value}</option>
						<!-- END: search_status -->
					</select>
				</div>
			</div>
			<div class="col-xs-12 col-md-2">
				<div class="form-group">
					<select class="form-control" name="per_page">
						<option value="">{LANG.search_per_page}</option>
						<!-- BEGIN: s_per_page -->
						<option value="{SEARCH_PER_PAGE.page}" {SEARCH_PER_PAGE.selected}>{SEARCH_PER_PAGE.page}</option>
						<!-- END: s_per_page -->
					</select>
				</div>
			</div>
			<div class="col-xs-12 col-md-3">
				<div class="form-group">
					<input class="btn btn-primary" type="submit" value="{LANG.search}" />
				</div>
			</div>
		</div>
		<input type="hidden" name="checkss" value="{CHECKSS}" />
		<label><em>{LANG.search_note}</em></label>
	</form>
</div>

<form class="navbar-form" name="block_list" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th class="text-center"><input name="check_all[]" type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);" /></th>
					<th class="text-center">Hình minh hoạ</a></th>
					<th class="text-center"><a href="{base_url_name}">{LANG.name}</a></th>
					<th>{LANG.status}</th>
					<th>{LANG.videos_infomations}</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<!-- BEGIN: loop -->
				<tr class="{ROW.class}">
					<td class="text-center"><input type="checkbox" onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);" value="{ROW.id}" name="idcheck[]" /></td>
					<td title="{ROW.title}">
						<a target="_blank" href="{ROW.link}">
							<img class="thumbnail center-block" width="100" src="{ROW.imghome}" alt="{ROW.title}" title="{ROW.title}"/>
						</a>
					</td>
					<td class="text-left">
						<p><a target="_blank" href="{ROW.link}"><strong>{ROW.title}</strong></a></p>
						<p><span class="other"><em>{ROW.publtime}</em></span></p>
						<div class="video-info">
							<strong>{LANG.content_admin}:</strong> <span class="other">{ROW.username}</span> |
							<strong>{LANG.hitstotal}:</strong> <span class="other">{ROW.hitstotal}</span>
						</div>
					</td>
					<td title="{ROW.status}" class="text-center">{ROW.status}</td>
                    <td class="text-center">
						<div class="video-info">
							<span class="text-center" style="cursor: pointer;" title="{LANG.numcomments}" data-toggle="tooltip" data-placement="top">
								<i class="fa fa-comment-o" title="{LANG.numcomments}"></i>
								{ROW.hitscm}</span> |
							<span class="text-center" style="cursor: pointer;" title="{LANG.keywords}" data-toggle="tooltip" data-placement="top">
								<i class="fa fa-tags" title="{LANG.keywords}"></i>
								{ROW.numtags}
							</span> |
							<span class="text-center" style="cursor: pointer;" title="{LANG.videos_count_Fav}" data-toggle="tooltip" data-placement="top">
								<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
								{ROW.count_Fav}
							</span>
						</div>
					</td>
					<td class="text-center">{ROW.feature}</td>
				</tr>
				<!-- END: loop -->
			</tbody>
			<tfoot>
				<tr class="text-left">
					<td colspan="12">
						<select class="form-control" name="action" id="action">
							<!-- BEGIN: action -->
							<option value="{ACTION.value}">{ACTION.title}</option>
							<!-- END: action -->
						</select>
						<input type="button" class="btn btn-primary" onclick="nv_main_action(this.form, '{SITEKEY}', '{LANG.msgnocheck}')" value="{LANG.action}" />
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</form>
<!-- BEGIN: generate_page -->
<div class="text-center">
	{GENERATE_PAGE}
</div>
<!-- END: generate_page -->
<script type="text/javascript">
	$(document).ready(function() {
		$("#catid").select2();
	});
</script>
<!-- END: main -->