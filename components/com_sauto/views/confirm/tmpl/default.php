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
$app =& JFactory::getApplication();
$link_redirect = JRoute::_('index.php?option=com_sauto');

$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
?>


<div id="wrapper9">
<h1><?php echo $this->site_title; ?></h1>
	<div id="side_bar">
	<?php 
	$user =& JFactory::getUser();
	$uid = $user->id;
		if ($uid == 0) {
			//vizitator
			require_once("components/com_sauto/assets/includes/menu_v.php");
		} else {
				$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
		}
	?> 
	</div>
				
	<div id="content9">
		<table>
			<tr>
				<td>
		<?php
			jimport('joomla.application.module.helper');
			$modules = JModuleHelper::getModules($sconfig->login_module2);
				foreach($modules as $module) {
				echo JModuleHelper::renderModule($module);
				}
			?>
			</td>
			</tr>
		</table>		
	</div>
				
					
</div>


