<? $t->block('content'); ?>

<? $this->_render_partial('_flash'); ?>

<?
foreach ($data['games'] as $game) {
	$data['game'] = $game;
	$data['form_action'] = $this->_url(spf('/game/move/%d', $game->id));
    $this->_render_partial('_game', $data);
}
?>

<br/><hr/><p><a href="<?=$this->_url('/game/new')?>">Create new game</a></p>

<? $t->endblock(); ?>

<? $this->_render('base', $data); ?>
