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
//obtin id
$id =& JRequest::getVar( 'id', '', 'get', 'string' );
//echo '>>>> user id > '.$id;
$user =& JFactory::getUser();
$uid = $user->id;

$img_path = JURI::base()."components/com_sauto/assets/images/";
$image_path = JURI::base()."components/com_sauto/assets";
$db = JFactory::getDbo();
//obtinem tipul de utilizator
$query = "SELECT `tip_cont` FROM #__sa_profiles WHERE `uid` = '".$id."'";
$db->setQuery($query);
$tip_cont = $db->loadResult();
if ($tip_cont == 0) {
	$query = "SELECT `p`.`poza`, `p`.`fullname`,  `p`.`adresa`, `p`.`telefon`, `p`.`uid`, `j`.`judet`, `u`.`registerDate`, `l`.`localitate` FROM #__sa_profiles as `p` JOIN #__sa_judete as`j` JOIN #__users as `u` JOIN #__sa_localitati as `l` ON `p`.`uid` = '".$id."' AND `p`.`uid` = `u`.`id` AND `p`.`judet` = `j`.`id` AND `p`.`localitate` = `l`.`id`";
} else {
	$query = "SELECT `p`.`poza`, `p`.`companie`, `p`.`reprezentant`, `p`.`sediu`, `p`.`telefon`, `p`.`uid`, `j`.`judet`, `u`.`registerDate`, `l`.`localitate` FROM #__sa_profiles as `p` JOIN #__sa_judete as`j` JOIN #__users as `u` JOIN #__sa_localitati as `l` ON `p`.`uid` = '".$id."' AND `p`.`uid` = `u`.`id` AND `p`.`judet` = `j`.`id` AND `p`.`localitate` = `l`.`id`";
} 
//$query = "SELECT `p`.*, `j`.`judet`, `u`.`registerDate` FROM #__sa_profiles as `p` LEFT JOIN #__sa_judete as`j` ON `p`.`judet` = `j`.`id` AND `p`.`uid` = '".$id."' JOIN #__users as `u` ON `u`.`id` = `p`.`uid`";
$db->setQuery($query);
$profil = $db->loadObject();

//verificam nivelul de acces
$query = "SELECT `tip_cont`, `abonament` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$types = $db->loadObject();
$view_phone = 0;
if ($types->tip_cont == 1) {
	//verificam abonamentul
	if ($types->abonament == 3) {
		$view_phone = 1;
	}
}
$width = 'style="width:800px;"';
?>
<table class="sa_table_class" id="m_table">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
		
