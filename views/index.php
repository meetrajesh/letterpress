<?
  $this->_add_js('js/game.js');
  $this->_add_css('css/main.css');
?>

<? $t->block('content'); ?>

  <form method="post">
    <p>Start a new game with (type email of friend):
    <input type="text" name="player2_email" size="30" /></p>
  
    <? include 'game.php'; ?>
  
    <input type="hidden" id="coords" name="coords" />
    <p id="letters"></p>
  
    <p><input type="submit" name="btn_submit" value="Start new game!" /></p>
  
  <? $t->endblock(); ?>
  
</form>

<? $this->_render('base', $data); ?>
