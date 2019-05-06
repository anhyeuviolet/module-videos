<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>

<form class="form-inline" role="form" action="{NV_BASE_ADMINURL}index.php" method="post">
	<input type="hidden" name ="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
	<input type="hidden" name ="{NV_OP_VARIABLE}" value="{OP}" />
	
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<caption><em class="fa fa-file-text-o">&nbsp;</em>{LANG.setting_player}</caption>
			<tbody>
				<tr>
					<th id="jwplayer_license">{LANG.setting_jwplayer_license}</th>
					<td><input class="form-control" style="width:50%;" name="jwplayer_license" value="{DATA.jwplayer_license}" type="text"/><span class="text-middle"><br/>{LANG.wiki_get_free_jwlicense}</span></td>
				</tr>			
				<tr>
					<th id="jwplayer_license">{LANG.preview_jwp_lic}</th>
					<td><pre>NqPyv5C3s2LTybLMlqx3nfOJTvmRqu9cuQPTrQ==</pre></td>
				</tr>			
				<tr>
					<th>{LANG.setting_jwplayer_autoplay}</th>
					<td>
						<select class="form-control" name="jwplayer_autoplay">
							<!-- BEGIN: jwplayer_autoplay -->
							<option value="{AUTO_PLAY.key}"{AUTO_PLAY.selected}>{AUTO_PLAY.title}</option>
							<!-- END: jwplayer_autoplay -->
						</select>
					</td>
				</tr>
				<tr>
					<th>{LANG.setting_jwplayer_loop}</th>
					<td>						
						<select class="form-control" name="jwplayer_loop">
							<!-- BEGIN: jwplayer_loop -->
							<option value="{LOOP_PLAY.key}"{LOOP_PLAY.selected}>{LOOP_PLAY.title}</option>
							<!-- END: jwplayer_loop -->
						</select>
					</td>
				</tr>
				<tr>
					<th>{LANG.setting_jwplayer_controlbar}</th>
					<td>
						<select class="form-control" name="jwplayer_controlbar">
							<!-- BEGIN: jwplayer_controlbar -->
							<option value="{CONTROL_BAR.key}"{CONTROL_BAR.selected}>{CONTROL_BAR.title}</option>
							<!-- END: jwplayer_controlbar -->
						</select>
					</td>
				</tr>
				<tr>
					<th>{LANG.setting_jwplayer_mute}</th>
					<td>
						<select class="form-control" name="jwplayer_mute">
							<!-- BEGIN: jwplayer_mute -->
							<option value="{JW_MUTE.key}"{JW_MUTE.selected}>{JW_MUTE.title}</option>
							<!-- END: jwplayer_mute -->
						</select>
					</td>
				</tr>
				<tr>
					<th>{LANG.setting_jwplayer_skin}</th>
					<td>
						<select class="form-control" name="jwplayer_skin">
							<!-- BEGIN: jwplayer_skin -->
							<option value="{SKIN.key}"{SKIN.selected}>{SKIN.title}</option>
							<!-- END: jwplayer_skin -->
						</select>
					</td>
				</tr>
				<tr>
					<th>{LANG.setting_jwplayer_sharing}</th>
					<td>
						<select class="form-control" name="jwplayer_sharing" class="jwplayer_sharing" id="jwplayer_sharing">
							<!-- BEGIN: jwplayer_sharing -->
							<option value="{JW_SHARE.key}"{JW_SHARE.selected}>{JW_SHARE.title}</option>
							<!-- END: jwplayer_sharing -->
						</select>
					</td>
				</tr>
				<tr class="sharing-jw">
					<th>{LANG.setting_jwplayer_sharingsite}</th>
					<td>
						<ul style="padding: 0px;">
							<!-- BEGIN: jwplayer_sharingsite -->
							<li style="display: inline-block;"><input type="checkbox" value="{JW_SSITES.key}" name="jwplayer_sharingsite[]" {JW_SSITES.checked}/>{JW_SSITES.title}</li>
							<!-- END: jwplayer_sharingsite -->
						</ul>
					</td>
				</tr>
				<tr>
					<th>{LANG.setting_jwplayer_logo}</th>
					<td>
						<select class="form-control" name="jwplayer_logo" class="jwplayer_logo" id="jwplayer_logo">
							<!-- BEGIN: jwplayer_logo -->
							<option value="{JW_LOGO.key}"{JW_LOGO.selected}>{JW_LOGO.title}</option>
							<!-- END: jwplayer_logo -->
						</select>
					</td>
				</tr>
				<tr class="logo-jw">
					<th>{LANG.setting_jwplayer_logo_position}</th>
					<td>
						<select class="form-control" name="jwplayer_position">
							<!-- BEGIN: jwplayer_position -->
							<option value="{JW_POS.value}"{JW_POS.selected}>{JW_POS.title}</option>
							<!-- END: jwplayer_position -->
						</select>
					</td>
				</tr>
				<tr class="logo-jw">
					<th>{LANG.setting_jwplayer_logo_file}</th>
					<td>
						<input class="form-control" name="jwplayer_logo_file" id="jwplayer_logo_file" value="{JWPLAYER_LOGO_FILE}" style="width:50%;" type="text"/>
						<input id="select-jw-logo-setting" value="{GLANG.browse_image}" name="selectimg" type="button" class="btn btn-info"/>
					</td>
				</tr>

			</tbody>
			<tfoot>
				<tr>
					<td class="text-center" colspan="2">
						<input class="btn btn-primary" type="submit" value="{LANG.save}" name="Submit1" />
						<input type="hidden" value="1" name="savesetting" />
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
	
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<caption><em class="fa fa-file-text-o">&nbsp;</em>{LANG.setting_playlist}</caption>
			<tbody>
				<tr>
					<th>{LANG.setting_allow_user_plist}</th>
					<td><input type="checkbox" value="1" name="allow_user_plist"{ALLOW_USER_PLIST}/></td>
				</tr>
				<tr>
					<th>{LANG.setting_playlist_moderate}</th>
					<td><input type="checkbox" value="1" name="playlist_moderate"{PLAYLIST_MODERATE}/></td>
				</tr>
				<tr>
					<th>{LANG.setting_playlist_allow_detele}</th>
					<td><input type="checkbox" value="1" name="playlist_allow_detele"{PLAYLIST_ALLOW_DETELE}/></td>
				</tr>
				<tr>
					<th>{LANG.setting_playlist_max_items}</th>
					<td>
						<select name="playlist_max_items" class="form-control">
							<!-- BEGIN: playlist_max_items -->
							<option value="{MAX_PLISTS.key}"{MAX_PLISTS.selected}>{MAX_PLISTS.title}</option>
							<!-- END: playlist_max_items -->
						</select>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td class="text-center" colspan="2">
						<input class="btn btn-primary" type="submit" value="{LANG.save}" name="Submit1" />
						<input type="hidden" value="1" name="savesetting" />
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
	
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<caption><em class="fa fa-file-text-o">&nbsp;</em>{LANG.setting_view}</caption>
			<tbody>
				<tr>
					<th>{LANG.setting_indexfile}</th>
					<td>
						<select class="form-control" name="indexfile">
							<!-- BEGIN: indexfile -->
							<option value="{INDEXFILE.key}"{INDEXFILE.selected}>{INDEXFILE.title}</option>
							<!-- END: indexfile -->
						</select>
					</td>
				</tr>
				<tr>
					<th>{LANG.setting_homesite}</th>
					<td><input class= "form-control" type="text" value="{DATA.homewidth}" name="homewidth" /><span class="text-middle"> x </span><input class= "form-control" type="text" value="{DATA.homeheight}" name="homeheight" /></td>
				</tr>
				<tr>
					<th>{LANG.setting_thumbblock}</th>
					<td><input class= "form-control" type="text" value="{DATA.blockwidth}" name="blockwidth" /><span class="text-middle"> x </span><input class= "form-control" type="text" value="{DATA.blockheight}" name="blockheight" /></td>
				</tr>
				<tr>
					<th>{LANG.setting_titlecut}</th>
					<td><input class= "form-control" type="text" value="{DATA.titlecut}" name="titlecut" /></td>
				</tr>
				<tr>
					<th>{LANG.setting_per_page}</th>
					<td>
					<select class="form-control" name="per_page">
						<!-- BEGIN: per_page -->
						<option value="{PER_PAGE.key}"{PER_PAGE.selected}>{PER_PAGE.title}</option>
						<!-- END: per_page -->
					</select></td>
				</tr>
				<tr>
					<th>{LANG.setting_st_links}</th>
					<td>
					<select class="form-control" name="st_links">
						<!-- BEGIN: st_links -->
						<option value="{ST_LINKS.key}"{ST_LINKS.selected}>{ST_LINKS.title}</option>
						<!-- END: st_links -->
					</select></td>
				</tr>
				<tr>
					<th>{LANG.setting_per_line}</th>
					<td>
					<select class="form-control" name="per_line">
						<!-- BEGIN: per_line -->
						<option value="{PER_LINE.key}"{PER_LINE.selected}>{PER_LINE.title}</option>
						<!-- END: per_line -->
					</select></td>
				</tr>
				<tr>
					<th>{LANG.socialbutton}</th>
					<td><input type="checkbox" value="1" name="socialbutton"{SOCIALBUTTON}/></td>
				</tr>
				<tr>
					<th>{LANG.allowed_rating_point}</th>
					<td>
						<select class="form-control" name="allowed_rating_point">
							<!-- BEGIN: allowed_rating_point -->
							<option value="{RATING_POINT.key}"{RATING_POINT.selected}>{RATING_POINT.title}</option>
							<!-- END: allowed_rating_point -->
						</select>
					</td>
				</tr>
				<tr>
					<th>{LANG.show_no_image}</th>
					<td><input class="form-control" name="show_no_image" id="show_no_image" value="{SHOW_NO_IMAGE}" style="width:340px;" type="text"/> <input id="select-img-setting" value="{GLANG.browse_image}" name="selectimg" type="button" class="btn btn-info"/></td>
				</tr>
				<tr>
					<th>{LANG.config_source}</th>
					<td>
					<select class="form-control" name="config_source">
						<!-- BEGIN: config_source -->
						<option value="{CONFIG_SOURCE.key}"{CONFIG_SOURCE.selected}>{CONFIG_SOURCE.title}</option>
						<!-- END: config_source -->
					</select></td>
				</tr>
				<tr>
					<th>{LANG.setting_copyright}</th>
					<td>{COPYRIGHTHTML}</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td class="text-center" colspan="2">
						<input class="btn btn-primary" type="submit" value="{LANG.save}" name="Submit1" />
						<input type="hidden" value="1" name="savesetting" />
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
	
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<caption><em class="fa fa-file-text-o">&nbsp;</em>{LANG.setting_post}</caption>
			<tbody>
				<tr>
					<th>{LANG.facebookAppID}</th>
					<td><input class="form-control w150" name="facebookappid" value="{DATA.facebookappid}" type="text"/><span class="text-middle">{LANG.facebookAppIDNote}</span></td>
				</tr>
				<tr>
					<th>{LANG.facebookAdminID}&nbsp;<i style="cursor: pointer;" class="fa fa-question-circle" aria-hidden="true" title="{LANG.facebookAdminID_tips}" data-toggle="tooltip" data-placement="bottom"></i></th>
					<td><input class="form-control w150" name="fb_admin" value="{DATA.fb_admin}" type="text"/><span class="text-middle">{LANG.facebookAdminIDNote}</span></td>
				</tr>
				<tr>
					<th>{LANG.facebookComment}</th>
					<td><input type="checkbox" value="1" name="fb_comm"{FB_COMM}/></td>
				</tr>
				<!-- BEGIN: youtube_api -->
				<tr>
					<th>{LANG.setting_youtube_api}</th>
					<td><input class="form-control" style="width:340px;" name="youtube_api" value="{DATA.youtube_api}" type="text"/><span class="text-middle"><br/>{LANG.wiki_get_free_youtube_api}</span></td>
				</tr>
				<!-- END: youtube_api -->
				<tr>
					<th>{LANG.setting_alias_lower}</th>
					<td><input type="checkbox" value="1" name="alias_lower"{ALIAS_LOWER}/></td>
				</tr>
				<tr>
					<th>{LANG.tags_alias}</th>
					<td><input type="checkbox" value="1" name="tags_alias"{TAGS_ALIAS}/></td>
				</tr>
				<tr>
					<th>{LANG.structure_image_upload}</th>
					<td>
					<select class="form-control" name="structure_upload" id="structure_upload">
						<!-- BEGIN: structure_upload -->
						<option value="{STRUCTURE_UPLOAD.key}"{STRUCTURE_UPLOAD.selected}>{STRUCTURE_UPLOAD.title}</option>
						<!-- END: structure_upload -->
					</select></td>
				</tr>
				<tr>
					<th>{LANG.setting_auto_tags}</th>
					<td><input type="checkbox" value="1" name="auto_tags"{AUTO_TAGS}/></td>
				</tr>
				<tr>
					<th>{LANG.setting_tags_remind}</th>
					<td><input type="checkbox" value="1" name="tags_remind"{TAGS_REMIND}/></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td class="text-center" colspan="2">
						<input class="btn btn-primary" type="submit" value="{LANG.save}" name="Submit1" />
						<input type="hidden" value="1" name="savesetting" />
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</form>
<!-- BEGIN: admin_config_post -->
<form action="{FORM_ACTION}" method="post">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<caption><em class="fa fa-file-text-o">&nbsp;</em>{LANG.group_content}</caption>
			<thead>
				<tr class="text-center">
					<th>{GLANG.mod_groups}</th>
					<th>{LANG.group_addcontent}</th>
					<th>{LANG.group_postcontent}</th>
					<th>{LANG.group_editcontent}</th>
					<th>{LANG.group_delcontent}</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td style="text-align: center;" colspan="5"><input class="btn btn-primary" type="submit" value="{LANG.save}" name="Submit1" /><input type="hidden" value="1" name="savepost" /></td>
				</tr>
			</tfoot>
			<tbody>
				<!-- BEGIN: loop -->
				<tr>
					<td><strong>{ROW.group_title}</strong><input type="hidden" value="{ROW.group_id}" name="array_group_id[]" /></td>
					<td class="text-center"><input type="checkbox" value="1" name="array_addcontent[{ROW.group_id}]"{ROW.addcontent}/></td>
					<td class="text-center"><input type="checkbox" value="1" name="array_postcontent[{ROW.group_id}]"{ROW.postcontent}/></td>
					<td class="text-center"><input type="checkbox" value="1" name="array_editcontent[{ROW.group_id}]"{ROW.editcontent}/></td>
					<td class="text-center"><input type="checkbox" value="1" name="array_delcontent[{ROW.group_id}]"{ROW.delcontent}/></td>
				</tr>
				<!-- END: loop -->
			</tbody>
		</table>
	</div>
</form>
<!-- END: admin_config_post -->
<script type="text/javascript">
//<![CDATA[
var CFG = [];
CFG.path = '{PATH}';
CFG.currentpath = '{CURRENTPATH}';
$(document).ready(function() {
	$("#structure_upload").select2();
});
//]]>
$(document).ready(function(){
    $("select#jwplayer_logo").change(function(){
        $(this).find("option:selected").each(function(){
            if($(this).attr("value")=="1"){
                $(".logo-jw").show();
            }
            else {
                $(".logo-jw").hide();
            }
        });
    }).change();
	
    $("select#jwplayer_sharing").change(function(){
        $(this).find("option:selected").each(function(){
            if($(this).attr("value")=="1"){
                $(".sharing-jw").show();
            }
            else {
                $(".sharing-jw").hide();
            }
        });
    }).change();
});
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
<!-- END: main -->