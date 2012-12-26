<? 
  $this->_add_css('css/main.css');
?>

<? $t->block('content'); ?>

	<? $this->_render_partial('_flash') ?>

    <script type="text/javascript">
        $(document).ready(function() {
            document.forms[0].elements[1].focus();
        });
    </script>
    
    <form method="post" action="<?=WEB_PREFIX?>/login">
      <?=csrf::html_tag()?>
      <label for="email">Enter your email to get started:
        <input type="text" id="email" name="email" size="30" />
        <input type="submit" id="btn_submit" name="btn_submit" value="Get Started!" />
      </label>
    </form>

<? $t->endblock(); ?>

<? $this->_render('base', $data); ?>
