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
$db = JFactory::getDbo();
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
$link_form = JRoute::_('index.php?option=com_sauto&view=new_request&step=3'); 
$app =& JFactory::getApplication();
?>
<form action="<?php echo $link_form; ?>" method="post" enctype="multipart/form-data">
<div>
		<h2><?php echo JText::_('SAUTO_TIP_ANUNT').' '.JText::_('SAUTO_TIP_ANUNT_DETAIL5'); ?></h2>
	</div>
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_TITLU_ANUNT'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	<div>
		<input type="text" name="titlu_anunt" value="" class="sa_inputbox" />
	</div>


	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_FORM_REGION_PRELUARE'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	
	<div>
			<select name="judet" onChange="javascript:aratOrase(this.value)" class="sa_select">
				<option value=""><?php echo JText::_('SAUTO_FORM_SELECT_REGION'); ?></option>
						<?php
						
						$query = "SELECT * FROM #__sa_judete ORDER BY `judet` ASC";
						$db->setQuery($query);
						$judete = $db->loadObjectList();
						foreach ($judete as $j) {
							echo '<option id="'.$j->id.'">'.$j->judet.'</option>';
						}
						?>
						</select>
			</div>
			
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_FORM_CITY_PRELUARE'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	
	<div id="sa_city">
				<?php if ($id_judet == '') { ?>
				<select name="none" class="sa_select"><option value=""><?php echo JText::_('SAUTO_FORM_SELECT_CITY'); ?></option></select>
				<?php 
				} else { 
					//obtin localitatile judetului selectat
					$query = "SELECT * FROM #__sa_localitati WHERE `jid` = '".$id_judet."' AND `published` = '1' ORDER BY `localitate` ASC";
					$db->setQuery($query);
					$cities = $db->loadObjectList();
					echo '<select name="localitate" class="sa_select">';
						echo '<option value="">'.JText::_('SAUTO_FORM_SELECT_CITY').'</option>';
						foreach ($cities as $c) {
							echo '<option value="'.$c->id.'">'.$c->localitate.'</option>';
						}
					echo '</select>'; 
				} ?> 
				
			</div>
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_MARCA_AUTO'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	
	
	<div>
		<select name="marca" onChange="javascript:aratMarca(this.value)" class="sa_select">
			<option value=""><?php echo JText::_('SAUTO_ALEGE_MARCA'); ?></option>
			<?php
			$query = "SELECT * FROM #__sa_marca_auto WHERE `published` = '1' ORDER BY `marca_auto` ASC";
			$db->setQuery($query);
			$marc = $db->loadObjectList();
				foreach ($marc as $m) {
					echo '<option id="'.$m->id.'"';
						if ($m->id == $marca) { echo ' selected'; }
					echo '>'.$m->marca_auto.'</option>';
				}
			?>
		</select>
	</div>
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_ALEGE_MODELUL'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	
	<div id="sa_marca">
			<select name="model_auto" class="sa_select">
				<option value=""><?php echo JText::_('SAUTO_ALEGE_MODELUL_DORIT'); ?></option>
				<?php
				if ($marca != '') {
					$query = "SELECT * FROM #__sa_model_auto WHERE `mid` = '".$marca."' AND `published` = '1'";
					$db->setQuery($query);
					$modds = $db->loadObjectList();
					foreach ($modds as $m) {
						echo '<option value="'.$m->id.'"';
							if ($model_auto == $m->id) { echo ' selected'; }
						echo '>'.$m->model_auto.'</option>';
					}
				}
				?>
			</select>
		</div>
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_FORM_REGION_DESTINATIE'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	
	<div>
			<select name="judet_r" onChange="javascript:aratOrase3(this.value)" class="sa_select">
				<option value=""><?php echo JText::_('SAUTO_FORM_SELECT_REGION'); ?></option>
						<?php
						
						$query = "SELECT * FROM #__sa_judete ORDER BY `judet` ASC";
						$db->setQuery($query);
						$judete = $db->loadObjectList();
						foreach ($judete as $j) {
							echo '<option id="'.$j->id.'">'.$j->judet.'</option>';
						}
						?>
						</select>
			</div>
		
		
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_FORM_CITY_DESTINATIE'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	
	<div id="sa_city2">
				<?php
					//obtin localitatile judetului selectat
					$query = "SELECT * FROM #__sa_localitati WHERE `jid` = '".$id_judet."' AND `published` = '1' ORDER BY `localitate` ASC";
					$db->setQuery($query);
					$cities = $db->loadObjectList();
					echo '<select name="localitate_r" class="sa_select">';
						echo '<option value="">'.JText::_('SAUTO_FORM_SELECT_CITY').'</option>';
						foreach ($cities as $c) {
							echo '<option value="'.$c->id.'">'.$c->localitate.'</option>';
						}
					echo '</select>'; 
				?> 
				
			</div>
	
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_ANUNT'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	<div>
			<?php
			$editor =& JFactory::getEditor();
			echo $editor->display('anunt5', '', '500', '150', '60', '20', false);
			?>
			</div>
			
	<div class="sauto_form_label sa_obligatoriu">
		<?php echo JText::_('SAUTO_CAMPURI_OBLIGATORII'); ?>
	</div>
	
	<br /><br /><br />
	<input type="hidden" name="request" value="5" />
	<div>
		<input type="submit" value="<?php echo JText::_('SAUTO_ADD_ANUNT_BUTTON'); ?>"  class="sauto_button" />
	</div>
</form>
