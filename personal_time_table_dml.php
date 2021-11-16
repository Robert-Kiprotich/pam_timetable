<?php

// Data functions (insert, update, delete, form) for table personal_time_table



function personal_time_table_insert(){
	global $Translation;

	// mm: can member insert record?
	$arrPerm=getTablePermissions('personal_time_table');
	if(!$arrPerm[1]){
		return false;
	}

	$data['day'] = makeSafe($_REQUEST['day']);
		if($data['day'] == empty_lookup_value){ $data['day'] = ''; }
	$data['time_start'] = makeSafe($_REQUEST['time_start']);
		if($data['time_start'] == empty_lookup_value){ $data['time_start'] = ''; }
	$data['time_start'] = time24($data['time_start']);
	$data['time_end'] = makeSafe($_REQUEST['time_end']);
		if($data['time_end'] == empty_lookup_value){ $data['time_end'] = ''; }
	$data['time_end'] = time24($data['time_end']);
	$data['activity'] = makeSafe($_REQUEST['activity']);
		if($data['activity'] == empty_lookup_value){ $data['activity'] = ''; }
	if($data['day']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Day': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	if($data['time_start']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Time Start': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	if($data['time_end']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Time End': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	if($data['activity']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Activity': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}

	// hook: personal_time_table_before_insert
	if(function_exists('personal_time_table_before_insert')){
		$args=array();
		if(!personal_time_table_before_insert($data, getMemberInfo(), $args)){ return false; }
	}

	$o = array('silentErrors' => true);
	sql('insert into `personal_time_table` set       `day`=' . (($data['day'] !== '' && $data['day'] !== NULL) ? "'{$data['day']}'" : 'NULL') . ', `time_start`=' . (($data['time_start'] !== '' && $data['time_start'] !== NULL) ? "'{$data['time_start']}'" : 'NULL') . ', `time_end`=' . (($data['time_end'] !== '' && $data['time_end'] !== NULL) ? "'{$data['time_end']}'" : 'NULL') . ', `activity`=' . (($data['activity'] !== '' && $data['activity'] !== NULL) ? "'{$data['activity']}'" : 'NULL'), $o);
	if($o['error']!=''){
		echo $o['error'];
		echo "<a href=\"personal_time_table_view.php?addNew_x=1\">{$Translation['< back']}</a>";
		exit;
	}

	$recID = db_insert_id(db_link());

	// hook: personal_time_table_after_insert
	if(function_exists('personal_time_table_after_insert')){
		$res = sql("select * from `personal_time_table` where `id`='" . makeSafe($recID, false) . "' limit 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = makeSafe($recID, false);
		$args=array();
		if(!personal_time_table_after_insert($data, getMemberInfo(), $args)){ return $recID; }
	}

	// mm: save ownership data
	set_record_owner('personal_time_table', $recID, getLoggedMemberID());

	return $recID;
}

function personal_time_table_delete($selected_id, $AllowDeleteOfParents=false, $skipChecks=false){
	// insure referential integrity ...
	global $Translation;
	$selected_id=makeSafe($selected_id);

	// mm: can member delete record?
	$arrPerm=getTablePermissions('personal_time_table');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='personal_time_table' and pkValue='$selected_id'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='personal_time_table' and pkValue='$selected_id'");
	if(($arrPerm[4]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[4]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[4]==3){ // allow delete?
		// delete allowed, so continue ...
	}else{
		return $Translation['You don\'t have enough permissions to delete this record'];
	}

	// hook: personal_time_table_before_delete
	if(function_exists('personal_time_table_before_delete')){
		$args=array();
		if(!personal_time_table_before_delete($selected_id, $skipChecks, getMemberInfo(), $args))
			return $Translation['Couldn\'t delete this record'];
	}

	sql("delete from `personal_time_table` where `id`='$selected_id'", $eo);

	// hook: personal_time_table_after_delete
	if(function_exists('personal_time_table_after_delete')){
		$args=array();
		personal_time_table_after_delete($selected_id, getMemberInfo(), $args);
	}

	// mm: delete ownership data
	sql("delete from membership_userrecords where tableName='personal_time_table' and pkValue='$selected_id'", $eo);
}

function personal_time_table_update($selected_id){
	global $Translation;

	// mm: can member edit record?
	$arrPerm=getTablePermissions('personal_time_table');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='personal_time_table' and pkValue='".makeSafe($selected_id)."'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='personal_time_table' and pkValue='".makeSafe($selected_id)."'");
	if(($arrPerm[3]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[3]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[3]==3){ // allow update?
		// update allowed, so continue ...
	}else{
		return false;
	}

	$data['day'] = makeSafe($_REQUEST['day']);
		if($data['day'] == empty_lookup_value){ $data['day'] = ''; }
	if($data['day']==''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">{$Translation['error:']} 'Day': {$Translation['field not null']}<br><br>";
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	$data['time_start'] = makeSafe($_REQUEST['time_start']);
		if($data['time_start'] == empty_lookup_value){ $data['time_start'] = ''; }
	$data['time_start'] = time24($data['time_start']);
	if($data['time_start']==''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">{$Translation['error:']} 'Time Start': {$Translation['field not null']}<br><br>";
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	$data['time_end'] = makeSafe($_REQUEST['time_end']);
		if($data['time_end'] == empty_lookup_value){ $data['time_end'] = ''; }
	$data['time_end'] = time24($data['time_end']);
	if($data['time_end']==''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">{$Translation['error:']} 'Time End': {$Translation['field not null']}<br><br>";
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	$data['activity'] = makeSafe($_REQUEST['activity']);
		if($data['activity'] == empty_lookup_value){ $data['activity'] = ''; }
	if($data['activity']==''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">{$Translation['error:']} 'Activity': {$Translation['field not null']}<br><br>";
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	$data['selectedID']=makeSafe($selected_id);

	// hook: personal_time_table_before_update
	if(function_exists('personal_time_table_before_update')){
		$args=array();
		if(!personal_time_table_before_update($data, getMemberInfo(), $args)){ return false; }
	}

	$o=array('silentErrors' => true);
	sql('update `personal_time_table` set       `day`=' . (($data['day'] !== '' && $data['day'] !== NULL) ? "'{$data['day']}'" : 'NULL') . ', `time_start`=' . (($data['time_start'] !== '' && $data['time_start'] !== NULL) ? "'{$data['time_start']}'" : 'NULL') . ', `time_end`=' . (($data['time_end'] !== '' && $data['time_end'] !== NULL) ? "'{$data['time_end']}'" : 'NULL') . ', `activity`=' . (($data['activity'] !== '' && $data['activity'] !== NULL) ? "'{$data['activity']}'" : 'NULL') . " where `id`='".makeSafe($selected_id)."'", $o);
	if($o['error']!=''){
		echo $o['error'];
		echo '<a href="personal_time_table_view.php?SelectedID='.urlencode($selected_id)."\">{$Translation['< back']}</a>";
		exit;
	}


	// hook: personal_time_table_after_update
	if(function_exists('personal_time_table_after_update')){
		$res = sql("SELECT * FROM `personal_time_table` WHERE `id`='{$data['selectedID']}' LIMIT 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = $data['id'];
		$args = array();
		if(!personal_time_table_after_update($data, getMemberInfo(), $args)){ return; }
	}

	// mm: update ownership data
	sql("update membership_userrecords set dateUpdated='".time()."' where tableName='personal_time_table' and pkValue='".makeSafe($selected_id)."'", $eo);

}

function personal_time_table_form($selected_id = '', $AllowUpdate = 1, $AllowInsert = 1, $AllowDelete = 1, $ShowCancel = 0, $TemplateDV = '', $TemplateDVP = ''){
	// function to return an editable form for a table records
	// and fill it with data of record whose ID is $selected_id. If $selected_id
	// is empty, an empty form is shown, with only an 'Add New'
	// button displayed.

	global $Translation;

	// mm: get table permissions
	$arrPerm=getTablePermissions('personal_time_table');
	if(!$arrPerm[1] && $selected_id==''){ return ''; }
	$AllowInsert = ($arrPerm[1] ? true : false);
	// print preview?
	$dvprint = false;
	if($selected_id && $_REQUEST['dvprint_x'] != ''){
		$dvprint = true;
	}


	// populate filterers, starting from children to grand-parents

	// unique random identifier
	$rnd1 = ($dvprint ? rand(1000000, 9999999) : '');
	// combobox: day
	$combo_day = new Combo;
	$combo_day->ListType = 0;
	$combo_day->MultipleSeparator = ', ';
	$combo_day->ListBoxHeight = 10;
	$combo_day->RadiosPerLine = 1;
	if(is_file(dirname(__FILE__).'/hooks/personal_time_table.day.csv')){
		$day_data = addslashes(implode('', @file(dirname(__FILE__).'/hooks/personal_time_table.day.csv')));
		$combo_day->ListItem = explode('||', entitiesToUTF8(convertLegacyOptions($day_data)));
		$combo_day->ListData = $combo_day->ListItem;
	}else{
		$combo_day->ListItem = explode('||', entitiesToUTF8(convertLegacyOptions("Monday;;Tuesday;;Wednesday;;Thursday;;Friday;;Saturday;;Sunday")));
		$combo_day->ListData = $combo_day->ListItem;
	}
	$combo_day->SelectName = 'day';
	$combo_day->AllowNull = false;

	if($selected_id){
		// mm: check member permissions
		if(!$arrPerm[2]){
			return "";
		}
		// mm: who is the owner?
		$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='personal_time_table' and pkValue='".makeSafe($selected_id)."'");
		$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='personal_time_table' and pkValue='".makeSafe($selected_id)."'");
		if($arrPerm[2]==1 && getLoggedMemberID()!=$ownerMemberID){
			return "";
		}
		if($arrPerm[2]==2 && getLoggedGroupID()!=$ownerGroupID){
			return "";
		}

		// can edit?
		if(($arrPerm[3]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[3]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[3]==3){
			$AllowUpdate=1;
		}else{
			$AllowUpdate=0;
		}

		$res = sql("select * from `personal_time_table` where `id`='".makeSafe($selected_id)."'", $eo);
		if(!($row = db_fetch_array($res))){
			return error_message($Translation['No records found'], 'personal_time_table_view.php', false);
		}
		$urow = $row; /* unsanitized data */
		$hc = new CI_Input();
		$row = $hc->xss_clean($row); /* sanitize data */
		$combo_day->SelectedData = $row['day'];
	}else{
		$combo_day->SelectedText = ( $_REQUEST['FilterField'][1]=='2' && $_REQUEST['FilterOperator'][1]=='<=>' ? (get_magic_quotes_gpc() ? stripslashes($_REQUEST['FilterValue'][1]) : $_REQUEST['FilterValue'][1]) : "");
	}
	$combo_day->Render();

	ob_start();
	?>

	<script>
		// initial lookup values

		jQuery(function() {
			setTimeout(function(){
			}, 10); /* we need to slightly delay client-side execution of the above code to allow AppGini.ajaxCache to work */
		});
	</script>
	<?php

	$lookups = str_replace('__RAND__', $rnd1, ob_get_contents());
	ob_end_clean();


	// code for template based detail view forms

	// open the detail view template
	if($dvprint){
		$template_file = is_file("./{$TemplateDVP}") ? "./{$TemplateDVP}" : './templates/personal_time_table_templateDVP.html';
		$templateCode = @file_get_contents($template_file);
	}else{
		$template_file = is_file("./{$TemplateDV}") ? "./{$TemplateDV}" : './templates/personal_time_table_templateDV.html';
		$templateCode = @file_get_contents($template_file);
	}

	// process form title
	$templateCode = str_replace('<%%DETAIL_VIEW_TITLE%%>', 'Personal time table details', $templateCode);
	$templateCode = str_replace('<%%RND1%%>', $rnd1, $templateCode);
	$templateCode = str_replace('<%%EMBEDDED%%>', ($_REQUEST['Embedded'] ? 'Embedded=1' : ''), $templateCode);
	// process buttons
	if($AllowInsert){
		if(!$selected_id) $templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-success" id="insert" name="insert_x" value="1" onclick="return personal_time_table_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save New'] . '</button>', $templateCode);
		$templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="insert" name="insert_x" value="1" onclick="return personal_time_table_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save As Copy'] . '</button>', $templateCode);
	}else{
		$templateCode = str_replace('<%%INSERT_BUTTON%%>', '', $templateCode);
	}

	// 'Back' button action
	if($_REQUEST['Embedded']){
		$backAction = 'AppGini.closeParentModal(); return false;';
	}else{
		$backAction = '$j(\'form\').eq(0).attr(\'novalidate\', \'novalidate\'); document.myform.reset(); return true;';
	}

	if($selected_id){
		if(!$_REQUEST['Embedded']) $templateCode = str_replace('<%%DVPRINT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="dvprint" name="dvprint_x" value="1" onclick="$$(\'form\')[0].writeAttribute(\'novalidate\', \'novalidate\'); document.myform.reset(); return true;" title="' . html_attr($Translation['Print Preview']) . '"><i class="glyphicon glyphicon-print"></i> ' . $Translation['Print Preview'] . '</button>', $templateCode);
		if($AllowUpdate){
			$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '<button type="submit" class="btn btn-success btn-lg" id="update" name="update_x" value="1" onclick="return personal_time_table_validateData();" title="' . html_attr($Translation['Save Changes']) . '"><i class="glyphicon glyphicon-ok"></i> ' . $Translation['Save Changes'] . '</button>', $templateCode);
		}else{
			$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '', $templateCode);
		}
		if(($arrPerm[4]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[4]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[4]==3){ // allow delete?
			$templateCode = str_replace('<%%DELETE_BUTTON%%>', '<button type="submit" class="btn btn-danger" id="delete" name="delete_x" value="1" onclick="return confirm(\'' . $Translation['are you sure?'] . '\');" title="' . html_attr($Translation['Delete']) . '"><i class="glyphicon glyphicon-trash"></i> ' . $Translation['Delete'] . '</button>', $templateCode);
		}else{
			$templateCode = str_replace('<%%DELETE_BUTTON%%>', '', $templateCode);
		}
		$templateCode = str_replace('<%%DESELECT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="deselect" name="deselect_x" value="1" onclick="' . $backAction . '" title="' . html_attr($Translation['Back']) . '"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['Back'] . '</button>', $templateCode);
	}else{
		$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '', $templateCode);
		$templateCode = str_replace('<%%DELETE_BUTTON%%>', '', $templateCode);
		$templateCode = str_replace('<%%DESELECT_BUTTON%%>', ($ShowCancel ? '<button type="submit" class="btn btn-default" id="deselect" name="deselect_x" value="1" onclick="' . $backAction . '" title="' . html_attr($Translation['Back']) . '"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['Back'] . '</button>' : ''), $templateCode);
	}

	// set records to read only if user can't insert new records and can't edit current record
	if(($selected_id && !$AllowUpdate && !$AllowInsert) || (!$selected_id && !$AllowInsert)){
		$jsReadOnly .= "\tjQuery('#day').replaceWith('<div class=\"form-control-static\" id=\"day\">' + (jQuery('#day').val() || '') + '</div>'); jQuery('#day-multi-selection-help').hide();\n";
		$jsReadOnly .= "\tjQuery('#time_start').replaceWith('<div class=\"form-control-static\" id=\"time_start\">' + (jQuery('#time_start').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#time_end').replaceWith('<div class=\"form-control-static\" id=\"time_end\">' + (jQuery('#time_end').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#activity').replaceWith('<div class=\"form-control-static\" id=\"activity\">' + (jQuery('#activity').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('.select2-container').hide();\n";

		$noUploads = true;
	}elseif($AllowInsert){
		$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', true);"; // temporarily disable form change handler
		$jsEditable .= "\tjQuery('#time_start').addClass('always_shown').timepicker({ defaultTime: false, showSeconds: true, showMeridian: true, showInputs: false, disableFocus: true, minuteStep: 5 });";
		$jsEditable .= "\tjQuery('#time_end').addClass('always_shown').timepicker({ defaultTime: false, showSeconds: true, showMeridian: true, showInputs: false, disableFocus: true, minuteStep: 5 });";
			$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', false);"; // re-enable form change handler
	}

	// process combos
	$templateCode = str_replace('<%%COMBO(day)%%>', $combo_day->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(day)%%>', $combo_day->SelectedData, $templateCode);

	/* lookup fields array: 'lookup field name' => array('parent table name', 'lookup field caption') */
	$lookup_fields = array();
	foreach($lookup_fields as $luf => $ptfc){
		$pt_perm = getTablePermissions($ptfc[0]);

		// process foreign key links
		if($pt_perm['view'] || $pt_perm['edit']){
			$templateCode = str_replace("<%%PLINK({$luf})%%>", '<button type="button" class="btn btn-default view_parent hspacer-md" id="' . $ptfc[0] . '_view_parent" title="' . html_attr($Translation['View'] . ' ' . $ptfc[1]) . '"><i class="glyphicon glyphicon-eye-open"></i></button>', $templateCode);
		}

		// if user has insert permission to parent table of a lookup field, put an add new button
		if($pt_perm['insert'] && !$_REQUEST['Embedded']){
			$templateCode = str_replace("<%%ADDNEW({$ptfc[0]})%%>", '<button type="button" class="btn btn-success add_new_parent hspacer-md" id="' . $ptfc[0] . '_add_new" title="' . html_attr($Translation['Add New'] . ' ' . $ptfc[1]) . '"><i class="glyphicon glyphicon-plus-sign"></i></button>', $templateCode);
		}
	}

	// process images
	$templateCode = str_replace('<%%UPLOADFILE(id)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(day)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(time_start)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(time_end)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(activity)%%>', '', $templateCode);

	// process values
	if($selected_id){
		if( $dvprint) $templateCode = str_replace('<%%VALUE(id)%%>', safe_html($urow['id']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(id)%%>', html_attr($row['id']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(id)%%>', urlencode($urow['id']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(day)%%>', safe_html($urow['day']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(day)%%>', html_attr($row['day']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(day)%%>', urlencode($urow['day']), $templateCode);
		$templateCode = str_replace('<%%VALUE(time_start)%%>', time12(html_attr($row['time_start'])), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(time_start)%%>', urlencode(time12($urow['time_start'])), $templateCode);
		$templateCode = str_replace('<%%VALUE(time_end)%%>', time12(html_attr($row['time_end'])), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(time_end)%%>', urlencode(time12($urow['time_end'])), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(activity)%%>', safe_html($urow['activity']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(activity)%%>', html_attr($row['activity']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(activity)%%>', urlencode($urow['activity']), $templateCode);
	}else{
		$templateCode = str_replace('<%%VALUE(id)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(id)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(day)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(day)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(time_start)%%>', time12(''), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(time_start)%%>', urlencode(time12('')), $templateCode);
		$templateCode = str_replace('<%%VALUE(time_end)%%>', time12(''), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(time_end)%%>', urlencode(time12('')), $templateCode);
		$templateCode = str_replace('<%%VALUE(activity)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(activity)%%>', urlencode(''), $templateCode);
	}

	// process translations
	foreach($Translation as $symbol=>$trans){
		$templateCode = str_replace("<%%TRANSLATION($symbol)%%>", $trans, $templateCode);
	}

	// clear scrap
	$templateCode = str_replace('<%%', '<!-- ', $templateCode);
	$templateCode = str_replace('%%>', ' -->', $templateCode);

	// hide links to inaccessible tables
	if($_REQUEST['dvprint_x'] == ''){
		$templateCode .= "\n\n<script>\$j(function(){\n";
		$arrTables = getTableList();
		foreach($arrTables as $name => $caption){
			$templateCode .= "\t\$j('#{$name}_link').removeClass('hidden');\n";
			$templateCode .= "\t\$j('#xs_{$name}_link').removeClass('hidden');\n";
		}

		$templateCode .= $jsReadOnly;
		$templateCode .= $jsEditable;

		if(!$selected_id){
		}

		$templateCode.="\n});</script>\n";
	}

	// ajaxed auto-fill fields
	$templateCode .= '<script>';
	$templateCode .= '$j(function() {';


	$templateCode.="});";
	$templateCode.="</script>";
	$templateCode .= $lookups;

	// handle enforced parent values for read-only lookup fields

	// don't include blank images in lightbox gallery
	$templateCode = preg_replace('/blank.gif" data-lightbox=".*?"/', 'blank.gif"', $templateCode);

	// don't display empty email links
	$templateCode=preg_replace('/<a .*?href="mailto:".*?<\/a>/', '', $templateCode);

	/* default field values */
	$rdata = $jdata = get_defaults('personal_time_table');
	if($selected_id){
		$jdata = get_joined_record('personal_time_table', $selected_id);
		if($jdata === false) $jdata = get_defaults('personal_time_table');
		$rdata = $row;
	}
	$templateCode .= loadView('personal_time_table-ajax-cache', array('rdata' => $rdata, 'jdata' => $jdata));

	// hook: personal_time_table_dv
	if(function_exists('personal_time_table_dv')){
		$args=array();
		personal_time_table_dv(($selected_id ? $selected_id : FALSE), getMemberInfo(), $templateCode, $args);
	}

	return $templateCode;
}
?>