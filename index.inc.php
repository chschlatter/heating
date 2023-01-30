<html>

<?php include(__DIR__ . '/html_head.inc.php'); ?>

    <body>
        <main class="container">
            <h1><?php echo APP_NAME ?></h1>

            <article>
                <ul style="margin-bottom: 0;">
<?php foreach (METER_TYPES as $meter_type): ?>
                    <li><a href="./add.php?type=<?= $meter_type ?>"><?= $meter_type ?></a>
<?php endforeach; ?>
                </ul>
            </article>

            <div>
<?php foreach ($values_per_date as $date => $values_per_house): ?>
                <div>
                    <h2 style="margin-bottom: 0;"><?= $date ?></h2>

                    <div class="grid">
                        <div>
    <?php foreach ($values_per_house['C'] as $values): ?>
                            <article>
                                <p><strong><?php echo $values['type']; ?></strong><br>
                                Wert: <?php echo $values['value']; ?></p>    
                            
        <?php if ($values['filename']): ?>
                                <img src="./uploads/<?= $values['filename'] ?>" />
        <?php endif; ?>
                            </article>

    <?php endforeach; ?>
                        </div>

                        <div>
    <?php foreach ($values_per_house['D'] as $values): ?>
                            <article>
                                <p><strong><?php echo $values['type']; ?></strong><br>
                                Wert: <?php echo $values['value']; ?></p>    
                            
        <?php if ($values['filename']): ?>
                                <img src="./uploads/<?= $values['filename'] ?>" />
        <?php endif; ?>
                            </article>

    <?php endforeach; ?>
                        </div>
                    </div>
                </div>

<?php endforeach; ?>

            </div>

        </main>
    </body>


</html>