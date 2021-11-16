<?php


	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/student_details.php");
	include("$currDir/student_details_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('student_details');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "student_details";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`student_details`.`id`" => "id",
		"`student_details`.`full_name`" => "full_name",
		"IF(    CHAR_LENGTH(`schools1`.`name`), CONCAT_WS('',   `schools1`.`name`), '') /* School */" => "school",
		"IF(    CHAR_LENGTH(`departments1`.`name`), CONCAT_WS('',   `departments1`.`name`), '') /* Department */" => "department",
		"`student_details`.`year_of_study`" => "year_of_study",
		"`student_details`.`reg_no`" => "reg_no"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`student_details`.`id`',
		2 => 2,
		3 => '`schools1`.`name`',
		4 => '`departments1`.`name`',
		5 => 5,
		6 => 6
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`student_details`.`id`" => "id",
		"`student_details`.`full_name`" => "full_name",
		"IF(    CHAR_LENGTH(`schools1`.`name`), CONCAT_WS('',   `schools1`.`name`), '') /* School */" => "school",
		"IF(    CHAR_LENGTH(`departments1`.`name`), CONCAT_WS('',   `departments1`.`name`), '') /* Department */" => "department",
		"`student_details`.`year_of_study`" => "year_of_study",
		"`student_details`.`reg_no`" => "reg_no"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`student_details`.`id`" => "ID",
		"`student_details`.`full_name`" => "Full name",
		"IF(    CHAR_LENGTH(`schools1`.`name`), CONCAT_WS('',   `schools1`.`name`), '') /* School */" => "School",
		"IF(    CHAR_LENGTH(`departments1`.`name`), CONCAT_WS('',   `departments1`.`name`), '') /* Department */" => "Department",
		"`student_details`.`year_of_study`" => "Year of study",
		"`student_details`.`reg_no`" => "Reg no"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`student_details`.`id`" => "id",
		"`student_details`.`full_name`" => "full_name",
		"IF(    CHAR_LENGTH(`schools1`.`name`), CONCAT_WS('',   `schools1`.`name`), '') /* School */" => "school",
		"IF(    CHAR_LENGTH(`departments1`.`name`), CONCAT_WS('',   `departments1`.`name`), '') /* Department */" => "department",
		"`student_details`.`year_of_study`" => "year_of_study",
		"`student_details`.`reg_no`" => "reg_no"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array(  'school' => 'School', 'department' => 'Department');

	$x->QueryFrom = "`student_details` LEFT JOIN `schools` as schools1 ON `schools1`.`id`=`student_details`.`school` LEFT JOIN `departments` as departments1 ON `departments1`.`id`=`student_details`.`department` ";
	$x->QueryWhere = '';
	$x->QueryOrder = '';

	$x->AllowSelection = 1;
	$x->HideTableView = ($perm[2]==0 ? 1 : 0);
	$x->AllowDelete = $perm[4];
	$x->AllowMassDelete = true;
	$x->AllowInsert = $perm[1];
	$x->AllowUpdate = $perm[3];
	$x->SeparateDV = 1;
	$x->AllowDeleteOfParents = 0;
	$x->AllowFilters = 1;
	$x->AllowSavingFilters = 1;
	$x->AllowSorting = 1;
	$x->AllowNavigation = 1;
	$x->AllowPrinting = 1;
	$x->AllowCSV = 1;
	$x->RecordsPerPage = 100;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation["quick search"];
	$x->ScriptFileName = "student_details_view.php";
	$x->RedirectAfterInsert = "student_details_view.php?SelectedID=#ID#";
	$x->TableTitle = "Student details";
	$x->TableIcon = "resources/table_icons/administrator.png";
	$x->PrimaryKey = "`student_details`.`id`";

	$x->ColWidth   = array(  150, 150, 150, 150, 150);
	$x->ColCaption = array("Full name", "School", "Department", "Year of study", "Reg no");
	$x->ColFieldName = array('full_name', 'school', 'department', 'year_of_study', 'reg_no');
	$x->ColNumber  = array(2, 3, 4, 5, 6);

	// template paths below are based on the app main directory
	$x->Template = 'templates/student_details_templateTV.html';
	$x->SelectedTemplate = 'templates/student_details_templateTVS.html';
	$x->TemplateDV = 'templates/student_details_templateDV.html';
	$x->TemplateDVP = 'templates/student_details_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `student_details`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='student_details' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `student_details`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='student_details' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`student_details`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: student_details_init
	$render=TRUE;
	if(function_exists('student_details_init')){
		$args=array();
		$render=student_details_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: student_details_header
	$headerCode='';
	if(function_exists('student_details_header')){
		$args=array();
		$headerCode=student_details_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: student_details_footer
	$footerCode='';
	if(function_exists('student_details_footer')){
		$args=array();
		$footerCode=student_details_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>