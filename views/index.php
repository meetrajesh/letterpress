<? $t->block('content'); ?>

<? $this->_render_partial('_flash'); ?>

<?
foreach ($data['games'] as $game) {
	$data['game'] = $game;
    $this->_render_partial('_game', $data);
}
?>

<? $t->endblock(); ?>

<? $this->_render('base', $data); ?>
