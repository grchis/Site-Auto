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

//$editor =& JFactory::getEditor();

$db = JFactory::getDbo();
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
//get article
$query = "SELECT `introtext` FROM #__content WHERE `id` = '".$sconfig->login_article."'";
$db->setQuery($query);
$login_article = $db->loadResult();


$query = "SELECT `introtext` FROM #__content WHERE `id` = '".$sconfig->request_article."'";
$db->setQuery($query);
$request_article = $db->loadResult();
$link_form = JRoute::_('index.php?option=com_sauto&view=add_request2');
$img_path = JURI::base()."components/com_sauto/assets/images/forms/";
$width = 'style="width:800px;"';
?>
<table class="sa_table_class" id="m_table">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
<div style="display:inline;">
	<?php 
	if ($login_article == '') {
		echo '<div>';
	} else {
		echo '<div class="sauto_main_left">';
	}	
	?>
	
		<h3>
			<?php echo JText::_('SAUTO_TIP_ANUNT'); ?>
		</h3>
		<table width="100%">
			<tr>
				<td valign="top" width="50%">
					<div>
						<form action="<?php echo $link_form; ?>" method="post">
						<?php /*<select  id="selectedOptions" onchange="showDivs('div',this)">*/ ?>
							<select name="request" onChange="this.form.submit()" class="sa_select_mic">
								<option value="0" selected><?php echo JText::_('SAUTO_ALEGE_TIP_ANUNT'); ?></option>
								<?php
								$query = "SELECT * FROM #__sa_tip_anunt WHERE `published` = '1'";
								$db->setQuery($query);
								$tip = $db->loadObjectList();
								foreach ($tip as $t) {
									echo '<option value="'.$t->id.'">'.$t->tip.'</option>';
								}
								?>	
							</select>
						</form>
					</div>
				</td>
				<td valign="top">
					<div class="bubble_box"><?php echo JText::_('SAUTO_ADD_REQUEST_BUBBLE_1'); ?></div>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<?php
					$pozitionare = 'c';
					$categ = '';
					echo showAds($pozitionare, $categ);
					?>
				</td>
			</tr>
			<tr>
				<td valign="top">
					<div class="bubble_box2"><?php echo JText::_('SAUTO_ADD_REQUEST_BUBBLE_2'); ?></div>
				</td>
				<td valign="top">
					<?php
					$array = array("form1.png","form2.png","form3.png","form4.png","form5.png","form6.png","form7.png");
					$random = array_rand($array);
					$file = $array[$random];
					$file = 'form7.png';
					?>
					<img src="<?php echo $img_path.$file; ?>" />
				</td>
			</tr>
		</table>
			<div>
				<?php
				echo $request_article;
				?>
			</div>
	</div>
	
	<?php
	if ($login_article != '') {
	?>
	<div class="sauto_main_right">
		<?php echo $login_article; ?>
	</div>
	<?php } ?>
</div>
<div style="clear:both;"></div>
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
		?>
			</div>
		</td>
	</tr>
</table>
<div id="m_visitors" style="background-color:#F9F9F9">
	<div class = "m_header" style="width: 100%; height: 100px; background-color: #509EFF">
		<img id="menu-icon" class="menu-button" src="http://localhost/android/components/com_sauto/assets/images/menu-icon.png" />
	</div>

	<div id="main-menu" style="display: none;">
        <div class="menu-option" data-href="/android/index.php?option=com_sauto&view=add_request">
          <img class="menu-option-pic" src="http://localhost/android/components/com_sauto/assets/images/icon_requests.png" border="0">
          <span class="menu-option-text"> Adauga cerere </span>
        </div>

        <div class="menu-option" data-href="/android/index.php?option=com_sauto&amp;view=search">
          <img class="menu-option-pic" src="http://localhost/android/components/com_sauto/assets/images/icon_my_request.png" border="0">
          <span class="menu-option-text"> Cauta firme </span>
        </div>

        <div class="menu-option" data-href="/android/index.php?view=final_request">
          <img class="menu-option-pic" src="http://localhost/android/components/com_sauto/assets/images/icon_final_request.png" border="0">
          <span class="menu-option-text"> Cererile mele </span>
        </div>

        <div class="menu-option" data-href="/android/index.php?option=com_sauto&amp;view=final_request">
          <img class="menu-option-pic" src="http://localhost/android/components/com_sauto/assets/images/icon_alerts.png" border="0">
          <span class="menu-option-text"> Cereri finalizate </span>
        </div>

        <div class="menu-option" data-href="/android/index.php/component/sauto/?view=edit_profile">
          <img class="menu-option-pic" src="http://localhost/android/components/com_sauto/assets/images/icon_edit_profile.png" border="0">
          <span class="menu-option-text"> Editare profil </span>
        </div>

        <div class="menu-option" data-href="/android/index.php?option=com_sauto&amp;view=logout">
          <img class="menu-option-pic" src="http://localhost/android/components/com_sauto/assets/images/icon_logout.png" border="0">
          <span class="menu-option-text"> Inchide Aplicatia </span>
        </div>
    </div>

	<h3> Adauga Cerere Noua </h3>
	<div class = "main-container">
	<form action="<?php echo $link_form; ?>" method="post">
		<select name="request" onchange="this.form.submit()" class="sa_select_mic">
			<option value="0" selected="">Alege tipul cererii</option>
			<option value="1">Piese auto</option>
			<option value="2">Inchirieri</option>
			<option value="3">Auto noi</option>
			<option value="4">Auto rulate</option>
			<option value="5">Tractari auto</option>
			<option value="7">Accesorii auto</option>
			<option value="8">Service auto</option>
			<option value="9">Tuning</option>	
		</select>
	</form>
	</div>
</div>

<script type="text/javascript">
	window.jQuery || document.write('<script src="js/jquery-1.7.2.min.js"><\/script>');
	var isMobile = navigator.userAgent.contains('Mobile');
	if (!isMobile) {
		document.getElementById('m_visitors').remove();
	} else {
		var isMenuCollapsed = true;

		if (jQuery('#m_table')) {
			jQuery('#m_table').remove();
		}
		if (jQuery('#gkTopBar')) {
			jQuery('#gkTopBar').remove();
		}
		if (jQuery('#side_bar')) {
			jQuery('#side_bar').remove();
		}
		if (jQuery('#sa_viz_side_bar')) {
			jQuery('#sa_viz_side_bar').remove();
		}
		if (jQuery('#additional_content')) {
			jQuery('#additional_content').remove();
		}
		document.getElementsByTagName('h1')[0].remove();
		
		jQuery('#menu-icon').on('click', toggleMenu);

		jQuery('.menu-option-text').on('click', redirectToMenuOption);
	}

	function toggleMenu () {
	   if (isMenuCollapsed){
	        isMenuCollapsed = false;
	        jQuery('#main-menu').show(500);
	    }
	    else{
	        isMenuCollapsed = true;
	        jQuery('#main-menu').hide(500);
	    }
	}

	function redirectToMenuOption (event) {
  		event.preventDefault();
  		event.stopPropagation();

  		window.location.href = jQuery(event).data('href');
	}
</script>

<style type="text/css">
	@media screen and (max-width: 1210px){
	    .gkPage {
	        padding: 0 !important;
	    }
	}
</style>
