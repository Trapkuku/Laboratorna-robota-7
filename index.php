<?php
session_start();

if (!isset($_SESSION['field'])) {
    $_SESSION['field'] = [
        ['', '', ''],
        ['', '', ''],
        ['', '', '']
    ];
}
$field = $_SESSION['field'];

// Обработка хода игрока и бота
if (isset($_GET['i']) && isset($_GET['j'])) {
    $turn_i = intval($_GET['i']);
    $turn_j = intval($_GET['j']);
    if ($turn_i >= 0 && $turn_i < 3 && $turn_j >= 0 && $turn_j < 3 && $field[$turn_i][$turn_j] === '') {
        $field[$turn_i][$turn_j] = 'x';

        $bot_placed = false;
        for ($i = 0; $i < 3 && !$bot_placed; $i++) {
            for ($j = 0; $j < 3 && !$bot_placed; $j++) {
                if ($field[$i][$j] === '') {
                    $field[$i][$j] = 'o';
                    $bot_placed = true;
                }
            }
        }
        $_SESSION['field'] = $field;
    }
}

if (isset($_POST['reset'])) {
    unset($_SESSION['field']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Хрестики нолики</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
<div class="board-container">
    <table>
        <?php
        for ($i = 0; $i < 3; $i++) {
            echo '<tr>';
            for ($j = 0; $j < 3; $j++) {
                $cell_value = $field[$i][$j];
                echo '<td>';
                if ($cell_value === '') {
                    echo "<form method='get' style='margin:0'>
                        <input type='hidden' name='i' value='$i'>
                        <input type='hidden' name='j' value='$j'>
                        <input type='submit' value=''>
                    </form>";
                } else {
                    echo $cell_value;
                }
                echo '</td>';
            }
            echo '</tr>';
        }
        ?>
    </table>
</div>
<form action="" method="post">
    <button type="submit" name="reset" class="reset-btn">Перезапустити гру</button>
</form>
</body>
</html>
