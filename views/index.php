<? 
  $this->_add_js('js/game.js');
  $this->_add_css('css/main.css');
?>

<? $t->block('content'); ?>
    <? include 'game.php'; ?>
<? $t->endblock(); ?>

<? $this->_render('base', $data); ?>
