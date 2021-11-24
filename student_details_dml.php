<?php

// Data functions (insert, update, delete, form) for table student_details



function student_details_insert(){
	global $Translation;

	// mm: can member insert record?
	$arrPerm=getTablePermissions('student_details');
	if(!$arrPerm[1]){
		return false;
	}

	$data['full_name'] = makeSafe($_REQUEST['full_name']);
		if($data['full_name'] == empty_lookup_value){ $data['full_name'] = ''; }
	$data['school'] = makeSafe($_REQUEST['school']);
		if($data['school'] == empty_lookup_value){ $data['school'] = ''; }
	$data['department'] = makeSafe($_REQUEST['department']);
		if($data['department'] == empty_lookup_value){ $data['department'] = ''; }
	$data['year_of_study'] = makeSafe($_REQUEST['year_of_study']);
		if($data['year_of_study'] == empty_lookup_value){ $data['year_of_study'] = ''; }
	$data['reg_no'] = makeSafe($_REQUEST['reg_no']);
		if($data['reg_no'] == empty_lookup_value){ $data['reg_no'] = ''; }
	if($data['full_name']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Full name': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	if($data['school']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'School': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	if($data['department']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Department': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	if($data['year_of_study']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Year of study': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	if($data['reg_no']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Reg no': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}

	// hook: student_details_before_insert
	if(function_exists('student_details_before_insert')){
		$args=array();
		if(!student_details_before_insert($data, getMemberInfo(), $args)){ return false; }
	}

	$o = array('silentErrors' => true);
	sql('insert into `student_details` set       `full_name`=' . (($data['full_name'] !== '' && $data['full_name'] !== NULL) ? "'{$data['full_name']}'" : 'NULL') . ', `school`=' . (($data['school'] !== '' && $data['school'] !== NULL) ? "'{$data['school']}'" : 'NULL') . ', `department`=' . (($data['department'] !== '' && $data['department'] !== NULL) ? "'{$data['department']}'" : 'NULL') . ', `year_of_study`=' . (($data['year_of_study'] !== '' && $data['year_of_study'] !== NULL) ? "'{$data['year_of_study']}'" : 'NULL') . ', `reg_no`=' . (($data['reg_no'] !== '' && $data['reg_no'] !== NULL) ? "'{$data['reg_no']}'" : 'NULL'), $o);
	if($o['error']!=''){
		echo $o['error'];
		echo "<a href=\"student_details_view.php?addNew_x=1\">{$Translation['< back']}</a>";
		exit;
	}

	$recID = db_insert_id(db_link());

	// hook: student_details_after_insert
	if(function_exists('student_details_after_insert')){
		$res = sql("select * from `student_details` where `id`='" . makeSafe($recID, false) . "' limit 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = makeSafe($recID, false);
		$args=array();
		if(!student_details_after_insert($data, getMemberInfo(), $args)){ return $recID; }
	}

	// mm: save ownership data
	set_record_owner('student_details', $recID, getLoggedMemberID());

	return $recID;
}

function student_details_delete($selected_id, $AllowDeleteOfParents=false, $skipChecks=false){
	// insure referential integrity ...
	global $Translation;
	$selected_id=makeSafe($selected_id);

	// mm: can member delete record?
	$arrPerm=getTablePermissions('student_details');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='student_details' and pkValue='$selected_id'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='student_details' and pkValue='$selected_id'");
	if(($arrPerm[4]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[4]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[4]==3){ // allow delete?
		// delete allowed, so continue ...
	}else{
		return $Translation['You don\'t have enough permissions to delete this record'];
	}

	// hook: student_details_before_delete
	if(function_exists('student_details_before_delete')){
		$args=array();
		if(!student_details_before_delete($selected_id, $skipChecks, getMemberInfo(), $args))
			return $Translation['Couldn\'t delete this record'];
	}

	sql("delete from `student_details` where `id`='$selected_id'", $eo);

	// hook: student_details_after_delete
	if(function_exists('student_details_after_delete')){
		$args=array();
		student_details_after_delete($selected_id, getMemberInfo(), $args);
	}

	// mm: delete ownership data
	sql("delete from membership_userrecords where tableName='student_details' and pkValue='$selected_id'", $eo);
}

function student_details_update($selected_id){
	global $Translation;

	// mm: can member edit record?
	$arrPerm=getTablePermissions('student_details');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='student_details' and pkValue='".makeSafe($selected_id)."'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='student_details' and pkValue='".makeSafe($selected_id)."'");
	if(($arrPerm[3]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[3]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[3]==3){ // allow update?
		// update allowed, so continue ...
	}else{
		return false;
	}

	$data['full_name'] = makeSafe($_REQUEST['full_name']);
		if($data['full_name'] == empty_lookup_value){ $data['full_name'] = ''; }
	if($data['full_name']==''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">{$Translation['error:']} 'Full name': {$Translation['field not null']}<br><br>";
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	$data['school'] = makeSafe($_REQUEST['school']);
		if($data['school'] == empty_lookup_value){ $data['school'] = ''; }
	if($data['school']==''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">{$Translation['error:']} 'School': {$Translation['field not null']}<br><br>";
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	$data['department'] = makeSafe($_REQUEST['department']);
		if($data['department'] == empty_lookup_value){ $data['department'] = ''; }
	if($data['department']==''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">{$Translation['error:']} 'Department': {$Translation['field not null']}<br><br>";
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	$data['year_of_study'] = makeSafe($_REQUEST['year_of_study']);
		if($data['year_of_study'] == empty_lookup_value){ $data['year_of_study'] = ''; }
	if($data['year_of_study']==''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">{$Translation['error:']} 'Year of study': {$Translation['field not null']}<br><br>";
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	$data['reg_no'] = makeSafe($_REQUEST['reg_no']);
		if($data['reg_no'] == empty_lookup_value){ $data['reg_no'] = ''; }
	if($data['reg_no']==''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">{$Translation['error:']} 'Reg no': {$Translation['field not null']}<br><br>";
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	$data['selectedID']=makeSafe($selected_id);

	// hook: student_details_before_update
	if(function_exists('student_details_before_update')){
		$args=array();
		if(!student_details_before_update($data, getMemberInfo(), $args)){ return false; }
	}

	$o=array('silentErrors' => true);
	sql('update `student_details` set       `full_name`=' . (($data['full_name'] !== '' && $data['full_name'] !== NULL) ? "'{$data['full_name']}'" : 'NULL') . ', `school`=' . (($data['school'] !== '' && $data['school'] !== NULL) ? "'{$data['school']}'" : 'NULL') . ', `department`=' . (($data['department'] !== '' && $data['department'] !== NULL) ? "'{$data['department']}'" : 'NULL') . ', `year_of_study`=' . (($data['year_of_study'] !== '' && $data['year_of_study'] !== NULL) ? "'{$data['year_of_study']}'" : 'NULL') . ', `reg_no`=' . (($data['reg_no'] !== '' && $data['reg_no'] !== NULL) ? "'{$data['reg_no']}'" : 'NULL') . " where `id`='".makeSafe($selected_id)."'", $o);
	if($o['error']!=''){
		echo $o['error'];
		echo '<a href="student_details_view.php?SelectedID='.urlencode($selected_id)."\">{$Translation['< back']}</a>";
		exit;
	}


	// hook: student_details_after_update
	if(function_exists('student_details_after_update')){
		$res = sql("SELECT * FROM `student_details` WHERE `id`='{$data['selectedID']}' LIMIT 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = $data['id'];
		$args = array();
		if(!student_details_after_update($data, getMemberInfo(), $args)){ return; }
	}

	// mm: update ownership data
	sql("update membership_userrecords set dateUpdated='".time()."' where tableName='student_details' and pkValue='".makeSafe($selected_id)."'", $eo);

}

function student_details_form($selected_id = '', $AllowUpdate = 1, $AllowInsert = 1, $AllowDelete = 1, $ShowCancel = 0, $TemplateDV = '', $TemplateDVP = ''){
	// function to return an editable form for a table records
	// and fill it with data of record whose ID is $selected_id. If $selected_id
	// is empty, an empty form is shown, with only an 'Add New'
	// button displayed.

	global $Translation;

	// mm: get table permissions
	$arrPerm=getTablePermissions('student_details');
	if(!$arrPerm[1] && $selected_id==''){ return ''; }
	$AllowInsert = ($arrPerm[1] ? true : false);
	// print preview?
	$dvprint = false;
	if($selected_id && $_REQUEST['dvprint_x'] != ''){
		$dvprint = true;
	}

	$filterer_school = thisOr(undo_magic_quotes($_REQUEST['filterer_school']), '');
	$filterer_department = thisOr(undo_magic_quotes($_REQUEST['filterer_department']), '');

	// populate filterers, starting from children to grand-parents
	if($filterer_department && !$filterer_school) $filterer_school = sqlValue("select school from departments where id='" . makeSafe($filterer_department) . "'");

	// unique random identifier
	$rnd1 = ($dvprint ? rand(1000000, 9999999) : '');
	// combobox: school
	$combo_school = new DataCombo;
	// combobox: department, filterable by: school
	$combo_department = new DataCombo;
	// combobox: year_of_study
	$combo_year_of_study = new Combo;
	$combo_year_of_study->ListType = 0;
	$combo_year_of_study->MultipleSeparator = ', ';
	$combo_year_of_study->ListBoxHeight = 10;
	$combo_year_of_study->RadiosPerLine = 1;
	if(is_file(dirname(__FILE__).'/hooks/student_details.year_of_study.csv')){
		$year_of_study_data = addslashes(implode('', @file(dirname(__FILE__).'/hooks/student_details.year_of_study.csv')));
		$combo_year_of_study->ListItem = explode('||', entitiesToUTF8(convertLegacyOptions($year_of_study_data)));
		$combo_year_of_study->ListData = $combo_year_of_study->ListItem;
	}else{
		$combo_year_of_study->ListItem = explode('||', entitiesToUTF8(convertLegacyOptions("1;;2;;3;;4;;5;;6")));
		$combo_year_of_study->ListData = $combo_year_of_study->ListItem;
	}
	$combo_year_of_study->SelectName = 'year_of_study';
	$combo_year_of_study->AllowNull = false;

	if($selected_id){
		// mm: check member permissions
		if(!$arrPerm[2]){
			return "";
		}
		// mm: who is the owner?
		$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='student_details' and pkValue='".makeSafe($selected_id)."'");
		$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='student_details' and pkValue='".makeSafe($selected_id)."'");
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

		$res = sql("select * from `student_details` where `id`='".makeSafe($selected_id)."'", $eo);
		if(!($row = db_fetch_array($res))){
			return error_message($Translation['No records found'], 'student_details_view.php', false);
		}
		$urow = $row; /* unsanitized data */
		$hc = new CI_Input();
		$row = $hc->xss_clean($row); /* sanitize data */
		$combo_school->SelectedData = $row['school'];
		$combo_department->SelectedData = $row['department'];
		$combo_year_of_study->SelectedData = $row['year_of_study'];
	}else{
		$combo_school->SelectedData = $filterer_school;
		$combo_department->SelectedData = $filterer_department;
		$combo_year_of_study->SelectedText = ( $_REQUEST['FilterField'][1]=='5' && $_REQUEST['FilterOperator'][1]=='<=>' ? (get_magic_quotes_gpc() ? stripslashes($_REQUEST['FilterValue'][1]) : $_REQUEST['FilterValue'][1]) : "");
	}
	$combo_school->HTML = '<span id="school-container' . $rnd1 . '"></span><input type="hidden" name="school" id="school' . $rnd1 . '" value="' . html_attr($combo_school->SelectedData) . '">';
	$combo_school->MatchText = '<span id="school-container-readonly' . $rnd1 . '"></span><input type="hidden" name="school" id="school' . $rnd1 . '" value="' . html_attr($combo_school->SelectedData) . '">';
	$combo_department->HTML = '<span id="department-container' . $rnd1 . '"></span><input type="hidden" name="department" id="department' . $rnd1 . '" value="' . html_attr($combo_department->SelectedData) . '">';
	$combo_department->MatchText = '<span id="department-container-readonly' . $rnd1 . '"></span><input type="hidden" name="department" id="department' . $rnd1 . '" value="' . html_attr($combo_department->SelectedData) . '">';
	$combo_year_of_study->Render();

	ob_start();
	?>

	<script>
		// initial lookup values
		AppGini.current_school__RAND__ = { text: "", value: "<?php echo addslashes($selected_id ? $urow['school'] : $filterer_school); ?>"};
		AppGini.current_department__RAND__ = { text: "", value: "<?php echo addslashes($selected_id ? $urow['department'] : $filterer_department); ?>"};

		jQuery(function() {
			setTimeout(function(){
				if(typeof(school_reload__RAND__) == 'function') school_reload__RAND__();
				<?php echo (!$AllowUpdate || $dvprint ? 'if(typeof(department_reload__RAND__) == \'function\') department_reload__RAND__(AppGini.current_school__RAND__.value);' : ''); ?>
			}, 10); /* we need to slightly delay client-side execution of the above code to allow AppGini.ajaxCache to work */
		});
		function school_reload__RAND__(){
		<?php if(($AllowUpdate || $AllowInsert) && !$dvprint){ ?>

			$j("#school-container__RAND__").select2({
				/* initial default value */
				initSelection: function(e, c){
					$j.ajax({
						url: 'ajax_combo.php',
						dataType: 'json',
						data: { id: AppGini.current_school__RAND__.value, t: 'student_details', f: 'school' },
						success: function(resp){
							c({
								id: resp.results[0].id,
								text: resp.results[0].text
							});
							$j('[name="school"]').val(resp.results[0].id);
							$j('[id=school-container-readonly__RAND__]').html('<span id="school-match-text">' + resp.results[0].text + '</span>');
							if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=schools_view_parent]').hide(); }else{ $j('.btn[id=schools_view_parent]').show(); }

						if(typeof(department_reload__RAND__) == 'function') department_reload__RAND__(AppGini.current_school__RAND__.value);

							if(typeof(school_update_autofills__RAND__) == 'function') school_update_autofills__RAND__();
						}
					});
				},
				width: '100%',
				formatNoMatches: function(term){ /* */ return '<?php echo addslashes($Translation['No matches found!']); ?>'; },
				minimumResultsForSearch: 10,
				loadMorePadding: 200,
				ajax: {
					url: 'ajax_combo.php',
					dataType: 'json',
					cache: true,
					data: function(term, page){ /* */ return { s: term, p: page, t: 'student_details', f: 'school' }; },
					results: function(resp, page){ /* */ return resp; }
				},
				escapeMarkup: function(str){ /* */ return str; }
			}).on('change', function(e){
				AppGini.current_school__RAND__.value = e.added.id;
				AppGini.current_school__RAND__.text = e.added.text;
				$j('[name="school"]').val(e.added.id);
				if(e.added.id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=schools_view_parent]').hide(); }else{ $j('.btn[id=schools_view_parent]').show(); }

						if(typeof(department_reload__RAND__) == 'function') department_reload__RAND__(AppGini.current_school__RAND__.value);

				if(typeof(school_update_autofills__RAND__) == 'function') school_update_autofills__RAND__();
			});

			if(!$j("#school-container__RAND__").length){
				$j.ajax({
					url: 'ajax_combo.php',
					dataType: 'json',
					data: { id: AppGini.current_school__RAND__.value, t: 'student_details', f: 'school' },
					success: function(resp){
						$j('[name="school"]').val(resp.results[0].id);
						$j('[id=school-container-readonly__RAND__]').html('<span id="school-match-text">' + resp.results[0].text + '</span>');
						if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=schools_view_parent]').hide(); }else{ $j('.btn[id=schools_view_parent]').show(); }

						if(typeof(school_update_autofills__RAND__) == 'function') school_update_autofills__RAND__();
					}
				});
			}

		<?php }else{ ?>

			$j.ajax({
				url: 'ajax_combo.php',
				dataType: 'json',
				data: { id: AppGini.current_school__RAND__.value, t: 'student_details', f: 'school' },
				success: function(resp){
					$j('[id=school-container__RAND__], [id=school-container-readonly__RAND__]').html('<span id="school-match-text">' + resp.results[0].text + '</span>');
					if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=schools_view_parent]').hide(); }else{ $j('.btn[id=schools_view_parent]').show(); }

					if(typeof(school_update_autofills__RAND__) == 'function') school_update_autofills__RAND__();
				}
			});
		<?php } ?>

		}
		function department_reload__RAND__(filterer_school){
		<?php if(($AllowUpdate || $AllowInsert) && !$dvprint){ ?>

			$j("#department-container__RAND__").select2({
				/* initial default value */
				initSelection: function(e, c){
					$j.ajax({
						url: 'ajax_combo.php',
						dataType: 'json',
						data: { filterer_school: filterer_school, id: AppGini.current_department__RAND__.value, t: 'student_details', f: 'department' },
						success: function(resp){
							c({
								id: resp.results[0].id,
								text: resp.results[0].text
							});
							$j('[name="department"]').val(resp.results[0].id);
							$j('[id=department-container-readonly__RAND__]').html('<span id="department-match-text">' + resp.results[0].text + '</span>');
							if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=departments_view_parent]').hide(); }else{ $j('.btn[id=departments_view_parent]').show(); }


							if(typeof(department_update_autofills__RAND__) == 'function') department_update_autofills__RAND__();
						}
					});
				},
				width: '100%',
				formatNoMatches: function(term){ /* */ return '<?php echo addslashes($Translation['No matches found!']); ?>'; },
				minimumResultsForSearch: 10,
				loadMorePadding: 200,
				ajax: {
					url: 'ajax_combo.php',
					dataType: 'json',
					cache: true,
					data: function(term, page){ /* */ return { filterer_school: filterer_school, s: term, p: page, t: 'student_details', f: 'department' }; },
					results: function(resp, page){ /* */ return resp; }
				},
				escapeMarkup: function(str){ /* */ return str; }
			}).on('change', function(e){
				AppGini.current_department__RAND__.value = e.added.id;
				AppGini.current_department__RAND__.text = e.added.text;
				$j('[name="department"]').val(e.added.id);
				if(e.added.id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=departments_view_parent]').hide(); }else{ $j('.btn[id=departments_view_parent]').show(); }


				if(typeof(department_update_autofills__RAND__) == 'function') department_update_autofills__RAND__();
			});

			if(!$j("#department-container__RAND__").length){
				$j.ajax({
					url: 'ajax_combo.php',
					dataType: 'json',
					data: { id: AppGini.current_department__RAND__.value, t: 'student_details', f: 'department' },
					success: function(resp){
						$j('[name="department"]').val(resp.results[0].id);
						$j('[id=department-container-readonly__RAND__]').html('<span id="department-match-text">' + resp.results[0].text + '</span>');
						if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=departments_view_parent]').hide(); }else{ $j('.btn[id=departments_view_parent]').show(); }

						if(typeof(department_update_autofills__RAND__) == 'function') department_update_autofills__RAND__();
					}
				});
			}

		<?php }else{ ?>

			$j.ajax({
				url: 'ajax_combo.php',
				dataType: 'json',
				data: { id: AppGini.current_department__RAND__.value, t: 'student_details', f: 'department' },
				success: function(resp){
					$j('[id=department-container__RAND__], [id=department-container-readonly__RAND__]').html('<span id="department-match-text">' + resp.results[0].text + '</span>');
					if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=departments_view_parent]').hide(); }else{ $j('.btn[id=departments_view_parent]').show(); }

					if(typeof(department_update_autofills__RAND__) == 'function') department_update_autofills__RAND__();
				}
			});
		<?php } ?>

		}
	</script>
	<?php

	$lookups = str_replace('__RAND__', $rnd1, ob_get_contents());
	ob_end_clean();


	// code for template based detail view forms

	// open the detail view template
	if($dvprint){
		$template_file = is_file("./{$TemplateDVP}") ? "./{$TemplateDVP}" : './templates/student_details_templateDVP.html';
		$templateCode = @file_get_contents($template_file);
	}else{
		$template_file = is_file("./{$TemplateDV}") ? "./{$TemplateDV}" : './templates/student_details_templateDV.html';
		$templateCode = @file_get_contents($template_file);
	}

	// process form title
	$templateCode = str_replace('<%%DETAIL_VIEW_TITLE%%>', 'Personal detail details', $templateCode);
	$templateCode = str_replace('<%%RND1%%>', $rnd1, $templateCode);
	$templateCode = str_replace('<%%EMBEDDED%%>', ($_REQUEST['Embedded'] ? 'Embedded=1' : ''), $templateCode);
	// process buttons
	if($AllowInsert){
		if(!$selected_id) $templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-success" id="insert" name="insert_x" value="1" onclick="return student_details_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save New'] . '</button>', $templateCode);
		$templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="insert" name="insert_x" value="1" onclick="return student_details_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save As Copy'] . '</button>', $templateCode);
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
			$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '<button type="submit" class="btn btn-success btn-lg" id="update" name="update_x" value="1" onclick="return student_details_validateData();" title="' . html_attr($Translation['Save Changes']) . '"><i class="glyphicon glyphicon-ok"></i> ' . $Translation['Save Changes'] . '</button>', $templateCode);
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
		$jsReadOnly .= "\tjQuery('#full_name').replaceWith('<div class=\"form-control-static\" id=\"full_name\">' + (jQuery('#full_name').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#school').prop('disabled', true).css({ color: '#555', backgroundColor: '#fff' });\n";
		$jsReadOnly .= "\tjQuery('#school_caption').prop('disabled', true).css({ color: '#555', backgroundColor: 'white' });\n";
		$jsReadOnly .= "\tjQuery('#department').prop('disabled', true).css({ color: '#555', backgroundColor: '#fff' });\n";
		$jsReadOnly .= "\tjQuery('#department_caption').prop('disabled', true).css({ color: '#555', backgroundColor: 'white' });\n";
		$jsReadOnly .= "\tjQuery('#year_of_study').replaceWith('<div class=\"form-control-static\" id=\"year_of_study\">' + (jQuery('#year_of_study').val() || '') + '</div>'); jQuery('#year_of_study-multi-selection-help').hide();\n";
		$jsReadOnly .= "\tjQuery('#reg_no').replaceWith('<div class=\"form-control-static\" id=\"reg_no\">' + (jQuery('#reg_no').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('.select2-container').hide();\n";

		$noUploads = true;
	}elseif($AllowInsert){
		$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', true);"; // temporarily disable form change handler
			$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', false);"; // re-enable form change handler
	}

	// process combos
	$templateCode = str_replace('<%%COMBO(school)%%>', $combo_school->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(school)%%>', $combo_school->MatchText, $templateCode);
	$templateCode = str_replace('<%%URLCOMBOTEXT(school)%%>', urlencode($combo_school->MatchText), $templateCode);
	$templateCode = str_replace('<%%COMBO(department)%%>', $combo_department->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(department)%%>', $combo_department->MatchText, $templateCode);
	$templateCode = str_replace('<%%URLCOMBOTEXT(department)%%>', urlencode($combo_department->MatchText), $templateCode);
	$templateCode = str_replace('<%%COMBO(year_of_study)%%>', $combo_year_of_study->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(year_of_study)%%>', $combo_year_of_study->SelectedData, $templateCode);

	/* lookup fields array: 'lookup field name' => array('parent table name', 'lookup field caption') */
	$lookup_fields = array(  'school' => array('schools', 'School'), 'department' => array('departments', 'Department'));
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
	$templateCode = str_replace('<%%UPLOADFILE(full_name)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(school)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(department)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(year_of_study)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(reg_no)%%>', '', $templateCode);

	// process values
	if($selected_id){
		if( $dvprint) $templateCode = str_replace('<%%VALUE(id)%%>', safe_html($urow['id']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(id)%%>', html_attr($row['id']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(id)%%>', urlencode($urow['id']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(full_name)%%>', safe_html($urow['full_name']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(full_name)%%>', html_attr($row['full_name']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(full_name)%%>', urlencode($urow['full_name']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(school)%%>', safe_html($urow['school']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(school)%%>', html_attr($row['school']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(school)%%>', urlencode($urow['school']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(department)%%>', safe_html($urow['department']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(department)%%>', html_attr($row['department']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(department)%%>', urlencode($urow['department']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(year_of_study)%%>', safe_html($urow['year_of_study']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(year_of_study)%%>', html_attr($row['year_of_study']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(year_of_study)%%>', urlencode($urow['year_of_study']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(reg_no)%%>', safe_html($urow['reg_no']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(reg_no)%%>', html_attr($row['reg_no']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(reg_no)%%>', urlencode($urow['reg_no']), $templateCode);
	}else{
		$templateCode = str_replace('<%%VALUE(id)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(id)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(full_name)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(full_name)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(school)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(school)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(department)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(department)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(year_of_study)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(year_of_study)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(reg_no)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(reg_no)%%>', urlencode(''), $templateCode);
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
	$rdata = $jdata = get_defaults('student_details');
	if($selected_id){
		$jdata = get_joined_record('student_details', $selected_id);
		if($jdata === false) $jdata = get_defaults('student_details');
		$rdata = $row;
	}
	$templateCode .= loadView('student_details-ajax-cache', array('rdata' => $rdata, 'jdata' => $jdata));

	// hook: student_details_dv
	if(function_exists('student_details_dv')){
		$args=array();
		student_details_dv(($selected_id ? $selected_id : FALSE), getMemberInfo(), $templateCode, $args);
	}

	return $templateCode;
}
?>