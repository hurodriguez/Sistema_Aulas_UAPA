<?php

// Data functions (insert, update, delete, form) for table Aulas

// This script and data application were generated by AppGini 5.76
// Download AppGini for free from https://bigprof.com/appgini/download/

function Aulas_insert(){
	global $Translation;

	// mm: can member insert record?
	$arrPerm=getTablePermissions('Aulas');
	if(!$arrPerm[1]){
		return false;
	}

	$data['Nombre'] = makeSafe($_REQUEST['Nombre']);
		if($data['Nombre'] == empty_lookup_value){ $data['Nombre'] = ''; }
	$data['numero'] = makeSafe($_REQUEST['numero']);
		if($data['numero'] == empty_lookup_value){ $data['numero'] = ''; }
	$data['Campus'] = makeSafe($_REQUEST['Campus']);
		if($data['Campus'] == empty_lookup_value){ $data['Campus'] = ''; }
	$data['mapa'] = makeSafe($_REQUEST['mapa']);
		if($data['mapa'] == empty_lookup_value){ $data['mapa'] = ''; }

	// hook: Aulas_before_insert
	if(function_exists('Aulas_before_insert')){
		$args=array();
		if(!Aulas_before_insert($data, getMemberInfo(), $args)){ return false; }
	}

	$o = array('silentErrors' => true);
	sql('insert into `Aulas` set       `Nombre`=' . (($data['Nombre'] !== '' && $data['Nombre'] !== NULL) ? "'{$data['Nombre']}'" : 'NULL') . ', `numero`=' . (($data['numero'] !== '' && $data['numero'] !== NULL) ? "'{$data['numero']}'" : 'NULL') . ', `Campus`=' . (($data['Campus'] !== '' && $data['Campus'] !== NULL) ? "'{$data['Campus']}'" : 'NULL') . ', `mapa`=' . (($data['mapa'] !== '' && $data['mapa'] !== NULL) ? "'{$data['mapa']}'" : 'NULL'), $o);
	if($o['error']!=''){
		echo $o['error'];
		echo "<a href=\"Aulas_view.php?addNew_x=1\">{$Translation['< back']}</a>";
		exit;
	}

	$recID = db_insert_id(db_link());

	// hook: Aulas_after_insert
	if(function_exists('Aulas_after_insert')){
		$res = sql("select * from `Aulas` where `id`='" . makeSafe($recID, false) . "' limit 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = makeSafe($recID, false);
		$args=array();
		if(!Aulas_after_insert($data, getMemberInfo(), $args)){ return $recID; }
	}

	// mm: save ownership data
	set_record_owner('Aulas', $recID, getLoggedMemberID());

	return $recID;
}

function Aulas_delete($selected_id, $AllowDeleteOfParents=false, $skipChecks=false){
	// insure referential integrity ...
	global $Translation;
	$selected_id=makeSafe($selected_id);

	// mm: can member delete record?
	$arrPerm=getTablePermissions('Aulas');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='Aulas' and pkValue='$selected_id'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='Aulas' and pkValue='$selected_id'");
	if(($arrPerm[4]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[4]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[4]==3){ // allow delete?
		// delete allowed, so continue ...
	}else{
		return $Translation['You don\'t have enough permissions to delete this record'];
	}

	// hook: Aulas_before_delete
	if(function_exists('Aulas_before_delete')){
		$args=array();
		if(!Aulas_before_delete($selected_id, $skipChecks, getMemberInfo(), $args))
			return $Translation['Couldn\'t delete this record'];
	}

	sql("delete from `Aulas` where `id`='$selected_id'", $eo);

	// hook: Aulas_after_delete
	if(function_exists('Aulas_after_delete')){
		$args=array();
		Aulas_after_delete($selected_id, getMemberInfo(), $args);
	}

	// mm: delete ownership data
	sql("delete from membership_userrecords where tableName='Aulas' and pkValue='$selected_id'", $eo);
}

function Aulas_update($selected_id){
	global $Translation;

	// mm: can member edit record?
	$arrPerm=getTablePermissions('Aulas');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='Aulas' and pkValue='".makeSafe($selected_id)."'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='Aulas' and pkValue='".makeSafe($selected_id)."'");
	if(($arrPerm[3]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[3]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[3]==3){ // allow update?
		// update allowed, so continue ...
	}else{
		return false;
	}

	$data['Nombre'] = makeSafe($_REQUEST['Nombre']);
		if($data['Nombre'] == empty_lookup_value){ $data['Nombre'] = ''; }
	$data['numero'] = makeSafe($_REQUEST['numero']);
		if($data['numero'] == empty_lookup_value){ $data['numero'] = ''; }
	$data['Campus'] = makeSafe($_REQUEST['Campus']);
		if($data['Campus'] == empty_lookup_value){ $data['Campus'] = ''; }
	$data['mapa'] = makeSafe($_REQUEST['mapa']);
		if($data['mapa'] == empty_lookup_value){ $data['mapa'] = ''; }
	$data['selectedID']=makeSafe($selected_id);

	// hook: Aulas_before_update
	if(function_exists('Aulas_before_update')){
		$args=array();
		if(!Aulas_before_update($data, getMemberInfo(), $args)){ return false; }
	}

	$o=array('silentErrors' => true);
	sql('update `Aulas` set       `Nombre`=' . (($data['Nombre'] !== '' && $data['Nombre'] !== NULL) ? "'{$data['Nombre']}'" : 'NULL') . ', `numero`=' . (($data['numero'] !== '' && $data['numero'] !== NULL) ? "'{$data['numero']}'" : 'NULL') . ', `Campus`=' . (($data['Campus'] !== '' && $data['Campus'] !== NULL) ? "'{$data['Campus']}'" : 'NULL') . ', `mapa`=' . (($data['mapa'] !== '' && $data['mapa'] !== NULL) ? "'{$data['mapa']}'" : 'NULL') . " where `id`='".makeSafe($selected_id)."'", $o);
	if($o['error']!=''){
		echo $o['error'];
		echo '<a href="Aulas_view.php?SelectedID='.urlencode($selected_id)."\">{$Translation['< back']}</a>";
		exit;
	}


	// hook: Aulas_after_update
	if(function_exists('Aulas_after_update')){
		$res = sql("SELECT * FROM `Aulas` WHERE `id`='{$data['selectedID']}' LIMIT 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = $data['id'];
		$args = array();
		if(!Aulas_after_update($data, getMemberInfo(), $args)){ return; }
	}

	// mm: update ownership data
	sql("update membership_userrecords set dateUpdated='".time()."' where tableName='Aulas' and pkValue='".makeSafe($selected_id)."'", $eo);

}

function Aulas_form($selected_id = '', $AllowUpdate = 1, $AllowInsert = 1, $AllowDelete = 1, $ShowCancel = 0, $TemplateDV = '', $TemplateDVP = ''){
	// function to return an editable form for a table records
	// and fill it with data of record whose ID is $selected_id. If $selected_id
	// is empty, an empty form is shown, with only an 'Add New'
	// button displayed.

	global $Translation;

	// mm: get table permissions
	$arrPerm=getTablePermissions('Aulas');
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
	// combobox: Campus
	$combo_Campus = new Combo;
	$combo_Campus->ListType = 0;
	$combo_Campus->MultipleSeparator = ', ';
	$combo_Campus->ListBoxHeight = 10;
	$combo_Campus->RadiosPerLine = 1;
	if(is_file(dirname(__FILE__).'/hooks/Aulas.Campus.csv')){
		$Campus_data = addslashes(implode('', @file(dirname(__FILE__).'/hooks/Aulas.Campus.csv')));
		$combo_Campus->ListItem = explode('||', entitiesToUTF8(convertLegacyOptions($Campus_data)));
		$combo_Campus->ListData = $combo_Campus->ListItem;
	}else{
		$combo_Campus->ListItem = explode('||', entitiesToUTF8(convertLegacyOptions("Santiago;;Nagua;;Santo Domingo")));
		$combo_Campus->ListData = $combo_Campus->ListItem;
	}
	$combo_Campus->SelectName = 'Campus';

	if($selected_id){
		// mm: check member permissions
		if(!$arrPerm[2]){
			return "";
		}
		// mm: who is the owner?
		$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='Aulas' and pkValue='".makeSafe($selected_id)."'");
		$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='Aulas' and pkValue='".makeSafe($selected_id)."'");
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

		$res = sql("select * from `Aulas` where `id`='".makeSafe($selected_id)."'", $eo);
		if(!($row = db_fetch_array($res))){
			return error_message($Translation['No records found'], 'Aulas_view.php', false);
		}
		$urow = $row; /* unsanitized data */
		$hc = new CI_Input();
		$row = $hc->xss_clean($row); /* sanitize data */
		$combo_Campus->SelectedData = $row['Campus'];
	}else{
		$combo_Campus->SelectedText = ( $_REQUEST['FilterField'][1]=='4' && $_REQUEST['FilterOperator'][1]=='<=>' ? (get_magic_quotes_gpc() ? stripslashes($_REQUEST['FilterValue'][1]) : $_REQUEST['FilterValue'][1]) : "");
	}
	$combo_Campus->Render();

	// code for template based detail view forms

	// open the detail view template
	if($dvprint){
		$template_file = is_file("./{$TemplateDVP}") ? "./{$TemplateDVP}" : './templates/Aulas_templateDVP.html';
		$templateCode = @file_get_contents($template_file);
	}else{
		$template_file = is_file("./{$TemplateDV}") ? "./{$TemplateDV}" : './templates/Aulas_templateDV.html';
		$templateCode = @file_get_contents($template_file);
	}

	// process form title
	$templateCode = str_replace('<%%DETAIL_VIEW_TITLE%%>', 'Aulas', $templateCode);
	$templateCode = str_replace('<%%RND1%%>', $rnd1, $templateCode);
	$templateCode = str_replace('<%%EMBEDDED%%>', ($_REQUEST['Embedded'] ? 'Embedded=1' : ''), $templateCode);
	// process buttons
	if($AllowInsert){
		if(!$selected_id) $templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-success" id="insert" name="insert_x" value="1" onclick="return Aulas_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save New'] . '</button>', $templateCode);
		$templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="insert" name="insert_x" value="1" onclick="return Aulas_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save As Copy'] . '</button>', $templateCode);
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
		if(!$_REQUEST['Embedded']) $templateCode = str_replace('<%%DVPRINT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="dvprint" name="dvprint_x" value="1" onclick="$j(\'form\').eq(0).prop(\'novalidate\', true); document.myform.reset(); return true;" title="' . html_attr($Translation['Print Preview']) . '"><i class="glyphicon glyphicon-print"></i> ' . $Translation['Print Preview'] . '</button>', $templateCode);
		if($AllowUpdate){
			$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '<button type="submit" class="btn btn-success btn-lg" id="update" name="update_x" value="1" onclick="return Aulas_validateData();" title="' . html_attr($Translation['Save Changes']) . '"><i class="glyphicon glyphicon-ok"></i> ' . $Translation['Save Changes'] . '</button>', $templateCode);
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
		$jsReadOnly .= "\tjQuery('#Nombre').replaceWith('<div class=\"form-control-static\" id=\"Nombre\">' + (jQuery('#Nombre').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#numero').replaceWith('<div class=\"form-control-static\" id=\"numero\">' + (jQuery('#numero').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#Campus').replaceWith('<div class=\"form-control-static\" id=\"Campus\">' + (jQuery('#Campus').val() || '') + '</div>'); jQuery('#Campus-multi-selection-help').hide();\n";
		$jsReadOnly .= "\tjQuery('#mapa').replaceWith('<div class=\"form-control-static\" id=\"mapa\">' + (jQuery('#mapa').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('.select2-container').hide();\n";

		$noUploads = true;
	}elseif($AllowInsert){
		$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', true);"; // temporarily disable form change handler
			$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', false);"; // re-enable form change handler
	}

	// process combos
	$templateCode = str_replace('<%%COMBO(Campus)%%>', $combo_Campus->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(Campus)%%>', $combo_Campus->SelectedData, $templateCode);

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
	$templateCode = str_replace('<%%UPLOADFILE(Nombre)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(numero)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(Campus)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(mapa)%%>', '', $templateCode);

	// process values
	if($selected_id){
		if( $dvprint) $templateCode = str_replace('<%%VALUE(id)%%>', safe_html($urow['id']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(id)%%>', html_attr($row['id']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(id)%%>', urlencode($urow['id']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(Nombre)%%>', safe_html($urow['Nombre']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(Nombre)%%>', html_attr($row['Nombre']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(Nombre)%%>', urlencode($urow['Nombre']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(numero)%%>', safe_html($urow['numero']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(numero)%%>', html_attr($row['numero']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(numero)%%>', urlencode($urow['numero']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(Campus)%%>', safe_html($urow['Campus']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(Campus)%%>', html_attr($row['Campus']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(Campus)%%>', urlencode($urow['Campus']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(mapa)%%>', safe_html($urow['mapa']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(mapa)%%>', html_attr($row['mapa']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(mapa)%%>', urlencode($urow['mapa']), $templateCode);
	}else{
		$templateCode = str_replace('<%%VALUE(id)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(id)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(Nombre)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(Nombre)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(numero)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(numero)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(Campus)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(Campus)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(mapa)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(mapa)%%>', urlencode(''), $templateCode);
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
	$rdata = $jdata = get_defaults('Aulas');
	if($selected_id){
		$jdata = get_joined_record('Aulas', $selected_id);
		if($jdata === false) $jdata = get_defaults('Aulas');
		$rdata = $row;
	}
	$templateCode .= loadView('Aulas-ajax-cache', array('rdata' => $rdata, 'jdata' => $jdata));

	// hook: Aulas_dv
	if(function_exists('Aulas_dv')){
		$args=array();
		Aulas_dv(($selected_id ? $selected_id : FALSE), getMemberInfo(), $templateCode, $args);
	}

	return $templateCode;
}
?>