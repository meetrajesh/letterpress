<? if ($this->_has_flash('error')): ?>
    <div id="flash" class="alert alert-error"><?=hsc($this->_get_flash('error'))?></div>
<? endif; ?>
