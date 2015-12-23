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
$img_path = JURI::base()."components/com_sauto/assets/images/";
$image_path = JURI::base()."components/com_sauto/assets";
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$last_visit = $user->lastvisitDate;
$query = "SELECT * FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$profil = $db->loadObject();
$width = 'style="width:800px;"';
//oferte castigate
$query = "SELECT count(*) FROM #__sa_anunturi WHERE `proprietar` = '".$uid."' AND `is_winner` = '1'";
$db->setQuery($query);
$total_final_request = $db->loadResult();
//ofertele mele
$query = "SELECT count(*) FROM #__sa_anunturi WHERE `proprietar` = '".$uid."' AND `is_winner` = '0'";
$db->setQuery($query);
$total_my_request = $db->loadResult();
//obtinere comentarii
$query = "SELECT count(*) FROM #__sa_comentarii WHERE `proprietar` = '".$uid."' AND `data_adaugarii` > '".$last_visit."' AND `data_adaugarii` > '".$profil->data_1."' AND `raspuns` = '1' AND `readed_c` = '0'";
$db->setQuery($query);
$last_comms_n = $db->loadResult();
$query = "SELECT count(*) FROM #__sa_comentarii WHERE `proprietar` = '".$uid."' AND `data_adaugarii` < '".$last_visit."' AND `data_adaugarii` > '".$profil->data_1."' AND `raspuns` = '1' AND `readed_c` = '0'";
$db->setQuery($query);
$last_comms = $db->loadResult();
//obtinere feedback
$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$uid."'";
$db->setQuery($query);
$all = $db->loadResult();
$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$uid."' AND `tip` = 'p'";
$db->setQuery($query);
$poz = $db->loadResult();
$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$uid."' AND `tip` = 'x'";
$db->setQuery($query);
$neg = $db->loadResult();
$neg2 = $poz + $neg;
	if ($poz != '') {
		if ($neg2 != '') {
			$feeds = $poz/$neg2;
		}
	}
															
				
//linkuri
$link_add = JRoute::_('index.php?option=com_sauto&view=add_request');
$link_final_request = JRoute::_('index.php?option=com_sauto&view=final_request');
$link_my_request = JRoute::_('index.php?option=com_sauto&view=my_request');
$link_comments = JRoute::_('index.php?option=com_sauto&view=comments');
$link_feedback = JRoute::_('index.php?option=com_sauto&view=feedback');	
/*
?>
<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" align="center" <?php echo $width; ?>>
<center>

</div>


	

<div class="sauto_home_page_icons">
	<table width="100%" class="sa_table_class">
		<tr class="sa_table_row">

			<td align="center" class="sa_table_cell">
				<?php 
				
				 ?>
				
			</td>
		</tr>
		<tr class="sa_table_row">
			<td class="sa_table_cell" colspan="4">
				<div class="sa_front_divs">
				
				</div>
			</td>
		</tr>
		
		<tr class="sa_table_row">
			<td class="sa_table_cell" colspan="4">
				<div class="sa_front_divs">
				<?php
				require("list_comment_c.php");
				?>
				</div>
			</td>
		</tr>
		<tr class="sa_table_row">
			<td class="sa_table_cell" colspan="4">
				<div class="sa_front_divs">
				<?php
				require("list_feedback_c.php");
				?>
				</div>
			</td>
		</tr>
	</table>
</div>
</center>

		</td>
		<td class="sa_table_cell" valign="top" align="right">
			<div class="sa_allrequest_r">
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
*/
?>
<center id="m_table">
<div class="sauto_home_page">
	<h2 class="sa_front_title">
		<?php echo JText::_('SAUTO_WELCOME_CLIENT').' '.$profil->fullname; ?>
	</h2>
</div>

<div class="sa_logo_start">
	<?php 
	if ($profil->poza == '') { 
		$path = $image_path."/images/logo_client_mare.png";
	} else {
		$path = $image_path."/users/".$profil->uid."/".$profil->poza;
	} 	
	?>
	<img src="<?php echo $path; ?>" width="139" border="0" />


<br />
<div class="sa_logo_start">
	<?php  ?>
	<a href="<?php echo $link_add; ?>" class="sa_add_new_request" />
	<?php echo JText::_('SA_MENU_USERS_ADD_REQUEST'); ?>
	</a>
