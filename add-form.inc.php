<html>

<?php include(__DIR__ . '/html_head.inc.php'); ?>

    <body>
        <main class="container">
            <h1><?php echo $_ENV['APP_NAME'] ?></h1>
            <h2>Add meter value</h2>

            <h4>Type: <?=$type?></h4>
        
            <form method="POST" action="./store_value.php" enctype="multipart/form-data">
                <label for="value">
                    Value
                    <input type="number" step=any name="value"/>
                </label>
                <label for="image">
                    Image of meter
                    <input type="file" accept="image/*" capture="enironment" name="image" />
                </label>
                <input type="hidden" name="type" value="<?=$type?>"/>
                <button type="submit">Submit</button>
            </form>

        </main>
    </body>


</html>