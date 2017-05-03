<!-- BEGIN: main -->

<!-- BEGIN: error -->
<div class="alert alert-warning">
	<strong>{ERROR}</strong>
</div>
<!-- END: error -->

<!-- BEGIN: data -->
<div class="alert alert-info">
<strong>Tổng số kết quả:</strong> {NUMRESULTS} Video
</div>
<form class="navbar-form" name="block_list" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover get-video-result">
			<thead>
				<tr>
					<th class="text-center"><input name="check_all[]" type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);" /></th>
					<th class="text-center">Hình minh hoạ</a></th>
					<th class="text-center">{LANG.name}</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody class="items">
				<!-- BEGIN: loop -->
				<tr class="youtube-result item">
					<td class="text-center"><input type="checkbox" onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);" value="{ROW.id}" name="idcheck[]" /></td>
					<td title="{ROW.title}">
						<a target="_blank" href="{ROW.link}">
							<img class="thumbnail center-block" width="100" src="{ROW.imghome}" alt="{ROW.title}" title="{ROW.title}"/>
						</a>
					</td>
					<td class="text-left">
						<p><a target="_blank" href="{ROW.link}"><strong>{ROW.title}</strong></a></p>
						<p><span class="other"><em><strong>{LANG.content_publ_date}: </strong>{ROW.publishedAt}</em></span> | <span class="other"><em><strong>{LANG.videos_duration}: </strong>{ROW.duration}</em></span></p>
						<p><span class="other"><em>{ROW.description}</em></span></p>
					</td>
					<td class="text-center">{ROW.feature}</td>
				</tr>
				<!-- END: loop -->
			</tbody>
		</table>
	</div>
</form>
<!-- END: data -->

<!-- END: main -->

	<!--  BEGIN: loading -->
	<div class="well" style="max-height: 500px; overflow-y: scroll;">
		<i class="fa fa-spinner fa-pulse fa-3x fa-fw center-block"></i>
	</div>	
	<!--  END: loading -->
