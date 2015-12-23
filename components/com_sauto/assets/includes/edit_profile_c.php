<?php
/**
 * @package    sauto
 * @subpackage Views
 * @author     Dacian Strain {@link http://shop.elbase.eu}
 * @author     Created on 17-Nov-2013
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');
require("tab_js.php");
$document->addScriptDeclaration ($js_code_tab);

//$jslink = JUri::base().'components/com_sauto/assets/script/tabtastic.js';
$jslink = JUri::base().'components/com_sauto/assets/script/domtab.js';
$document->addScript($jslink);



$type =& JRequest::getVar( 'type', '', 'get', 'string' );
$link = JRoute::_('index.php?option=com_sauto&view=edit_profile');
$width = 'style="width:800px;"';
?>

<table class="sa_table_class" id="m_table">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
<div class="domtab">
  <ul class="domtabs">
    <li><a href="#t1"><?php echo JText::_('SAUTO_TAB_PROFILE'); ?></a></li>
    <li><a href="#t2"><?php echo JText::_('SAUTO_TAB_PROFILE_2'); ?></a></li>
  </ul>
  <div class="sa_border_tab">
    <h2 class="tabset_label"><a name="t1" id="t1"><?php echo JText::_('SAUTO_TAB_PROFILE'); ?></a></h2>
   <?php require("edit_profile_c_profil.php"); ?>
  </div>
  <div class="sa_border_tab">
    <h2 class="tabset_label"><a name="t2" id="t2"><?php echo JText::_('SAUTO_TAB_PROFILE_2'); ?></a> 	</h2>
   <?php require("edit_profile_c_profil2.php"); ?>
  </div>
</div>

<?php /*		
<ul class="tabset_tabs">
   <li><a href="<?php echo $link; ?>#tab1" <?php if ($type == '') { echo 'class="active"';} ?>>
		<?php echo JText::_('SAUTO_TAB_PROFILE'); ?></a>
	</li>
	<li><a href="<?php echo $link; ?>#tab2" <?php if ($type == 'pr') { echo 'class="active"';} ?>>
		<?php echo JText::_('SAUTO_TAB_PROFILE_2'); ?></a>
	</li>
</ul>

<div id="tab1" class="tabset_content">
   <h2 class="tabset_label"><?php echo JText::_('SAUTO_TAB_PROFILE'); ?></h2>
   <?php require("edit_profile_c_profil.php"); ?>
</div>

<div id="tab2" class="tabset_content">
   <h2 class="tabset_label"><?php echo JText::_('SAUTO_TAB_PROFILE_2'); ?></h2>
   <?php require("edit_profile_c_profil2.php"); ?>
</div>
*/ ?>
</td>
		<td class="sa_table_cell" valign="top" align="right">
			<div style="float:right;" class="sa_allrequest_r">
			<?php
			//incarcam module in functie de pagina accesata
			echo '<div class="sa_reclama_right">';
				$pozitionare = 'l';
				$categ = '';
				echo showAds($pozitionare, $categ);
			echo '</div>';
			//echo '<div>'.$show_side_content.'</div>';	
		?>
		
			</div>
		</td>
	</tr>
</table>
<?php
################
?>