<center>
	<table width="100%" class="sa_table_class">
		<tr class="sa_table_row">
			<td colspan="2" class="sa_table_cell" align="center">
			<?php
			if ($profil->poza == '') {
				//fara poza
				$path = $image_path."/images/logo_client_mare.png";
			} else {
				//cu poza
				$path = $image_path."/users/".$id."/".$profil->poza;
			}
			?>
			<div>
				<img src="<?php echo $path; ?>" width="75" border="0" />
			</div>
			<div>
			<h2><?php 
				if ($tip_cont == 0) {
					echo $profil->fullname; 
				} else {
					echo $profil->companie;	
				}?></h2>
			</div>
			</td>
		</tr>
		<tr class="sa_table_row">
			<td colspan="2" class="sa_table_cell" ><h2><?php echo JText::_('SAUTO_FEEDBACKS'); ?></h2></td>
		</tr>
		<tr class="sa_table_row">
			<td valign="top" class="sa_table_cell">
				<table class="sa_table_class">
					<tr class="sa_table_feedback_row">
						<th class="sa_table_feedback_cell"><?php echo JText::_('SAUTO_FEEDBACK_TYPE'); ?></th>
						<th class="sa_table_feedback_cell"><?php echo JText::_('SAUTO_FEEDBACK_LAST_MONTH'); ?></th>
						<th class="sa_table_feedback_cell"><?php echo JText::_('SAUTO_FEEDBACK_LAST_6_MONTH'); ?></th>
						<th class="sa_table_feedback_cell"><?php echo JText::_('SAUTO_FEEDBACK_TOTAL'); ?></th>
					</tr>
					<?php
					//obtin calificativele
					$curent_date = time();
					$last_30 = $curent_date - 2592000;
					$last_6 = $curent_date - 15552000;
					//echo '>>> '.$curent_date.'<br />';
					$last_30 = date("Y-m-d h:i:s", $last_30);
					$last_6 = date("Y-m-d h:i:s", $last_6);
					//echo '>>>> '.$last_30.'<br />';
					//echo '>>>>> '.$last_6.'<br />';
					//pozitiv series
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'p' AND `data_cal` > '".$last_30."'";
					$db->setQuery($query);
					$poz_1 = $db->loadResult();
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'p' AND `data_cal` > '".$last_6."'";
					$db->setQuery($query);
					$poz_2 = $db->loadResult();
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'p'";
					$db->setQuery($query);
					$poz_3 = $db->loadResult();
					//negativ series
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'x' AND `data_cal` > '".$last_30."'";
					$db->setQuery($query);
					$neg_1 = $db->loadResult();
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'x' AND `data_cal` > '".$last_6."'";
					$db->setQuery($query);
					$neg_2 = $db->loadResult();
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'x'";
					$db->setQuery($query);
					$neg_3 = $db->loadResult();
					//neutru series
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'n' AND `data_cal` > '".$last_30."'";
					$db->setQuery($query);
					$neu_1 = $db->loadResult();
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'n' AND `data_cal` > '".$last_6."'";
					$db->setQuery($query);
					$neu_2 = $db->loadResult();
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'n'";
					$db->setQuery($query);
					$neu_3 = $db->loadResult();
					//echo '???? '.$poz_1.' >>> '.$poz_2.' ???? '.$poz_3;
					?>
					<tr class="sa_table_feedback_row">
						<td class="sa_table_dfeedback_cell">
							<img src="<?php echo $img_path; ?>feedback_pozitiv.png" border="0" />
							<span class="sa_feed_label"><?php echo JText::_('SA_FEEDBACK_POZITIV'); ?></span>
						</td>
						<td class="sa_table_dfeedback_cell"><?php echo $poz_1; ?></td>
						<td class="sa_table_dfeedback_cell"><?php echo $poz_2; ?></td>
						<td class="sa_table_dfeedback_cell"><?php echo $poz_3; ?></td>
					</tr>
					<tr class="sa_table_feedback_row">
						<td class="sa_table_dfeedback_cell">
							<img src="<?php echo $img_path; ?>feedback_neutru.png" border="0" />
							<span class="sa_feed_label"><?php echo JText::_('SA_FEEDBACK_NEUTRU'); ?></span>
						</td>
						<td class="sa_table_dfeedback_cell"><?php echo $neu_1; ?></td>
						<td class="sa_table_dfeedback_cell"><?php echo $neu_2; ?></td>
						<td class="sa_table_dfeedback_cell"><?php echo $neu_3; ?></td>
					</tr>
					<tr class="sa_table_feedback_row">
						<td class="sa_table_dfeedback_cell">
							<img src="<?php echo $img_path; ?>feedback_negativ.png" border="0" />
							<span class="sa_feed_label"><?php echo JText::_('SA_FEEDBACK_NEGATIV'); ?></span>
						</td>
						<td class="sa_table_dfeedback_cell"><?php echo $neg_1; ?></td>
						<td class="sa_table_dfeedback_cell"><?php echo $neg_2; ?></td>
						<td class="sa_table_dfeedback_cell"><?php echo $neg_3; ?></td>
					</tr>
				</table>
			</td>
			<td valign="top" class="sa_table_cell">
				<table class="sa_table_class">
					<tr class="sa_table_row">
						<td class="sa_table_cell">
							<?php
							echo JText::_('SAUTO_PROFILE_CITY').': '.$profil->localitate; 
							?>
						</td>
					</tr>
					<tr class="sa_table_row">
						<td class="sa_table_cell">
							<?php
							echo JText::_('SAUTO_PROFILE_JUDET').' '.$profil->judet; 
							?>
						</td>
					</tr>
					<tr class="sa_table_row">
						<td class="sa_table_cell">
							<?php
							echo JText::_('SAUTO_PROFILE_ADRESA').': '.$profil->adresa; 
							?>
						</td>
					</tr>
					<tr class="sa_table_row">
						<td class="sa_table_cell">
							<?php
							$data_inreg = explode(" ", $profil->registerDate);
							echo JText::_('SAUTO_PROFILE_REGISTER_DATE').' '.$data_inreg[0];
							?>
						</td>
					</tr>
					<tr class="sa_table_row">
						<td class="sa_table_cell">
							<?php
							$neg2 = $poz_3 + $neg_3;
							$feeds = $poz_3/$neg2;
							$all = $poz_3 + $neg_3 + $neu_3;
							echo JText::_('SAUTO_PROFILE_FEEDBACKS').' '.round(100*$feeds,2).'% ('.$all.')'; ?>
						</td>
					</tr>
					
					<tr class="sa_table_row">
						<td class="sa_table_cell sa_phone sa_hover">
							<img src="<?php echo $img_path; ?>icon_phone.png" border="0" class="sa_phone_img" />
							<span class="sa_phone_span">
							<?php
							if ($tip_cont == 0) {
								if ($view_phone == 0) {
									echo JText::_('SAUTO_TELEFON_ASCUNS');
								} else {
									echo $profil->telefon;
								}
							} else {
								//afisam telefon
								echo $profil->telefon;
							}
							?>
							</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr class="sa_table_row">
			<td colspan="2" height="50" class="sa_table_cell"></td>
		</tr>
		<?php
		//$query = "SELECT `a`.*, `r`.`firma` FROM #__sa_anunturi as `a` JOIN #__sa_raspunsuri as `r` ON `a`.`proprietar` = `r`.`proprietar` AND `a`.`id` = `r`.`anunt_id` ORDER BY `a`.`id` DESC LIMIT 0,3";
		$query = "SELECT `c`.`anunt_id`, `c`.`mesaj`, `c`.`tip`, `a`.`titlu_anunt`, `c`.`data_cal`, `c`.`poster_id` FROM #__sa_calificativ as `c` JOIN #__sa_anunturi as `a` ON `c`.`dest_id` = '".$id."' AND `c`.`anunt_id` = `a`.`id` ORDER BY `c`.`id` DESC LIMIT 0, 5";
		$db->setQuery($query);
		$list = $db->loadObjectList();
		foreach ($list as $l) {
			if ($style == ' sa-row1 ') { 
			$style = ' sa-row0 '; 
			} else { 
			$style = ' sa-row1 '; 
			}
			$link_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$l->anunt_id);
			?><tr class="sa_table_row <?php echo $style; ?>">
				<td class="sa_table_cell" rowspan="2" valign="top">
					<table class="sa_table_class">
						<tr class="sa_table_row">
							<td rowspan="2" class="sa_table_cell" width="80" valign="top">
								<?php
								if ($l->tip == 'p') {
									$poza = 'icon_mesaj_pozitiv.png';
								} elseif ($l->tip == 'x') {
									$poza = 'icon_mesaj_negativ.png';
								} elseif ($l->tip == 'n') {
									$poza = 'icon_mesaj_neutru.png';
								}
								?>
								<img src="<?php echo $img_path.$poza; ?>" border="0" />
							</td>
							<td class="sa_table_cell" valign="top">
									<a href="<?php echo $link_anunt; ?>" class="sa_public_profile">
										<?php echo $l->titlu_anunt; ?>
									</a>
							</td>
						</tr>
						<tr class="sa_table_row">
							<td class="sa_table_cell" valign="top">
								<div class="sauto_data_add">
									<?php 
									$data_c = explode(" ", $l->data_cal);
									echo JText::_('SAUTO_DATA_TITLE').' '.$data_c[0]; ?>
								</div>
							</td>
						</tr>
						<tr class="sa_table_row">
							<td colspan="2" class="sa_table_cell">
								<div class="sauto_show_anunt">
									<?php echo $l->mesaj; ?>
								</div></td>
						</tr>
					</table>
				</td>
				<td class="sa_table_cell" valign="top">
					<?php
					if ($tip_cont == 0) {
						$query = "SELECT `p`.`telefon`,  `p`.`companie`, `p`.`calificative`, `u`.`registerDate`, `j`.`judet` FROM #__sa_profiles as `p` JOIN  #__users as `u` ON `p`.`uid` = '".$l->poster_id."' JOIN #__sa_judete as `j` ON `p`.`judet` = `j`.`id`";
					} else {
						$query = "SELECT `p`.`telefon`,  `p`.`fullname`, `p`.`calificative`, `u`.`registerDate`, `j`.`judet` FROM #__sa_profiles as `p` JOIN  #__users as `u` ON `p`.`uid` = '".$l->poster_id."' JOIN #__sa_judete as `j` ON `p`.`judet` = `j`.`id`";
					}
					$db->setQuery($query);
					$usr = $db->loadObject();
					$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$l->poster_id);
					?>
					<div>
						<a href="<?php echo $link_profile; ?>" class="sa_public_profile">
						<?php 
						if ($tip_cont == 0) {
							echo $usr->companie; 
						} else {
							echo $usr->fullname; 
						} ?>
						</a>
					</div>
					<br />
					<?php echo JText::_('SAUTO_FORM_REGION'); ?>
					<?php echo $usr->judet; ?>
					<br />
					<?php echo JText::_('SAUTO_CALIFICATIV_TITLE').': '.$usr->calificative.'%'; ?>
					<br />
					<?php 
					$date_reg = explode(" ", $usr->registerDate);
					echo JText::_('SAUTO_PROFILE_REGISTER_DATE').': '.$date_reg[0]; ?>
				</td>
			</tr>
			<tr class="sa_table_row <?php echo $style; ?>">
				<td class="sa_table_cell">
					<div class="sa_phone sa_hover">
					<img src="<?php echo $img_path; ?>icon_phone.png" border="0" class="sa_phone_img" />
						<span class="sa_phone_span">
							<?php 
							if ($tip_cont == 0) {
								echo $usr->telefon;
							} else {
								//telefon ascuns
								if ($view_phone == 0) {
									if ($l->poster_id == $uid) {
										//numar propriu, afisam
										echo $usr->telefon;
									} else {
										//nu afisam
										echo JText::_('SAUTO_TELEFON_ASCUNS');
									}
									
								} else {
									echo $usr->telefon;
								}
							} ?>
						</span>	
					</div>
				</td>
			</tr>
			
		<?php	
		}
		?>
	</table>
	<?php if ($tip_cont == 0) { ?>
		<div>
		<?php 
		$link_all = JRoute::_('index.php?option=com_sauto&view=all&id='.$id); 
		?>
		<a href="<?php echo $link_all; ?>"><?php echo JText::_('SAUTO_VIEW_ALL_REQUESTS'); ?></a>
		</div>
	<?php } ?>
