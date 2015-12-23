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
$link_form = JRoute::_('index.php?option=com_sauto&view=editing'); 
$app =& JFactory::getApplication();

$id =& JRequest::getVar( 'anunt_id', '', 'post', 'string' );

$query = "SELECT * FROM #__sa_anunturi WHERE `id` = '".$id."'";
$db->setQuery($query);
$rezult = $db->loadObject();
$image_path = JURI::base()."components/com_sauto/assets/users/".$uid."/";
?>
<form action="<?php echo $link_form; ?>" method="post" enctype="multipart/form-data">
<div>
		<h2><?php echo JText::_('SAUTO_TIP_ANUNT').' '.JText::_('SAUTO_TIP_ANUNT_DETAIL6'); ?></h2>
	</div>
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_TITLU_ANUNT'); ?>
	</div>
	<div>
		<input type="text" name="titlu_anunt" value="<?php echo $rezult->titlu_anunt; ?>" class="sa_inputbox" />
	</div>
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_MARCA_AUTO'); ?>
	</div>
	
	
	<div>
		<select name="marca" onChange="javascript:aratMarca(this.value)">
			<option value=""><?php echo JText::_('SAUTO_ALEGE_MARCA'); ?></option>
			<?php
			$query = "SELECT * FROM #__sa_marca_auto ORDER BY `marca_auto` ASC";
			$db->setQuery($query);
			$marc = $db->loadObjectList();
				foreach ($marc as $m) {
					echo '<option id="'.$m->id.'"';
						if ($m->id == $rezult->marca_auto) { echo ' selected'; }
					echo '>'.$m->marca_auto.'</option>';
				}
			?>
		</select>
	</div>
					
	<div class="sauto_form_label">
		<a onClick="toggle_visibility('add_marca6');" class="sauto_ajax_link">
		<?php echo JText::_('SAUTO_ADD_MARCA_NOUA'); ?>
		</a>	
	</div>
	<?php $style_1 = 'display:none;';  ?>
	<div id="add_marca6" style="<?php echo $style_1; ?>">
		<input type="text" name="new_marca" value="" class="sa_inputbox" />
	</div>
					
	<div class="sauto_form_label"><?php echo JText::_('SAUTO_ALEGE_MODELUL'); ?></div>
		<div id="sa_marca">
			<select name="model_auto">
				<option value=""><?php echo JText::_('SAUTO_ALEGE_MODELUL_DORIT'); ?></option>
				<?php
				if ($rezult->marca_auto != '') {
					$query = "SELECT * FROM #__sa_model_auto WHERE `mid` = '".$rezult->marca_auto."' AND `published` = '1'";
					$db->setQuery($query);
					$modds = $db->loadObjectList();
					foreach ($modds as $m) {
						echo '<option value="'.$m->id.'"';
							if ($rezult->model_auto == $m->id) { echo ' selected'; }
						echo '>'.$m->model_auto.'</option>';
					}
				}
				?>
			</select>
			<br />
			<div class="sauto_form_label">
				<a onClick="toggle_visibility('add_model6');" class="sauto_ajax_link">
					<?php echo JText::_('SAUTO_ADD_MODEL_NOU'); ?>
				</a>
			</div>
			<?php $style_2 = 'display:none;'; ?>
			<div id="add_model6" style="<?php echo $style_2; ?>">
				<input type="text" name="new_model" value="" class="sa_inputbox" />
			</div>
		</div>
					
					
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_AN_FABRICATIE'); ?>
	</div>
	<div>
		<select name="an_fabricatie">
			<option value=""><?php echo JText::_('SAUTO_SELECT_AN_FABR'); ?></option>
			<?php
			$an = date("Y", mktime());
			for ($i=$an;$i>='1950';$i--) {
				echo '<option value="'.$i.'"';
					if ($i == $rezult->an_fabricatie) { echo ' selected';}
				echo '>'.$i.'</option>';
			}
			?>
		</select>
	</div>
					
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_CILINDREE'); ?>
	</div>
	<div>
		<input type="text" name="cilindree" value="<?php echo $rezult->cilindree; ?>" class="sa_inputbox" />
	</div>
					
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_CARBURANT'); ?>
	</div>
	<div>
		<select name="carburant">
			<option value=""><?php echo JText::_('SAUTO_ALEGE_CARBURANT'); ?></option>
			<?php
			$query = "SELECT * FROM #__sa_carburant ORDER BY `carburant` ASC";
			$db->setQuery($query);
			$carb = $db->loadObjectList();
			foreach ($carb as $c) {
				echo '<option value="'.$c->id.'"';
					if ($c->id == $rezult->carburant) { echo ' selected'; }
				echo '>'.$c->carburant.'</option>';
			}
			?>
		</select>
	</div>
		
				
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_CAROSERIE'); ?>
	</div>
	<div>
		<select name="caroserie">
			<option value=""><?php echo JText::_('SAUTO_ALEGE_CAROSERIE'); ?></option>
			<?php
			$query = "SELECT * FROM #__sa_caroserie ORDER BY `caroserie` ASC";
			$db->setQuery($query);
			$caros = $db->loadObjectList();
			foreach ($caros as $cr) {
				echo '<option value="'.$cr->id.'"';
					if ($cr->id == $rezult->caroserie) { echo ' selected'; }
				echo '>'.$cr->caroserie.'</option>';
			}
			?>
		</select>
	</div>
				
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_SERIE_CAROSERIE'); ?>
	</div>
	<div>
		<input type="text" name="serie_caroserie" value="<?php echo $rezult->serie_caroserie; ?>" class="sa_inputbox" />
	</div>
	<?php
	$query = "SELECT count(*) FROM #__sa_poze WHERE `id_anunt` = '".$rezult->id."'";
	$db->setQuery($query);
	$all_pics = $db->loadResult();
	if ($all_pics != 0) {
	?>
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_IMAGINI_ANUNT'); ?>
	</div>
	<?php
	}
		//for ($i=1;$i<=$sconfig->max_img_anunt;$i++) {
		$query = "SELECT * FROM #__sa_poze WHERE `id_anunt` = '".$rezult->id."' ORDER BY `id` ASC";
		$db->setQuery($query);
		$pics = $db->loadObjectList();
		foreach ($pics as $p) {
			echo '<div><img src="'.$image_path.$p->poza.'" width="70" /></div>';
			echo '<div><input type="checkbox" name="delete_pic_'.$p->id.'" value="1" />'.JText::_('SAUTO_DELETE_IMAGINE_ANUNT').'</div>';
			//echo '>>>> '.$p->poza.'<br />';
	/*<div>
		<input type="file" name="image_<?php echo $i; ?>" value="" class="sa_inputbox" />
	</div>
	*/ 
	} 
	//verificam daca avem maxim 4 poze
	if ($all_pics < 5) {
		//incarcam o poza
		echo '<div class="sauto_form_label">';
		echo JText::_('SAUTO_ADD_NEW_IMAGINE');
		echo '</div>';
		echo '<div>';
		echo '<input type="file" name="image_1" value="" class="sa_inputbox" />';
		echo '</div>';
	}
	?>		
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_ANUNT'); ?>
	</div>
	<div>
			<?php
			$editor =& JFactory::getEditor();
			echo $editor->display('anunt6', $rezult->anunt, '300', '150', '60', '20', false);
			?>
			</div>
	<br /><br /><br />	
	<input type="hidden" name="request" value="6" />
	<input type="hidden" name="anunt_id" value="<?php echo $id; ?>" />
	<div>
		<input type="submit" value="<?php echo JText::_('SAUTO_EDIT_ANUNT_BUTTON'); ?>"  class="sauto_button" />
	</div>
</form>
