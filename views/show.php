<? $t->block('content'); ?>
	<? $this->_render_partial('_flash') ?>
	<? $this->_render_partial('_game', $data); ?>
<? $t->endblock(); ?>

<? $t->block('footer'); ?>
    <p><a href="<?=$this->_url('/')?>">Back to list of games</a></p>
<? $t->endblock(); ?>
  
<? $this->_render('base', $data); ?>
