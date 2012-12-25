<? 
  $this->_add_css('css/main.css');
?>

<? $t->block('content'); ?>

<form method="post" action="<?=WEB_PREFIX?>/login">
  <?=csrf::html_tag()?>
  <label for="email">Enter your email to get started:
    <input type="text" id="email" name="email" size="30" />
    <input type="submit" id="btn_submit" name="btn_submit" value="Get Started!" />
  </label>
</form>

<? $t->endblock(); ?>

<? $this->_render('base', $data); ?>