<div id="m_visitors" style="background-color:#F9F9F9">

	<div class = "m_header" style="width: 100%; height: 100px; background-color: #509EFF">
	</div>
	<div class = "main-container">
	<form action="<?php echo $link_form; ?>" method="post" enctype="multipart/form-data" style="width: 80%;">
			<fieldset style="margin-bottom: 15px;">
				<p> Nume si prenume: </p>
				<input type="text" name="names" value="<?php echo $profile->fullname; ?>" class="sa_inputbox"style="width: 100%;" />
				
				<p> Email: </p>
			   <input type="text" name="email" value="<?php echo $pr_user->email; ?>" class="sa_inputbox"  style="width: 100%;" />
				
				<p> Parola: </p>
				<input type="password" name="new_pass1" value="" class="sa_inputbox" style="width: 100%;" />			
				
				<p> Repetare Parola: </p>
				<input type="password" name="new_pass2" value="" class="sa_inputbox" style="width: 100%;" />			
			
				<p> Telefon: </p>
				<input type="text" name="phone" value="<?php echo $profile->telefon; ?>" class="sa_inputbox"style="width: 100%;" />
				
				<p> Judet: </p>	
				<select name="judet" onChange="javascript:aratOrase(this.value)" class="sa_select" style="width: 100%;">
						<?php			
						$query = "SELECT * FROM #__sa_judete ORDER BY `judet` ASC";
						$db->setQuery($query);
						$judete = $db->loadObjectList();
							foreach ($judete as $j) {
								echo '<option id="'.$j->id.'"';
									if ($j->id == $profile->judet) { echo ' selected '; }
								echo '>'.$j->judet.'</option>';
							}
						?>
				</select>		
				
				<p> Localitate </p>
				<div>
					<?php 
					$query = "SELECT * FROM #__sa_localitati WHERE `jid` = '".$profile->judet."' AND `published` = '1'"; 
					$db->setQuery($query);
					$citys = $db->loadObjectList();
					?>
				<div id="sa_city">
								<select name="city" class="sa_select">
										<option value=""><?php echo JText::_('SAUTO_FORM_SELECT_CITY'); ?></option>
										<?php
										foreach ($citys as $c) {
											echo '<option value="'.$c->id.'"';
												if ($c->id == $profile->localitate) { echo ' selected ';}
											echo '>'.$c->localitate.'</option>';
										}
										?>
								</select>
				</div>
				</div>
		
			<p> Adresa </p>
			<div>
				<?php
					$editor =& JFactory::getEditor();
					echo $editor->display('adresa', $profile->adresa, '500', '150', '60', '20', false);
					?>
	</div>
	<br /><br /><br />
	 <div class="sauto_form_label">
		<?php echo JText::_('SAUTO_FORM_ZIP_CODE'); ?>
	</div>
	<div>
		<input type="text" name="cod_postal" value="<?php echo $profile->cod_postal; ?>" class="sa_inputbox" />
	</div>	
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_FORM_MEMBER_SINCE'); ?>
	</div>
	<div>
		<?php echo $pr_user->registerDate; ?>
	</div>	
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_FORM_AVATAR'); ?>
	</div>
	<div>
		<?php
		if ($profile->poza == '') {
			//fara avatar
			echo JText::_('SAUTO_FORM_NO_AVATAR_ADDED');
		} else {
			//avatar
			$path = JUri::base().'components/com_sauto/assets/users/'.$uid.'/';
			echo '<img src="'.$path.$profile->poza.'" width="150" border="0" />';
		}
		?>
	</div>
	
	<div class="sauto_form_label"><?php echo JText::_('SAUTO_FORM_NEW_AVATAR'); ?></div>
	<div>
		<input type="file" name="image" value="" />
	</div>
	<?php if ($profile->poza != '') { ?>
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_FORM_DELETE_AVATAR').' '; ?>
		<input type="checkbox" name="delete_avatar" value="1" />
	</div>
	<?php } ?>
	<br />
	<?php
	if ($profile->fullname != '') { $check_fields = $check_fields+1; }
	if ($profile->telefon != '') { $check_fields = $check_fields+1; }
	if ($profile->judet != '') { $check_fields = $check_fields+1; }
	if ($profile->localitate != '') { $check_fields = $check_fields+1; }
	if ($profile->adresa != '') { $check_fields = $check_fields+1; }
	if ($profile->cod_postal != '') { $check_fields = $check_fields+1; }
	if ($profile->poza != '') { $check_fields = $check_fields+1; }
	
	//calculare
	$total = ($check_fields*100)/$total_fields;
	echo JText::_('SAUTO_PROFILE_COMPLETED_PERCENT').' '.round($total).'%';
	?>
	<div class="sauto_form_label">
		<a onClick="toggle_visibility('delete_cont');" class="sauto_ajax_link">
			<?php echo JText::_('SAUTO_DELETE_ACCOUNT'); ?>
		</a>
	</div>
	<div id="delete_cont" style="display:none;">
		<input type="checkbox" name="delete_cont" value="1" />
		<?php echo JText::_('SAUTO_DELETE_THIS_ACCOUNT'); ?>
		<div class="sauto_warning"><?php echo JText::_('SAUTO_DELETE_ACCOUNT_WARNING'); ?></div>
	</div>
	<br />
	<br />	
		</fieldset>
		<input type="submit"  value="Actualizare profil" class="sauto_button validate" style="width:100%;">
		</form>
	</div>
</div>
<br /><br />
<script type="text/javascript">
	window.jQuery || document.write('<script src="js/jquery-1.7.2.min.js"><\/script>');
	var isMobile = navigator.userAgent.contains('Mobile');
	if (!isMobile) {
		document.getElementById('m_visitors').remove();
	} else {
		document.getElementById('m_table').remove();
		document.getElementById('gkTopBar').remove();
		document.getElementById('side_bar').style.display = "none";
		document.getElementById('content9').style.all = "none";
		document.write('<style type="text/css" >#content9{width: 100% !important;' + 
						'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
						'width: 100% !important;}</style>'
		);
	}
</script>

