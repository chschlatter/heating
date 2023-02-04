<html>

<?php include(__DIR__ . '/html_head.inc.php'); ?>

    <body>
        <main class="container">
            <h1><?php echo $_ENV['APP_NAME'] ?></h1>
            <h2>Error</h2>
            <p><?= $error_message ?></p>
        </main>
    </body>

</html>