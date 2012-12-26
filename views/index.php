<? $t->block('content'); ?>
    <? $this->_render_partial('_flash'); ?>
    <? $this->_render_partial('_js_focus'); ?>
    <?
    foreach ($data['games'] as $i => $game) {
    	$data['game'] = $game;
        $this->_render_partial('_game', $data);
    	if ($i != count($data['games'])-1) {
			echo '<hr/>';
		}
    }
    ?>
<? $t->endblock(); ?>

<? $t->block('footer'); ?>
    <p><a href="<?=$this->_url('/game/new')?>">Create new game</a></p>
<? $t->endblock(); ?>

<? $this->_render('base', $data); ?>
