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

$titlu_anunt = $app->getUserState('titlu_anunt');
$marca = $app->getUserState('marca');
$model_auto = $app->getUserState('model_auto');
$an_fabricatie = $app->getUserState('an_fabricatie');
$cilindree = $app->getUserState('cilindree');
$carburant = $app->getUserState('carburant');
$nr_usi = $app->getUserState('nr_usi');
$caroserie = $app->getUserState('caroserie');
$serie_caroserie = $app->getUserState('serie_caroserie');
$anunt = $app->getUserState('anunt');


?>

<form action="<?php echo $link_form; ?>" method="post" enctype="multipart/form-data">
	<div>
		<h2><?php echo JText::_('SAUTO_TIP_ANUNT').' '.JText::_('SAUTO_TIP_ANUNT_DETAIL1'); ?></h2>
	</div>
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_TITLU_ANUNT'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	<div>
		<input type="text" name="titlu_anunt" value="<?php echo $titlu_anunt; ?>" class="sa_inputbox" />
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
		<?php echo JText::_('SAUTO_AN_FABRICATIE'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	<div>
		<select name="an_fabricatie" class="sa_select">
			<option value=""><?php echo JText::_('SAUTO_SELECT_AN_FABR'); ?></option>
			<?php
			$an = date("Y", mktime());
			for ($i=$an;$i>='1950';$i--) {
				echo '<option value="'.$i.'"';
					if ($i == $an_fabricatie) { echo ' selected';}
				echo '>'.$i.'</option>';
			}
			?>
		</select>
	</div>
					
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_CILINDREE'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	<div>
		<input type="text" name="cilindree" value="<?php echo $cilindree; ?>" class="sa_inputbox" />
	</div>
					
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_CARBURANT'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	<div>
		<select name="carburant" class="sa_select">
			<option value=""><?php echo JText::_('SAUTO_ALEGE_CARBURANT'); ?></option>
			<?php
			$query = "SELECT * FROM #__sa_carburant ORDER BY `carburant` ASC";
			$db->setQuery($query);
			$carb = $db->loadObjectList();
			foreach ($carb as $c) {
				echo '<option value="'.$c->id.'"';
					if ($c->id == $carburant) { echo ' selected'; }
				echo '>'.$c->carburant.'</option>';
			}
			?>
		</select>
	</div>
		
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_NR_USI'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	<div>
		<select name="nr_usi" class="sa_select">
			<option value=""><?php echo JText::_('SAUTO_ALEGE_NR_USI'); ?></option>
			<?php
			$query = "SELECT * FROM #__sa_usi ORDER BY `usi` ASC";
			$db->setQuery($query);
			$usi = $db->loadObjectList();
			foreach ($usi as $u) {
				echo '<option value="'.$u->id.'"';
					if ($u->id == $nr_usi) { echo ' selected'; }
				echo '>'.$u->usi.'</option>';
			}
			?>
		</select>
	</div>
				
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_CAROSERIE'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	<div>
		<select name="caroserie" class="sa_select">
			<option value=""><?php echo JText::_('SAUTO_ALEGE_CAROSERIE'); ?></option>
			<?php
			$query = "SELECT * FROM #__sa_caroserie ORDER BY `caroserie` ASC";
			$db->setQuery($query);
			$caros = $db->loadObjectList();
			foreach ($caros as $cr) {
				echo '<option value="'.$cr->id.'"';
					if ($cr->id == $caroserie) { echo ' selected'; }
				echo '>'.$cr->caroserie.'</option>';
			}
			?>
		</select>
	</div>
				
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_SERIE_CAROSERIE'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	<div>
		<input type="text" name="serie_caroserie" value="<?php echo $serie_caroserie; ?>" class="sa_inputbox" />
	</div>
			
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_ALEGE_TIP_PIESA'); ?>
	</div>
	<div>
		<input type="checkbox" name="nou" value="1" /> <?php echo JText::_('SAUTO_VREAU_PIESA_NOUA'); ?>
	</div>
	<div>
		<input type="checkbox" name="sh" value="1" /> <?php echo JText::_('SAUTO_VREAU_PIESA_SH'); ?>
	</div>
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_ANUNT'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	<div>
			<?php
			$editor =& JFactory::getEditor();
			echo $editor->display('anunt1', '', '500', '150', '60', '20', false);
			?>
			</div>
			
	<input type="hidden" name="request" value="1" />
	
	<div class="sauto_form_label">
		<input type="checkbox" name="parcheaza" value="1" />
		<?php echo JText::_('SAUTO_PARCHEAZA_AUTO'); ?>
	</div>
	<div>
		<?php echo JText::_('SAUTO_PARCHEAZA_AUTO_DETALII'); ?>
	</div>
	
	<div class="sauto_form_label sa_obligatoriu">
		<?php echo JText::_('SAUTO_CAMPURI_OBLIGATORII'); ?>
	</div>
	<br /><br /><br />

	<div>
		<input type="submit" value="<?php echo JText::_('SAUTO_ADD_ANUNT_BUTTON'); ?>"  class="sauto_button" />
	</div>
</form>
