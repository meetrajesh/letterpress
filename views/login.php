<? $t->block('content'); ?>

	<? $this->_render_partial('_flash') ?>
	<? $this->_render_partial('_js_focus') ?>

    <form method="post" action="<?=$this->_url('/login')?>">
      <?=csrf::html_tag()?>
      <label for="email">Enter your email to get started:
        <input type="text" id="email" name="email" size="30" />
        <input type="submit" id="btn_submit" name="btn_submit" value="Get Started!" />
      </label>
    </form>

<? $t->endblock(); ?>

<? $this->_render('base', $data); ?>
