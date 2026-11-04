<?php
/**
 * Layout das telas novas (CSS modular, sem style.css legado).
 * Chame antes o bootstrap da tela (bootstrap-page.php ou bootstrap-public.php).
 * Variaveis: $pageTitle (string), $pageCss (array de caminhos em assets/css/pages), $bodyClass (string).
 * Os caminhos sao relativos e assumem a profundidade pages/<modulo>/<submodulo>/<tela>/index.php.
 */
require_once __DIR__ . '/../includes/partial-guard.php';

$pageTitle = isset($pageTitle) ? $pageTitle : 'Fobbi COF';
$pageCss = isset($pageCss) ? $pageCss : array();
$bodyClass = isset($bodyClass) ? $bodyClass : '';
$cssBase = '../../../../assets/css/';
$cssCore = array('tokens.css', 'base.css', 'components/button.css', 'components/form.css', 'components/alert.css', 'components/card.css', 'components/badge.css');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8"/>
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="author" content="HSYS - Desenvolvimento de Sistemas" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= csrf_meta() ?>

    <script src="../../../../assets/js/csrf-setup.js?v=1"></script>
    <link rel="shortcut icon" href="../../../../assets/images/favicon.ico"/>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Quicksand:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<?php foreach ($cssCore as $css) { ?>
    <link rel="stylesheet" href="<?= $cssBase . $css ?>?v=1"/>
<?php } ?>
<?php foreach ($pageCss as $css) { ?>
    <link rel="stylesheet" href="<?= $cssBase . htmlspecialchars($css, ENT_QUOTES, 'UTF-8') ?>?v=1"/>
<?php } ?>
</head>
<body class="<?= htmlspecialchars($bodyClass, ENT_QUOTES, 'UTF-8') ?>">
