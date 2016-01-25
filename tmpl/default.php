<?php
/**
* @version		1.0.0
* @author		John Toutoulis
* @copyright	Copyright (c) 1015. All rights reserved.
* @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
*/
defined('_JEXEC') or die;
?>

<div class="authorLatestArticles <?php echo $moduleclass_sfx ?>">
	<table class="table">
		<tr>
			<th>#</th>
			<th>Title</th>
			<th>Category</th>
			<th>Author</th>
			<th>Publish State</th>
			<th>Access Level</th>
			<th>Publish Date</th>
			<th>Edit</th>
		</tr>
		
		<?php
			$rowCounter = 1;
			foreach($articleList as $article) {
		?>
		<tr>
			<td> <?php echo $rowCounter; ?> </td>
			<td>
				<?php if ($params->get('source') == '0') { ?> 
				<a href="<?php echo  JRoute::_(ContentHelperRoute::getArticleRoute(  $article->id,  $article->catid )); ?>"><?php echo $article->title; ?></a>
				<?php } else if ($params->get('source') == '1') { ?>
					<a href="<?php echo JRoute::_(K2HelperRoute::getItemRoute($article->id.':'. $article->alias , $article->catid)) ?>"><?php echo $article->title; ?></a>
				<?php } ?>
			</td>
			<td><?php echo $article->category; ?></td>
			<td><?php echo $article->author; ?></td>
			<td><?php 
					if(($article->state == 1)) {
						if (JFactory::getDate() < $article->publish_up) { ?>
							<span class="label label-warning">Published but Pending</span>
				<?php } else { ?>
							<span class="label label-success">Published</span>
				<?php	} 
					} 
					else if($article->state == 0) { ?>
						<span class="label label-default">Un-Published</span>
					<?php }
				?>				
			</td>
			
			<td> <?php 				
				if ($article->access == 1) { ?>
				 	<span class="label label-primary">Public</span>
				<?php } else if ($article->access == 3) { ?>
					<span class="label label-info">Special</span>
				<?php } ?> 
			</td>
			
			<td>
				<?php
					if($params->get('source') == 0) {
						echo JHTML::_('date', $article->publish_up, JText::_('DATE_FORMAT_LC2'));
					}
					else {
						echo JHTML::_('date', $article->publish_up, JText::_('K2_DATE_FORMAT_LC2'));
					}
				
				?>
			</td>
			<td>
				<a <?php if($params->get('source') == '1') { ?>
					class="modal" rel="{handler:'iframe',size:{x:990,y:550}}" 
					<?php } ?>
					href="<?php echo $article->editLink; ?>">
					Edit Article
				</a>
			</td>
		</tr>
		<?php $rowCounter++; } ?>
	</table>
</div>
