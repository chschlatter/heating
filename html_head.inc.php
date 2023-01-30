
    <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <link rel="stylesheet" href="./pico.min.css">
<?php if (isset($small_container) and $small_container): ?>
       <style>
        @media (min-width: 600px) {
            .container {
                max-width: 500px;
            }
        }
<?php endif; ?>
       </style>
       <title><?php echo APP_NAME ?></title>
    </head>