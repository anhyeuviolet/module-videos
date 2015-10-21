<!-- BEGIN: playlistcat_lists -->
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<colgroup>
			<col class="w100">
			<col class="w50">
			<col class="w250">
			<col class="w90">
			<col class="w90">
		</colgroup>
		<thead>
			<tr>
				<th>{LANG.weight}</th>
				<th>{LANG.name}</th>
				<th class="text-center">{LANG.video_in_list} Video trong list</th>
				<th class="text-center">{LANG.playlist_public}</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: loop -->
			<tr>
				<td class="text-center">{ROW.weight}</td>
				<td class="text-center"><a href="{ROW.link}">{ROW.title}</a> </td>
				<td class="text-center"><a href="{ROW.linksite}">{ROW.numnews} Video</a></td>
				<td class="text-center">
					<select class="form-control" id="id_private_mode_{ROW.playlist_id}" onchange="nv_change_playlist_cat('{ROW.playlist_id}','private_mode');">
						<!-- BEGIN: private_mode -->
						<option value="{PRIVATE_MODE.key}"{PRIVATE_MODE.selected}>{PRIVATE_MODE.title}</option>
						<!-- END: private_mode -->
					</select>
				</td>
				<td class="text-center">
					<em class="fa fa-edit fa-lg">&nbsp;</em> <a href="{ROW.url_edit}">{GLANG.edit}</a> &nbsp;
					<em class="fa fa-trash-o fa-lg">&nbsp;</em> <a href="{ROW.url_delete}" id="del_playlist" >{GLANG.delete}</a>
				</td>
			</tr>
			<!-- END: loop -->
		</tbody>
	</table>
</div>
<!-- END: playlistcat_lists -->