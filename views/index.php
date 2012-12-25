<? $t->block('content'); ?>

<form method="post" action="<?=$data['form_action']?>">
    <?=csrf::html_tag()?>
    <p>Start a new game with (type friend&#39;s email):
    <input type="text" name="player2_email" size="30" /></p>
  
    <? $data['game'] = $data['games'][0]; ?>
    <? $this->_render_partial('_game', $data); ?>
  
    <p><input type="submit" name="btn_submit" value="Start new game!" /></p>
</form>

<? $t->endblock(); ?>

<? $this->_render('base', $data); ?>
