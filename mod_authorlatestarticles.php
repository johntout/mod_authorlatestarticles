<?php
/**
 * @version		1.0.0
 * @author		John Toutoulis
 * @copyright	Copyright (c) 1015. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */
 
defined('_JEXEC') or die;

require_once __DIR__ . '/helper.php';

$articleList = mod_authorlatestarticlesHelper::getArticles($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
require JModuleHelper::getLayoutPath('mod_authorlatestarticles', $params->get('layout', 'default'));

JHtml::_('stylesheet', 'mod_authorlatestarticles/style.css', array(),
true);
   