</div>
<br />
<div class="sauto_home_page_icons">
	<div class="sa_front_dealer_btns">
		<a href="<?php echo $link_final_request; ?>" class="sa_lk_profile">
			<img src="<?php echo $img_path; ?>icon_final_request.png" />
			<?php if ($total_final_request != 0) { ?>
			<span class="sa_sup_nr"><?php echo $total_final_request; ?></span>
			<?php } ?>
			<br />
			<?php echo JText::_('SA_MENU_USERS_FINAL_REQUEST'); ?>
		</a>
	</div>
	<div class="sa_front_dealer_btns">
	&nbsp;
	</div>
	<div class="sa_front_dealer_btns">
		<a href="<?php echo $link_my_request; ?>" class="sa_lk_profile">
			<img src="<?php echo $img_path; ?>icon_my_request.png" />
			<?php if ($total_my_request != 0) { ?>
			<span class="sa_sup_nr"><?php echo $total_my_request; ?></span>
			<?php } ?>
			<br />
			<?php echo JText::_('SA_MENU_USERS_MY_REQUEST'); ?>
		</a>
	</div>
	<div class="sa_front_dealer_btns">
	&nbsp;
	</div>
	<div class="sa_front_dealer_btns">
		<a href="<?php echo $link_comments; ?>" class="sa_lk_profile">
			<?php if ($last_comms_n != 0) { ?>
			<span class="sa_sup_nr sa_fact_red"><?php echo $last_comms_n; ?></span>
			<?php } ?>
			<img src="<?php echo $img_path; ?>icon_comments.png" />
			<?php if ($last_comms != 0) { ?>
			<span class="sa_sup_nr"><?php echo $last_comms; ?></span>
			<?php } ?>
			<br />
			<?php echo JText::_('SA_MENU_USERS_COMMENTS'); ?>
		</a>
	</div>
	<div class="sa_front_dealer_btns">
	&nbsp;
	</div>
	<div class="sa_front_dealer_btns">
		<a href="<?php echo $link_feedback; ?>" class="sa_lk_profile">
			<img src="<?php echo $img_path; ?>icon_feedback.png" />
			<?php if ($all != 0) { ?>
			<span class="sa_sup_nr"><?php echo round(100*$feeds,2).'%'; ?></span>
			<?php } ?>
			<br />
			<?php echo JText::_('SA_MENU_USERS_FEEDBACK'); ?>
		</a>
	</div>
</div>

<div class="sa_front_news_zone">
	<?php require("list_news_c.php");	?>
</div>

<div class="sa_front_news_zone">
	<?php require("list_comment_c.php");	?>
</div>

<div class="sa_front_news_zone">
	<?php require("list_feedback_c.php");	?>
</div>
	
</center>


<div id="m_visitors" style="background-color:#F9F9F9" >
	<div class = "m_header" style="width: 100%; height: 100px; background-color: #509EFF">
		<img id="menu-icon" class="menu-button" src="<?php echo $img_path?>menu-icon.png" />
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

	<div class = "main-container">
		<div class="user-options" style="width: 100%; height: auto; text-align: center;">
			<a href="/android/index.php?option=com_sauto&view=add_request" class="sa_lk_profile" style="padding-top: 9%; width: 49%; height: 170px; display: inline-block; ">
				<img style="width: 30%; height: 30% !important;" src="http://localhost/android/components/com_sauto/assets/images/icon_add_request.png" border="0">
				<br>
				Adauga cerere	
			</a>
			<a href="/android/index.php?option=com_sauto&amp;view=search" class="sa_lk_profile" style="padding-top: 9%; width: 49%; height: 170px; display: inline-block; ">
				<img style="width: 30%; height: 30% !important;" src="http://localhost/android/components/com_sauto/assets/images/icon_search.png" border="0">
				<br>
				Cauta firme	
			</a>
			<a href="/android/index.php?option=com_sauto&amp;view=my_request" class="sa_lk_profile" style="padding-top: 9%; width: 49%; height: 170px; display: inline-block; ">
				<img style="width: 30%; height: 30% !important;" src="http://localhost/android/components/com_sauto/assets/images/icon_my_request.png" border="0">
				<br>
				Cererile mele	
			</a>
			<a href="/android/index.php?option=com_sauto&amp;view=final_request" class="sa_lk_profile" style="padding-top: 9%; width: 49%; height: 170px; display: inline-block; ">
				<img style="width: 30%; height: 30% !important;" src="http://localhost/android/components/com_sauto/assets/images/icon_final_request.png" border="0">
				<br>
				Cereri finalizate	
			</a>
			<a href="/android/index.php?option=com_sauto&amp;view=edit_profile" class="sa_lk_profile" style="padding-top: 9%; width: 49%; height: 170px; display: inline-block; ">
				<img style="width: 30%; height: 30% !important;" src="http://localhost/android/components/com_sauto/assets/images/icon_edit_profile.png" border="0">
				<br>
				Editare profil	
			</a>
			<a href="/android/index.php?option=com_sauto&amp;view=logout" class="sa_lk_profile" style="padding-top: 9%; width: 49%; height: 170px; display: inline-block; ">
				<img style="width: 30%; height: 30% !important;" src="http://localhost/android/components/com_sauto/assets/images/icon_logout.png" border="0">
				<br>
				Inchide aplicatia	
			</a>
		</div>
	</div>
</div>

<script type="text/javascript">
	window.jQuery || document.write('<script src="js/jquery-1.7.2.min.js"><\/script>')
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
		if (jQuery('#sa_reclame_top')) {
			jQuery('#sa_reclame_top').remove();
		}
		if (jQuery('#sa_viz_side_bar')) {
			jQuery('#sa_viz_side_bar').remove();
		}
		if (jQuery('#additional_content')) {
			jQuery('#additional_content').remove();
		}

		document.write('<style type="text/css" >#content9{width: 100% !important;' + 
						'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
						'width: 100% !important;}</style>'
		);

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


