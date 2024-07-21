<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Morte AI</title>
</head>
<body>
    <form action="" method="post">
        <label for="playerInput"><?= $prompt ?></label>
        <?php if($input != false): ?>
            <input type="text" name="playerInput" > 
        <?php endif; ?>
        <input type="hidden" name="playerName" value="<?= $playerName ?>">
        <input type="submit" value="Enviar">
    </form>
</body>
</html>