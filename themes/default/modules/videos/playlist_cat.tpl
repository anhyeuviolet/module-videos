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
			<tr <!-- BEGIN: pl_moderate -->class="warning"<!-- END: pl_moderate -->>
				<td class="text-center">{ROW.weight}</td>
				<td class="text-center">
				<a href="{ROW.link}">{ROW.title}</a>
				</td>
				<td class="text-center"><a href="{ROW.linksite}" title="{ROW.title}" target="_blank">{ROW.numnews}&nbsp;{LANG.playlist_num_news}&nbsp;<i class="fa fa-external-link"></i></a></td>
				<td class="text-center">
					<select class="form-control" id="id_private_mode_{ROW.playlist_id}" onchange="nv_change_playlist_cat('{ROW.playlist_id}','private_mode', '{ROW.check_session}');">
						<!-- BEGIN: private_mode -->
						<option value="{PRIVATE_MODE.key}"{PRIVATE_MODE.selected}>{PRIVATE_MODE.title}</option>
						<!-- END: private_mode -->
					</select>
				</td>
				<td class="text-center">
					<!-- BEGIN: edit_btn -->
					<em class="fa fa-edit fa-lg">&nbsp;</em><a href="{ROW.url_edit}">{GLANG.edit}</a> &nbsp;
					<!-- END: edit_btn -->
					<!-- BEGIN: delete -->
					<em class="fa fa-trash-o fa-lg">&nbsp;</em><a href="javascript:void(0);" onclick="nv_del_playlist_cat('{ROW.playlist_id}', '{ROW.check_session}')">{GLANG.delete}</a>
					<!-- END: delete -->
				</td>
			</tr>
			<!-- END: loop -->
		</tbody>
	</table>
</div>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<!-- END: playlistcat_lists -->

<!-- BEGIN: get_user_playlist -->
<div class="add-playlist-region">
	<h4>
	<span class="close fn-closetab" data-toggle="collapse" data-target="#add_to_userlist"></span>
	<span>{LANG.playlist_select}</span>
	<em title="Làm mới danh sách Playlist" id="renew_user_playlist" class="fa fa-refresh fa-lg fa-pointer" style="cursor: pointer; vertical-align: middle; margin: 0px 0 0 5px" onclick="nv_show_user_playlist('user_playlist');">&nbsp;</em>
	</h4>
	<ul class="playlist-region fn-list changeme" id="list_playlist">
		<!-- BEGIN: loop -->
		<li>
			<p>
				{USER_PLAYLIST.title}
			</p>
			<span>{USER_PLAYLIST.numnews}{LANG.video}</span>
			<a class="btn btn-primary fix-button fn-add" onclick="nv_add_user_playlist('{USER_PLAYLIST.id}','{USER_PLAYLIST.playlist_id}','add_user_playlist');">
			<span>{LANG.save}</span>
			</a>
		</li>
		<!-- END: loop -->
		<li class="add-new-playlist"><a href="{NV_BASE_SITEURL}{MODULE_NAME}/{USERLIST_OPS}/" target="_blank">{LANG.user_create_newlist}&nbsp;<i class="fa fa-external-link-square">&nbsp;</i></a></li>
	</ul>
</div>
<!-- END: get_user_playlist -->
