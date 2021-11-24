<?php

	/* Configuration */
	/*************************************/

		$pcConfig = array(
			'schools' => array(   
			),
			'departments' => array(   
				'school' => array(   
					'parent-table' => 'schools',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Departments',
					'auto-close' => true,
					'table-icon' => 'resources/table_icons/chart_organisation.png',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => array(1 => 'Name', 2 => 'School'),
					'display-field-names' => array(1 => 'name', 2 => 'school'),
					'sortable-fields' => array(0 => '`departments`.`id`', 1 => 2, 2 => '`schools1`.`name`'),
					'records-per-page' => 10,
					'default-sort-by' => false,
					'default-sort-direction' => 'asc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-departments',
					'template-printable' => 'children-departments-printable',
					'query' => "SELECT `departments`.`id` as 'id', `departments`.`name` as 'name', IF(    CHAR_LENGTH(`schools1`.`name`), CONCAT_WS('',   `schools1`.`name`), '') as 'school' FROM `departments` LEFT JOIN `schools` as schools1 ON `schools1`.`id`=`departments`.`school` "
				)
			),
			'class_time_table' => array(   
				'school' => array(   
					'parent-table' => 'schools',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Class time table',
					'auto-close' => true,
					'table-icon' => 'resources/table_icons/blackboard_drawing.png',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => array(1 => 'Day', 2 => ' Time Start', 3 => 'Time End', 4 => 'Unit code', 5 => 'Venue', 6 => 'School', 7 => 'Department', 8 => 'Year of study'),
					'display-field-names' => array(1 => 'day', 2 => 'time_start', 3 => 'time_end', 4 => 'unit_code', 5 => 'venue', 6 => 'school', 7 => 'department', 8 => 'year_of_study'),
					'sortable-fields' => array(0 => '`class_time_table`.`id`', 1 => 2, 2 => '`class_time_table`.`time_start`', 3 => '`class_time_table`.`time_end`', 4 => 5, 5 => 6, 6 => '`schools1`.`name`', 7 => '`departments1`.`name`', 8 => 9),
					'records-per-page' => 10,
					'default-sort-by' => false,
					'default-sort-direction' => 'asc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-class_time_table',
					'template-printable' => 'children-class_time_table-printable',
					'query' => "SELECT `class_time_table`.`id` as 'id', `class_time_table`.`day` as 'day', TIME_FORMAT(`class_time_table`.`time_start`, '%r') as 'time_start', TIME_FORMAT(`class_time_table`.`time_end`, '%r') as 'time_end', `class_time_table`.`unit_code` as 'unit_code', `class_time_table`.`venue` as 'venue', IF(    CHAR_LENGTH(`schools1`.`name`), CONCAT_WS('',   `schools1`.`name`), '') as 'school', IF(    CHAR_LENGTH(`departments1`.`name`), CONCAT_WS('',   `departments1`.`name`), '') as 'department', `class_time_table`.`year_of_study` as 'year_of_study' FROM `class_time_table` LEFT JOIN `schools` as schools1 ON `schools1`.`id`=`class_time_table`.`school` LEFT JOIN `departments` as departments1 ON `departments1`.`id`=`class_time_table`.`department` "
				),
				'department' => array(   
					'parent-table' => 'departments',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Class time table',
					'auto-close' => true,
					'table-icon' => 'resources/table_icons/blackboard_drawing.png',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => array(1 => 'Day', 2 => ' Time Start', 3 => 'Time End', 4 => 'Unit code', 5 => 'Venue', 6 => 'School', 7 => 'Department', 8 => 'Year of study'),
					'display-field-names' => array(1 => 'day', 2 => 'time_start', 3 => 'time_end', 4 => 'unit_code', 5 => 'venue', 6 => 'school', 7 => 'department', 8 => 'year_of_study'),
					'sortable-fields' => array(0 => '`class_time_table`.`id`', 1 => 2, 2 => '`class_time_table`.`time_start`', 3 => '`class_time_table`.`time_end`', 4 => 5, 5 => 6, 6 => '`schools1`.`name`', 7 => '`departments1`.`name`', 8 => 9),
					'records-per-page' => 10,
					'default-sort-by' => false,
					'default-sort-direction' => 'asc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-class_time_table',
					'template-printable' => 'children-class_time_table-printable',
					'query' => "SELECT `class_time_table`.`id` as 'id', `class_time_table`.`day` as 'day', TIME_FORMAT(`class_time_table`.`time_start`, '%r') as 'time_start', TIME_FORMAT(`class_time_table`.`time_end`, '%r') as 'time_end', `class_time_table`.`unit_code` as 'unit_code', `class_time_table`.`venue` as 'venue', IF(    CHAR_LENGTH(`schools1`.`name`), CONCAT_WS('',   `schools1`.`name`), '') as 'school', IF(    CHAR_LENGTH(`departments1`.`name`), CONCAT_WS('',   `departments1`.`name`), '') as 'department', `class_time_table`.`year_of_study` as 'year_of_study' FROM `class_time_table` LEFT JOIN `schools` as schools1 ON `schools1`.`id`=`class_time_table`.`school` LEFT JOIN `departments` as departments1 ON `departments1`.`id`=`class_time_table`.`department` "
				)
			),
			'exam_time_table' => array(   
				'school' => array(   
					'parent-table' => 'schools',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Exam time table',
					'auto-close' => true,
					'table-icon' => 'resources/table_icons/books.png',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => array(1 => 'Date', 2 => 'Time Start', 3 => 'Time End', 4 => 'Unit code', 5 => 'Venue', 6 => 'School', 7 => 'Department', 8 => 'Year of study'),
					'display-field-names' => array(1 => 'date', 2 => 'time_start', 3 => 'time_end', 4 => 'unit_code', 5 => 'venue', 6 => 'school', 7 => 'department', 8 => 'year_of_study'),
					'sortable-fields' => array(0 => '`exam_time_table`.`id`', 1 => '`exam_time_table`.`date`', 2 => '`exam_time_table`.`time_start`', 3 => '`exam_time_table`.`time_end`', 4 => 5, 5 => 6, 6 => '`schools1`.`name`', 7 => '`departments1`.`name`', 8 => 9),
					'records-per-page' => 10,
					'default-sort-by' => false,
					'default-sort-direction' => 'asc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-exam_time_table',
					'template-printable' => 'children-exam_time_table-printable',
					'query' => "SELECT `exam_time_table`.`id` as 'id', if(`exam_time_table`.`date`,date_format(`exam_time_table`.`date`,'%m/%d/%Y'),'') as 'date', TIME_FORMAT(`exam_time_table`.`time_start`, '%r') as 'time_start', TIME_FORMAT(`exam_time_table`.`time_end`, '%r') as 'time_end', `exam_time_table`.`unit_code` as 'unit_code', `exam_time_table`.`venue` as 'venue', IF(    CHAR_LENGTH(`schools1`.`name`), CONCAT_WS('',   `schools1`.`name`), '') as 'school', IF(    CHAR_LENGTH(`departments1`.`name`), CONCAT_WS('',   `departments1`.`name`), '') as 'department', `exam_time_table`.`year_of_study` as 'year_of_study' FROM `exam_time_table` LEFT JOIN `schools` as schools1 ON `schools1`.`id`=`exam_time_table`.`school` LEFT JOIN `departments` as departments1 ON `departments1`.`id`=`exam_time_table`.`department` "
				),
				'department' => array(   
					'parent-table' => 'departments',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Exam time table',
					'auto-close' => true,
					'table-icon' => 'resources/table_icons/books.png',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => array(1 => 'Date', 2 => 'Time Start', 3 => 'Time End', 4 => 'Unit code', 5 => 'Venue', 6 => 'School', 7 => 'Department', 8 => 'Year of study'),
					'display-field-names' => array(1 => 'date', 2 => 'time_start', 3 => 'time_end', 4 => 'unit_code', 5 => 'venue', 6 => 'school', 7 => 'department', 8 => 'year_of_study'),
					'sortable-fields' => array(0 => '`exam_time_table`.`id`', 1 => '`exam_time_table`.`date`', 2 => '`exam_time_table`.`time_start`', 3 => '`exam_time_table`.`time_end`', 4 => 5, 5 => 6, 6 => '`schools1`.`name`', 7 => '`departments1`.`name`', 8 => 9),
					'records-per-page' => 10,
					'default-sort-by' => false,
					'default-sort-direction' => 'asc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-exam_time_table',
					'template-printable' => 'children-exam_time_table-printable',
					'query' => "SELECT `exam_time_table`.`id` as 'id', if(`exam_time_table`.`date`,date_format(`exam_time_table`.`date`,'%m/%d/%Y'),'') as 'date', TIME_FORMAT(`exam_time_table`.`time_start`, '%r') as 'time_start', TIME_FORMAT(`exam_time_table`.`time_end`, '%r') as 'time_end', `exam_time_table`.`unit_code` as 'unit_code', `exam_time_table`.`venue` as 'venue', IF(    CHAR_LENGTH(`schools1`.`name`), CONCAT_WS('',   `schools1`.`name`), '') as 'school', IF(    CHAR_LENGTH(`departments1`.`name`), CONCAT_WS('',   `departments1`.`name`), '') as 'department', `exam_time_table`.`year_of_study` as 'year_of_study' FROM `exam_time_table` LEFT JOIN `schools` as schools1 ON `schools1`.`id`=`exam_time_table`.`school` LEFT JOIN `departments` as departments1 ON `departments1`.`id`=`exam_time_table`.`department` "
				)
			),
			'personal_time_table' => array(   
			),
			'student_details' => array(   
				'school' => array(   
					'parent-table' => 'schools',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Personal details',
					'auto-close' => true,
					'table-icon' => 'resources/table_icons/administrator.png',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => array(1 => 'Full name', 2 => 'School', 3 => 'Department', 4 => 'Year of study', 5 => 'Reg no'),
					'display-field-names' => array(1 => 'full_name', 2 => 'school', 3 => 'department', 4 => 'year_of_study', 5 => 'reg_no'),
					'sortable-fields' => array(0 => '`student_details`.`id`', 1 => 2, 2 => '`schools1`.`name`', 3 => '`departments1`.`name`', 4 => 5, 5 => 6),
					'records-per-page' => 10,
					'default-sort-by' => false,
					'default-sort-direction' => 'asc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-student_details',
					'template-printable' => 'children-student_details-printable',
					'query' => "SELECT `student_details`.`id` as 'id', `student_details`.`full_name` as 'full_name', IF(    CHAR_LENGTH(`schools1`.`name`), CONCAT_WS('',   `schools1`.`name`), '') as 'school', IF(    CHAR_LENGTH(`departments1`.`name`), CONCAT_WS('',   `departments1`.`name`), '') as 'department', `student_details`.`year_of_study` as 'year_of_study', `student_details`.`reg_no` as 'reg_no' FROM `student_details` LEFT JOIN `schools` as schools1 ON `schools1`.`id`=`student_details`.`school` LEFT JOIN `departments` as departments1 ON `departments1`.`id`=`student_details`.`department` "
				),
				'department' => array(   
					'parent-table' => 'departments',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Personal details',
					'auto-close' => true,
					'table-icon' => 'resources/table_icons/administrator.png',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => array(1 => 'Full name', 2 => 'School', 3 => 'Department', 4 => 'Year of study', 5 => 'Reg no'),
					'display-field-names' => array(1 => 'full_name', 2 => 'school', 3 => 'department', 4 => 'year_of_study', 5 => 'reg_no'),
					'sortable-fields' => array(0 => '`student_details`.`id`', 1 => 2, 2 => '`schools1`.`name`', 3 => '`departments1`.`name`', 4 => 5, 5 => 6),
					'records-per-page' => 10,
					'default-sort-by' => false,
					'default-sort-direction' => 'asc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-student_details',
					'template-printable' => 'children-student_details-printable',
					'query' => "SELECT `student_details`.`id` as 'id', `student_details`.`full_name` as 'full_name', IF(    CHAR_LENGTH(`schools1`.`name`), CONCAT_WS('',   `schools1`.`name`), '') as 'school', IF(    CHAR_LENGTH(`departments1`.`name`), CONCAT_WS('',   `departments1`.`name`), '') as 'department', `student_details`.`year_of_study` as 'year_of_study', `student_details`.`reg_no` as 'reg_no' FROM `student_details` LEFT JOIN `schools` as schools1 ON `schools1`.`id`=`student_details`.`school` LEFT JOIN `departments` as departments1 ON `departments1`.`id`=`student_details`.`department` "
				)
			),
			'notices' => array(   
			)
		);

	/*************************************/
	/* End of configuration */


	$currDir = dirname(__FILE__);
	include("{$currDir}/defaultLang.php");
	include("{$currDir}/language.php");
	include("{$currDir}/lib.php");
	@header('Content-Type: text/html; charset=' . datalist_db_encoding);

	handle_maintenance();

	/**
	* dynamic configuration based on current user's permissions
	* $userPCConfig array is populated only with parent tables where the user has access to
	* at least one child table
	*/
	$userPCConfig = array();
	foreach($pcConfig as $pcChildTable => $ChildrenLookups){
		$permChild = getTablePermissions($pcChildTable);
		if($permChild[2]){ // user can view records of the child table, so proceed to check children lookups
			foreach($ChildrenLookups as $ChildLookupField => $ChildConfig){
				$permParent = getTablePermissions($ChildConfig['parent-table']);
				if($permParent[2]){ // user can view records of parent table
					$userPCConfig[$pcChildTable][$ChildLookupField] = $pcConfig[$pcChildTable][$ChildLookupField];
					// show add new only if configured above AND the user has insert permission
					if($permChild[1] && $pcConfig[$pcChildTable][$ChildLookupField]['display-add-new']){
						$userPCConfig[$pcChildTable][$ChildLookupField]['display-add-new'] = true;
					}else{
						$userPCConfig[$pcChildTable][$ChildLookupField]['display-add-new'] = false;
					}
				}
			}
		}
	}

	/* Receive, UTF-convert, and validate parameters */
	$ParentTable = $_REQUEST['ParentTable']; // needed only with operation=show-children, will be validated in the processing code
	$ChildTable = $_REQUEST['ChildTable'];
		if(!in_array($ChildTable, array_keys($userPCConfig))){
			/* defaults to first child table in config array if not provided */
			$ChildTable = current(array_keys($userPCConfig));
		}
		if(!$ChildTable){ die('<!-- No tables accessible to current user -->'); }
	$SelectedID = strip_tags($_REQUEST['SelectedID']);
	$ChildLookupField = $_REQUEST['ChildLookupField'];
		if(!in_array($ChildLookupField, array_keys($userPCConfig[$ChildTable]))){
			/* defaults to first lookup in current child config array if not provided */
			$ChildLookupField = current(array_keys($userPCConfig[$ChildTable]));
		}
	$Page = intval($_REQUEST['Page']);
		if($Page < 1){
			$Page = 1;
		}
	$SortBy = ($_REQUEST['SortBy'] != '' ? abs(intval($_REQUEST['SortBy'])) : false);
		if(!in_array($SortBy, array_keys($userPCConfig[$ChildTable][$ChildLookupField]['sortable-fields']), true)){
			$SortBy = $userPCConfig[$ChildTable][$ChildLookupField]['default-sort-by'];
		}
	$SortDirection = strtolower($_REQUEST['SortDirection']);
		if(!in_array($SortDirection, array('asc', 'desc'))){
			$SortDirection = $userPCConfig[$ChildTable][$ChildLookupField]['default-sort-direction'];
		}
	$Operation = strtolower($_REQUEST['Operation']);
		if(!in_array($Operation, array('get-records', 'show-children', 'get-records-printable', 'show-children-printable'))){
			$Operation = 'get-records';
		}

	/* process requested operation */
	switch($Operation){
		/************************************************/
		case 'show-children':
			/* populate HTML and JS content with children tabs */
			$tabLabels = $tabPanels = $tabLoaders = '';
			foreach($userPCConfig as $ChildTable => $childLookups){
				foreach($childLookups as $ChildLookupField => $childConfig){
					if($childConfig['parent-table'] == $ParentTable){
						$TableIcon = ($childConfig['table-icon'] ? "<img src=\"{$childConfig['table-icon']}\" border=\"0\" />" : '');
						$tabLabels .= sprintf('<li%s><a href="#panel_%s-%s" id="tab_%s-%s" data-toggle="tab">%s%s</a></li>' . "\n\t\t\t\t\t",($tabLabels ? '' : ' class="active"'), $ChildTable, $ChildLookupField, $ChildTable, $ChildLookupField, $TableIcon, $childConfig['tab-label']);
						$tabPanels .= sprintf('<div id="panel_%s-%s" class="tab-pane%s"><img src="loading.gif" align="top" />%s</div>' . "\n\t\t\t\t", $ChildTable, $ChildLookupField, ($tabPanels ? '' : ' active'), $Translation['Loading ...']);
						$tabLoaders .= sprintf('post("parent-children.php", { ChildTable: "%s", ChildLookupField: "%s", SelectedID: "%s", Page: 1, SortBy: "", SortDirection: "", Operation: "get-records" }, "panel_%s-%s");' . "\n\t\t\t\t", $ChildTable, $ChildLookupField, addslashes($SelectedID), $ChildTable, $ChildLookupField);
					}
				}
			}

			if(!$tabLabels){ die('<!-- no children of current parent table are accessible to current user -->'); }
			?>
			<div id="children-tabs">
				<ul class="nav nav-tabs">
					<?php echo $tabLabels; ?>
				</ul>
				<span id="pc-loading"></span>
			</div>
			<div class="tab-content"><?php echo $tabPanels; ?></div>

			<script>
				$j(function(){
					/* for iOS, avoid loading child tabs in modals */
					var iOS = /(iPad|iPhone|iPod)/g.test(navigator.userAgent);
					var embedded = ($j('.navbar').length == 0);
					if(iOS && embedded){
						$j('#children-tabs').next('.tab-content').remove();
						$j('#children-tabs').remove();
						return;
					}

					/* ajax loading of each tab's contents */
					<?php echo $tabLoaders; ?>
				})
			</script>
			<?php
			break;

		/************************************************/
		case 'show-children-printable':
			/* populate HTML and JS content with children buttons */
			$tabLabels = $tabPanels = $tabLoaders = '';
			foreach($userPCConfig as $ChildTable => $childLookups){
				foreach($childLookups as $ChildLookupField => $childConfig){
					if($childConfig['parent-table'] == $ParentTable){
						$TableIcon = ($childConfig['table-icon'] ? "<img src=\"{$childConfig['table-icon']}\" border=\"0\" />" : '');
						$tabLabels .= sprintf('<button type="button" class="btn btn-default" data-target="#panel_%s-%s" id="tab_%s-%s" data-toggle="collapse">%s %s</button>' . "\n\t\t\t\t\t", $ChildTable, $ChildLookupField, $ChildTable, $ChildLookupField, $TableIcon, $childConfig['tab-label']);
						$tabPanels .= sprintf('<div id="panel_%s-%s" class="collapse"><img src="loading.gif" align="top" />%s</div>' . "\n\t\t\t\t", $ChildTable, $ChildLookupField, $Translation['Loading ...']);
						$tabLoaders .= sprintf('post("parent-children.php", { ChildTable: "%s", ChildLookupField: "%s", SelectedID: "%s", Page: 1, SortBy: "", SortDirection: "", Operation: "get-records-printable" }, "panel_%s-%s");' . "\n\t\t\t\t", $ChildTable, $ChildLookupField, addslashes($SelectedID), $ChildTable, $ChildLookupField);
					}
				}
			}

			if(!$tabLabels){ die('<!-- no children of current parent table are accessible to current user -->'); }
			?>
			<div id="children-tabs" class="hidden-print">
				<div class="btn-group btn-group-lg">
					<?php echo $tabLabels; ?>
				</div>
				<span id="pc-loading"></span>
			</div>
			<div class="vspacer-lg"><?php echo $tabPanels; ?></div>

			<script>
				$j(function(){
					/* for iOS, avoid loading child tabs in modals */
					var iOS = /(iPad|iPhone|iPod)/g.test(navigator.userAgent);
					var embedded = ($j('.navbar').length == 0);
					if(iOS && embedded){
						$j('#children-tabs').next('.tab-content').remove();
						$j('#children-tabs').remove();
						return;
					}

					/* ajax loading of each tab's contents */
					<?php echo $tabLoaders; ?>
				})
			</script>
			<?php
			break;

		/************************************************/
		case 'get-records-printable':
		default: /* default is 'get-records' */

			if($Operation == 'get-records-printable'){
				$userPCConfig[$ChildTable][$ChildLookupField]['records-per-page'] = 2000;
			}

			// build the user permissions limiter
			$permissionsWhere = $permissionsJoin = '';
			$permChild = getTablePermissions($ChildTable);
			if($permChild[2] == 1){ // user can view only his own records
				$permissionsWhere = "`$ChildTable`.`{$userPCConfig[$ChildTable][$ChildLookupField]['child-primary-key']}`=`membership_userrecords`.`pkValue` AND `membership_userrecords`.`tableName`='$ChildTable' AND LCASE(`membership_userrecords`.`memberID`)='".getLoggedMemberID()."'";
			}elseif($permChild[2] == 2){ // user can view only his group's records
				$permissionsWhere = "`$ChildTable`.`{$userPCConfig[$ChildTable][$ChildLookupField]['child-primary-key']}`=`membership_userrecords`.`pkValue` AND `membership_userrecords`.`tableName`='$ChildTable' AND `membership_userrecords`.`groupID`='".getLoggedGroupID()."'";
			}elseif($permChild[2] == 3){ // user can view all records
				/* that's the only case remaining ... no need to modify the query in this case */
			}
			$permissionsJoin = ($permissionsWhere ? ", `membership_userrecords`" : '');

			// build the count query
			$forcedWhere = $userPCConfig[$ChildTable][$ChildLookupField]['forced-where'];
			$query = 
				preg_replace('/^select .* from /i', 'SELECT count(1) FROM ', $userPCConfig[$ChildTable][$ChildLookupField]['query']) .
				$permissionsJoin . " WHERE " .
				($permissionsWhere ? "( $permissionsWhere )" : "( 1=1 )") . " AND " .
				($forcedWhere ? "( $forcedWhere )" : "( 2=2 )") . " AND " .
				"`$ChildTable`.`$ChildLookupField`='" . makeSafe($SelectedID) . "'";
			$totalMatches = sqlValue($query);

			// make sure $Page is <= max pages
			$maxPage = ceil($totalMatches / $userPCConfig[$ChildTable][$ChildLookupField]['records-per-page']);
			if($Page > $maxPage){ $Page = $maxPage; }

			// initiate output data array
			$data = array(
				'config' => $userPCConfig[$ChildTable][$ChildLookupField],
				'parameters' => array(
					'ChildTable' => $ChildTable,
					'ChildLookupField' => $ChildLookupField,
					'SelectedID' => $SelectedID,
					'Page' => $Page,
					'SortBy' => $SortBy,
					'SortDirection' => $SortDirection,
					'Operation' => $Operation
				),
				'records' => array(),
				'totalMatches' => $totalMatches
			);

			// build the data query
			if($totalMatches){ // if we have at least one record, proceed with fetching data
				$startRecord = $userPCConfig[$ChildTable][$ChildLookupField]['records-per-page'] * ($Page - 1);
				$data['query'] = 
					$userPCConfig[$ChildTable][$ChildLookupField]['query'] .
					$permissionsJoin . " WHERE " .
					($permissionsWhere ? "( $permissionsWhere )" : "( 1=1 )") . " AND " .
					($forcedWhere ? "( $forcedWhere )" : "( 2=2 )") . " AND " .
					"`$ChildTable`.`$ChildLookupField`='" . makeSafe($SelectedID) . "'" . 
					($SortBy !== false && $userPCConfig[$ChildTable][$ChildLookupField]['sortable-fields'][$SortBy] ? " ORDER BY {$userPCConfig[$ChildTable][$ChildLookupField]['sortable-fields'][$SortBy]} $SortDirection" : '') .
					" LIMIT $startRecord, {$userPCConfig[$ChildTable][$ChildLookupField]['records-per-page']}";
				$res = sql($data['query'], $eo);
				while($row = db_fetch_row($res)){
					$data['records'][$row[$userPCConfig[$ChildTable][$ChildLookupField]['child-primary-key-index']]] = $row;
				}
			}else{ // if no matching records
				$startRecord = 0;
			}

			if($Operation == 'get-records-printable'){
				$response = loadView($userPCConfig[$ChildTable][$ChildLookupField]['template-printable'], $data);
			}else{
				$response = loadView($userPCConfig[$ChildTable][$ChildLookupField]['template'], $data);
			}

			// change name space to ensure uniqueness
			$uniqueNameSpace = $ChildTable.ucfirst($ChildLookupField).'GetRecords';
			echo str_replace("{$ChildTable}GetChildrenRecordsList", $uniqueNameSpace, $response);
		/************************************************/
	}
