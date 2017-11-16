<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
<?php include_once(THEMES .$core->getConfigVal('theme').'/header.php') ?>

<?php if($mode == 'list'){ ?>
<ul class="items <?php if($runPlugin->getConfigVal('hideContent')){ ?>simple<?php } ?>">
	<?php foreach($news as $k=>$v){ ?>
	<li class="item">
		<?php if(!$runPlugin->getConfigVal('hideContent')){ ?>
		<h2>
			<a href="<?php echo $v['url']; ?>"><?php echo $v['name']; ?></a>
			<span class="date"><?php echo $v['date']; ?>
			<?php if($runPlugin->getConfigVal('comments')){ ?> | <?php echo $newsManager->countComments($v['id']); ?> commentaire(s)<?php } ?></span>
		</h2>
		<?php echo $v['content']; ?>
		<?php } else{ ?>
		<a href="<?php echo $v['url']; ?>"><?php echo $v['name']; ?></a> <span class="date"><?php echo $v['date']; ?><?php if($runPlugin->getConfigVal('comments')){ ?> | <?php echo $newsManager->countComments($v['id']); ?> commentaire(s)<?php } ?></span>
		<?php } ?>
	</li>
	<?php } ?>
</ul>
<ul class="pagination">
	<?php foreach($pagination as $k=>$v){ ?>
	<li><a href="<?php echo $v['url']; ?>"><?php echo $v['num']; ?></a></li>
	<?php } ?>
</ul>
<?php } ?>

<?php if($mode == 'read'){ ?>
<?php echo $item->getContent(); ?>
<p class="date">
	Posté le <?php echo util::FormatDate($item->getDate(), 'en', 'fr'); ?>
	<?php if($runPlugin->getConfigVal('comments')){ ?> | <?php echo $newsManager->countComments(); ?> commentaire(s)<?php } ?>
	| <a href="<?php echo $core->makeUrl('news'); ?>">Retour aux actualités</a>
</p>
<?php if($runPlugin->getConfigVal('comments')){ ?>

<h2>Commentaires</h2>
<?php if($newsManager->countComments() == 0){ ?><p>Il n'y a pas de commentaires</p><?php } ?>
<?php if($newsManager->countComments() > 0){
	foreach($newsManager->getComments() as $k=>$v){
?>
<p class="comment" id="comment<?php echo $v->getId(); ?>"><?php echo nl2br($v->getContent()); ?><br><span class="infos"><?php echo $v->getAuthor(); ?> | <?php echo util::FormatDate($v->getDate(), 'en', 'fr'); ?></span></p>
<?php
	}
}
?>
<h2>Ajouter un commentaire</h2>
<form method="post" action="<?php echo $core->makeUrl('news', array('action' => 'send')); ?>">
	<input type="hidden" name="id" value="<?php echo $item->getId(); ?>" />
	<input type="hidden" name="back" value="<?php echo $core->getConfigVal('siteUrl').'/'.$core->makeUrl('news', array('action' => 'read', 'name' => util::strToUrl($item->getName()), 'id' => $item->getId())); ?>" />
	<p>
		<label>Pseudo</label><br>
		<input style="display:none;" type="text" name="_author" value="" />
		<input type="text" name="author" required="required" />
	</p>
	<p><label>Email</label><br><input type="text" name="authorEmail" required="required" /></p>
	<p><label>Commentaire</label><br><textarea name="content" required="required"></textarea></p>
	<p><input type="submit" value="Enregistrer" /></p>
</form>
<?php } ?>
<?php } ?>

<?php include_once(THEMES .$core->getConfigVal('theme').'/footer.php') ?>