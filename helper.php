<?php
	
/**
 * @version		1.0.0
 * @author		John Toutoulis
 * @copyright	Copyright (c) 1015. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */
defined('_JEXEC') or die;

abstract class mod_authorlatestarticlesHelper {
	public static function getArticles(&$params) {
		$db = JFactory::getDbo();
		
		if($params->get('source') == '0') {
			$query = $db->getQuery(true);
			$query->select('c.id, c.catid, c.title, c.state, c.access, c.publish_up, u.name as author, cat.title as category');
			$query->from('#__content AS c');
			$query->join('INNER', '#__users AS u ON (c.created_by = u.id)' );
			$query->join('INNER', '#__categories as cat ON (c.catid = cat.id)');
			$query->where('c.state != -2');
			$query->order('publish_up DESC');
			$db->setQuery($query, 0, $params->get('count', 5));
		}
		else if ($params->get('source') == '1') {
			$query = $db->getQuery(true);
			$query->select('c.id, c.catid, c.alias, c.title, c.published AS state, c.access, c.publish_up, c.trash, u.userName as author, cat.name as category');
			$query->from('#__k2_items c');
			$query->join('INNER', '#__k2_users as u ON (c.created_by = u.userID)');
			$query->join('INNER', '#__k2_categories as cat ON (c.catid = cat.id)');
			$query->where('c.trash != 1');
			$query->order('publish_up DESC');
			$db->setQuery($query, 0, $params->get('count', 5));
		}
		
		try {
			$articles = $db->loadObjectList();
		}
		catch (RuntimeException $e) {
			JError::raiseError(500, $e->getMessage());
			return false;
		}
		
		foreach($articles as $i => $article) {
			$articles[$i] = new stdClass;
			$articles[$i]->id = (int)$article->id;
			$articles[$i]->catid = (int)$article->catid;
			$articles[$i]->access = (int)$article->access;
			$articles[$i]->title = htmlspecialchars($article->title);
			$articles[$i]->category = htmlspecialchars($article->category);
			$articles[$i]->author = htmlspecialchars($article->author);
			$articles[$i]->publish_up = $article->publish_up;
			$articles[$i]->state = $article->state;
			
			if ($params->get('source') == '1') {
				$articles[$i]->alias = htmlspecialchars($article->alias);
				$articles[$i]->trash = (int)$article->trash;

				$articles[$i]->editLink = JRoute::_('index.php?option=com_k2&view=item&task=edit&cid='.$article->id.'&tmpl=component');
				}
			else {
				$articles[$i]->editLink = JRoute::_('index.php?option=com_content&task=article.edit&a_id='.$article->id);
			}
		}
		
		return $articles;
	}
}
	