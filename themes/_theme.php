<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link rel="shortcut icon" href="<?= url("themes/assets/img/icon.png"); ?>">
        <link rel="stylesheet" href="<?= url("themes/assets/fonts/icomoon/style.css"); ?>">
        <link rel="stylesheet" href="<?= url("vendor/bootstrap/css/bootstrap.min.css"); ?>">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= url("themes/assets/css/style.css"); ?>">

        <title><?= $title; ?></title>

        <?= $v->section("css") ?>
    </head>
    <body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
        <div id="loader-div" class="loader-div" style="display: none">
            <div class="loader-spin"></div>
        </div>

        <?= $v->section("content"); ?>

        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <?= $v->section("scripts") ?>
    </body>
</html>
