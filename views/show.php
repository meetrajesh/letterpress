<? $t->block('content'); ?>

<form method="post" action="<?=$data['form_action']?>">
    <?=csrf::html_tag()?>
  
    <? $this->_render_partial('_game', $data); ?>
  
</form>

<? $t->endblock(); ?>
  
<? $this->_render('base', $data); ?>
