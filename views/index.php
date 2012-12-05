<?
  $this->_add_js('js/game.js');
  $this->_add_css('css/main.css');
?>

<? $t->block('content'); ?>

  <form method="post">
    <p>Start a new game with:
    <input type="text" name="player2_email" size="30" /></p>
  
    <? include 'game.php'; ?>
  
    <input type="text" id="coords" name="coords" />
    <input type="text" id="letters" name="letters" />
  
    <p><input type="submit" name="btn_submit" value="Start new game!" /></p>
  
  <? $t->endblock(); ?>
  
</form>

<? $this->_render('base', $data); ?>
