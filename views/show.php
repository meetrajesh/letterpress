<? $t->block('content'); ?>
	<? $this->_render_partial('_flash') ?>
	<? $this->_render_partial('_game', $data); ?>
<? $t->endblock(); ?>
  
<? $this->_render('base', $data); ?>
