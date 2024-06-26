<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= APP_URL; ?>/public/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="<?= APP_URL; ?>/public/assets/img/favicon.png">
    <title>
        <?= APP_NAME; ?>
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="<?= APP_URL; ?>/public/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="<?= APP_URL; ?>/public/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"  />
    <link href="<?= APP_URL; ?>/public/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="<?= APP_URL; ?>/public/assets/css/soft-ui-dashboard.css?v=1.0.8" rel="stylesheet" />
    <!-- Nepcha Analytics (nepcha.com) -->
    <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.7/build/css/intlTelInput.css">

    <link rel="stylesheet" href="<?= APP_URL; ?>/public/assets/js/plugins/emoji-picker-text-fields/lib/css/emoji.css">
    <link rel="stylesheet" href="<?= APP_URL; ?>/public/assets/css/style.css?v=<?= filemtime(BASEDIR . '/public/assets/css/style.css'); ?>">

    <link rel="stylesheet" href="<?= APP_URL; ?>/public/assets/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="<?= APP_URL; ?>/public/assets/css/table-responsive.css">
    <link rel="stylesheet" href="<?= APP_URL; ?>/public/assets/css/switch.css">
     
    <meta name="website" content="<?= APP_URL; ?>">
    <meta name="currency_type" content="<?= CURRENCY_TYPE; ?>">
    <meta name="currency_locale" content="<?= CURRENCY_LOCALE; ?>">
    
    <style>
         body{
            overflow-x: hidden;
        }

    
        .iti{
            width: 100%!important;
        }

        .opacity_campaign{
            display: none;
        }
        .page-link{
            cursor: pointer;
        }

        div:where(.swal2-container) div:where(.swal2-actions){
            z-index: 0!important;
        }

        div:where(.swal2-container) .swal2-html-container{
            overflow: visible!important;
        }

        .emoji-wysiwyg-editor{
            min-height: 242px!important;
        }

        .emoji-picker-icon{
            top: 40px!important;
        }
        .emoji-menu{
            top: 70px!important;
        }

        .font-12{
            font-size: 12px!important;
        }
        .dt-paging-button.current{
          color: #FFF!important;
         }

    </style>
</head>

<input type="hidden" id="rows_selected" value="{}" name="rows_selected" >