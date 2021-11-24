<?php


	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/notices.php");
	include("$currDir/notices_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('notices');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "notices";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`notices`.`id`" => "id",
		"`notices`.`notice`" => "notice",
		"IF(    CHAR_LENGTH(`schools1`.`name`), CONCAT_WS('',   `schools1`.`name`), '') /* School */" => "school",
		"IF(    CHAR_LENGTH(`departments1`.`name`), CONCAT_WS('',   `departments1`.`name`), '') /* Department */" => "department",
		"`notices`.`year_of_study`" => "year_of_study",
		"if(`notices`.`date`,date_format(`notices`.`date`,'%m/%d/%Y'),'')" => "date"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`notices`.`id`',
		2 => 2,
		3 => '`schools1`.`name`',
		4 => '`departments1`.`name`',
		5 => 5,
		6 => '`notices`.`date`'
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`notices`.`id`" => "id",
		"`notices`.`notice`" => "notice",
		"IF(    CHAR_LENGTH(`schools1`.`name`), CONCAT_WS('',   `schools1`.`name`), '') /* School */" => "school",
		"IF(    CHAR_LENGTH(`departments1`.`name`), CONCAT_WS('',   `departments1`.`name`), '') /* Department */" => "department",
		"`notices`.`year_of_study`" => "year_of_study",
		"if(`notices`.`date`,date_format(`notices`.`date`,'%m/%d/%Y'),'')" => "date"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`notices`.`id`" => "ID",
		"`notices`.`notice`" => "Notice",
		"IF(    CHAR_LENGTH(`schools1`.`name`), CONCAT_WS('',   `schools1`.`name`), '') /* School */" => "School",
		"IF(    CHAR_LENGTH(`departments1`.`name`), CONCAT_WS('',   `departments1`.`name`), '') /* Department */" => "Department",
		"`notices`.`year_of_study`" => "Year of study",
		"`notices`.`date`" => "Date"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`notices`.`id`" => "id",
		"`notices`.`notice`" => "notice",
		"IF(    CHAR_LENGTH(`schools1`.`name`), CONCAT_WS('',   `schools1`.`name`), '') /* School */" => "school",
		"IF(    CHAR_LENGTH(`departments1`.`name`), CONCAT_WS('',   `departments1`.`name`), '') /* Department */" => "department",
		"`notices`.`year_of_study`" => "year_of_study",
		"if(`notices`.`date`,date_format(`notices`.`date`,'%m/%d/%Y'),'')" => "date"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array(  'school' => 'School', 'department' => 'Department');

	$x->QueryFrom = "`notices` LEFT JOIN `schools` as schools1 ON `schools1`.`id`=`notices`.`school` LEFT JOIN `departments` as departments1 ON `departments1`.`id`=`notices`.`department` ";
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
	$x->RecordsPerPage = 10;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation["quick search"];
	$x->ScriptFileName = "notices_view.php";
	$x->RedirectAfterInsert = "notices_view.php?SelectedID=#ID#";
	$x->TableTitle = "Notices";
	$x->TableIcon = "resources/table_icons/clipboard_empty.png";
	$x->PrimaryKey = "`notices`.`id`";

	$x->ColWidth   = array(  150, 150, 150, 150, 150);
	$x->ColCaption = array("Notice", "School", "Department", "Year of study", "Date");
	$x->ColFieldName = array('notice', 'school', 'department', 'year_of_study', 'date');
	$x->ColNumber  = array(2, 3, 4, 5, 6);

	// template paths below are based on the app main directory
	$x->Template = 'templates/notices_templateTV.html';
	$x->SelectedTemplate = 'templates/notices_templateTVS.html';
	$x->TemplateDV = 'templates/notices_templateDV.html';
	$x->TemplateDVP = 'templates/notices_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `notices`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='notices' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `notices`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='notices' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`notices`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: notices_init
	$render=TRUE;
	if(function_exists('notices_init')){
		$args=array();
		$render=notices_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: notices_header
	$headerCode='';
	if(function_exists('notices_header')){
		$args=array();
		$headerCode=notices_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: notices_footer
	$footerCode='';
	if(function_exists('notices_footer')){
		$args=array();
		$footerCode=notices_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>