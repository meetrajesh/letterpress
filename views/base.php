<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <title><? $t->block('title'); ?>Letterpress in PHP<? $t->endblock(true); ?></title>
    <meta name="description" content="">
    <meta property="og:site_name" content="Letterpress PHP" />
    <? $t->block('meta'); ?>
    <? $t->endblock(true); ?>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/libs/jquery-1.7.2.min.js"><\/script>')</script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>

    <link href='http://fonts.googleapis.com/css?family=Bree+Serif|Open+Sans:400,400italic,600,700' rel='stylesheet' type='text/css'>

    <? foreach ($this->_stylesheets as $stylesheet): ?>
        <link rel="stylesheet" href="<?= PATH_PREFIX . $stylesheet; ?>">
    <? endforeach; ?>
</head>
<body>

    <h2>Welcome to Letterpress for the Web</h2>

    <p>With this version of letterpress, you don&#39;t need an iPhone, or a Game Center account! All you need is an email address to play.</p>
    <hr/>

    <div class="container_12" id="main-content">
        <? $t->block('content'); ?>
        <? $t->endblock(true); ?>
    </div>

    <hr/>

    <? $t->block('footer'); ?>
    <? $t->endblock(true); ?>

    <script>
        $(document).data('view_data', <?= json_encode($this->_get_view_data($data)); ?>);
    </script>
    <? foreach ($this->_scripts as $script): ?>
        <script src="<?=PATH_PREFIX . $script?>"></script>
    <? endforeach; ?>

</body>
</html>