</center>
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




<div id="m_visitors">
	<div class = "m_header" style="width: 100%; height: 100px; background-color: #509EFF">
	</div>
	<b>
	<h1><?php echo $profil->companie; ?></h1>
	 </b>
	<p><span> Reprezentant: </span> <?php echo $profil->reprezentant; ?></p>
	<p><span> Oras: </span>	 <?php  echo $profil->localitate; ?></p>
	<p><span> Judet: </span>    <?php  echo $profil->judet; ?></p>
	<p><span> Adresa: </span>   <?php echo $profil->adresa; ?></p>
	<p><span> Data Inregistrare: </span><?php echo $data_inreg[0]; ?></p>
	<p><span> Calificativ: </span> <?php  echo round(100*$feeds,2).'% ('.$all.')';?></p>
	<table class="sa_table_class">
					<tr class="sa_table_feedback_row">
						<th class="sa_table_feedback_cell"><?php echo JText::_('SAUTO_FEEDBACK_TYPE'); ?></th>
						<th class="sa_table_feedback_cell"><?php echo JText::_('SAUTO_FEEDBACK_LAST_MONTH'); ?></th>
						<th class="sa_table_feedback_cell">6 luni</th>
						<th class="sa_table_feedback_cell"><?php echo JText::_('SAUTO_FEEDBACK_TOTAL'); ?></th>
					</tr>
					<?php
					//obtin calificativele
					$curent_date = time();
					$last_30 = $curent_date - 2592000;
					$last_6 = $curent_date - 15552000;
					//echo '>>> '.$curent_date.'<br />';
					$last_30 = date("Y-m-d h:i:s", $last_30);
					$last_6 = date("Y-m-d h:i:s", $last_6);
					//echo '>>>> '.$last_30.'<br />';
					//echo '>>>>> '.$last_6.'<br />';
					//pozitiv series
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'p' AND `data_cal` > '".$last_30."'";
					$db->setQuery($query);
					$poz_1 = $db->loadResult();
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'p' AND `data_cal` > '".$last_6."'";
					$db->setQuery($query);
					$poz_2 = $db->loadResult();
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'p'";
					$db->setQuery($query);
					$poz_3 = $db->loadResult();
					//negativ series
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'x' AND `data_cal` > '".$last_30."'";
					$db->setQuery($query);
					$neg_1 = $db->loadResult();
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'x' AND `data_cal` > '".$last_6."'";
					$db->setQuery($query);
					$neg_2 = $db->loadResult();
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'x'";
					$db->setQuery($query);
					$neg_3 = $db->loadResult();
					//neutru series
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'n' AND `data_cal` > '".$last_30."'";
					$db->setQuery($query);
					$neu_1 = $db->loadResult();
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'n' AND `data_cal` > '".$last_6."'";
					$db->setQuery($query);
					$neu_2 = $db->loadResult();
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'n'";
					$db->setQuery($query);
					$neu_3 = $db->loadResult();
					//echo '???? '.$poz_1.' >>> '.$poz_2.' ???? '.$poz_3;
					?>
					<tr class="sa_table_feedback_row">
						<td class="sa_table_dfeedback_cell">
							<img src="<?php echo $img_path; ?>feedback_pozitiv.png" border="0" />
							<span class="sa_feed_label"><?php echo JText::_('SA_FEEDBACK_POZITIV'); ?></span>
						</td>
						<td class="sa_table_dfeedback_cell"><?php echo $poz_1; ?></td>
						<td class="sa_table_dfeedback_cell"><?php echo $poz_2; ?></td>
						<td class="sa_table_dfeedback_cell"><?php echo $poz_3; ?></td>
					</tr>
					<tr class="sa_table_feedback_row">
						<td class="sa_table_dfeedback_cell">
							<img src="<?php echo $img_path; ?>feedback_neutru.png" border="0" />
							<span class="sa_feed_label"><?php echo JText::_('SA_FEEDBACK_NEUTRU'); ?></span>
						</td>
						<td class="sa_table_dfeedback_cell"><?php echo $neu_1; ?></td>
						<td class="sa_table_dfeedback_cell"><?php echo $neu_2; ?></td>
						<td class="sa_table_dfeedback_cell"><?php echo $neu_3; ?></td>
					</tr>
					<tr class="sa_table_feedback_row">
						<td class="sa_table_dfeedback_cell">
							<img src="<?php echo $img_path; ?>feedback_negativ.png" border="0" />
							<span class="sa_feed_label"><?php echo JText::_('SA_FEEDBACK_NEGATIV'); ?></span>
						</td>
						<td class="sa_table_dfeedback_cell"><?php echo $neg_1; ?></td>
						<td class="sa_table_dfeedback_cell"><?php echo $neg_2; ?></td>
						<td class="sa_table_dfeedback_cell"><?php echo $neg_3; ?></td>
					</tr>
				</table>
</div>


<script type="text/javascript">

	var isMobile = navigator.userAgent.contains('Mobile');
	if (!isMobile) {
		document.getElementById('m_visitors').remove();
	} else {
		document.getElementById('wrapper9').getElementsByTagName('h1')[0].remove();
		document.getElementById('m_table').remove();
		document.getElementById('gkTopBar').remove();
		document.getElementById('side_bar').style.display = "none";
		document.getElementById('content9').style.all = "none";
		document.write('<style type="text/css" >#content9{width: 100%;' + 
						'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
						'width: 100% !important;}#gkMainbody table{ width: 100% !important; }' + 
						'#gkMainbody table tbody, #gkMainbody table thead, #gkMainbody table tfoot{ width: 100% !important; }' + 
						'span{ display: inline-block; width: 45%; } p{ margin-top: 2px; margin-bottom: 2px;}</style>'
		);
	}

</script>