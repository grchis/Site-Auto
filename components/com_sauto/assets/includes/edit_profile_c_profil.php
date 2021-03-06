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

$img_path = JURI::base()."components".DS."com_sauto".DS."assets".DS."images".DS;
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$query = "SELECT * FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$profile = $db->loadObject();
$query = "SELECT * FROM #__users WHERE `id` = '".$uid."'";
$db->setQuery($query);
$pr_user = $db->loadObject();
$link_form = JRoute::_('index.php?option=com_sauto&view=editing_profile'); 
$check_fields= 0;
$total_fields = 7;
?>
<form action="<?php echo $link_form; ?>" method="post" enctype="multipart/form-data">
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_FORM_NAME'); ?>
	</div>
	<div>
		<input type="text" name="names" value="<?php echo $profile->fullname; ?>" class="sa_inputbox" />
	</div>
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_FORM_EMAIL'); ?>
	</div>
	<div>
		<input type="text" name="email" value="<?php echo $pr_user->email; ?>" class="sa_inputbox" />
	</div>
	
	<div class="sauto_form_label">
		<a onClick="toggle_visibility('change_pass');" class="sauto_ajax_link">
		<?php echo JText::_('SAUTO_FORM_CHANGE_PASSWORD'); ?>
		</a>	
	</div>
	<div id="change_pass" style="display:none;">
		<div class="sauto_form_label">
			<?php echo JText::_('SAUTO_FORM_NEW_PASS1'); ?>
		</div>
		<div>
		<input type="password" name="new_pass1" value="" class="sa_inputbox" />
		</div>
		<div class="sauto_form_label">
			<?php echo JText::_('SAUTO_FORM_NEW_PASS2'); ?>
		</div>
		<div>
		<input type="password" name="new_pass2" value="" class="sa_inputbox" />
		</div>
		
	</div>
		
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_FORM_PHONE'); ?>
	</div>
	<div>
		<input type="text" name="phone" value="<?php echo $profile->telefon; ?>" class="sa_inputbox" />
	</div>
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_FORM_REGION'); ?>
	</div>
	<div>
		<select name="judet" onChange="javascript:aratOrase(this.value)" class="sa_select">
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
	</div>
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_FORM_CITY'); ?>
	</div>
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
	
	
				
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_FORM_ADRESA'); ?>
	</div>
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
	<div>
		<input type="submit" value="<?php echo JText::_('SAUTO_FORM_UPDATE_PROFILE_BUTTON'); ?>" class="sauto_button validate" />
	</div>
	
</form>
<br /><br />



