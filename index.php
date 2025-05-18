<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Хрестики нолики</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
session_start();
if (!isset($_SESSION['field'])){
    $_SESSION['field'] = [
        ['','',''],
        ['','',''],
        ['','','']
    ];
}
if (isset($_GET['i']) && isset($_GET['j'])){
    $turn_i = intval($_GET['i']);
    $turn_j = intval($_GET['j']);
    // Защита от выхода за границы
    if ($turn_i >= 0 && $turn_i < 3 && $turn_j >= 0 && $turn_j < 3 && $_SESSION['field'][$turn_i][$turn_j] === '') {
        $_SESSION['field'][$turn_i][$turn_j] = 'x';

        $field = $_SESSION['field'];

        for($i = 0; $i < 2; $i++) {
            $bot_row_count = 0;
            $bot_column_count = 0;
            for ($j = 0; $j < 2; $j++) {
                if ($field[$i][$j] === 'o') {
                    $bot_row_count++;
                }
                if ($field[$j][$i] === 'o') {
                    $bot_column_count++;
                }
                if ($bot_row_count >= 2) {
                    $field[$i][0] = 'o';
                    $field[$i][1] = 'o';
                    $field[$i][2] = 'o';
                }
                if ($bot_column_count >= 2) {
                    $field[0][$i] = 'o';
                    $field[1][$i] = 'o';
                    $field[2][$i] = 'o';
                }
            }
        }

        // Цикл для соседних клеток: были ошибки (не увеличивался $i, некорректное условие для $j, сравнивалось с пробелом вместо пустой строки)
        for($i = $turn_i - 1; $i <= $turn_i + 1; $i++) {
            for($j = $turn_j - 1; $j <= $turn_j + 1; $j++){
                if($i < 0 || $j < 0 || $i > 2 || $j > 2) {
                    continue;
                }
                if($i !== $turn_i && $j !== $turn_j && $field[$i][$j] === '') {
                    $field[$i][$j] = 'o';
                    break 2;
                }
            }
        }
        $_SESSION['field'] = $field;
    }
} else {
    $field = $_SESSION['field'];
}
?>

<table>
    <?php
    $field = $_SESSION['field'];
    for($i=0; $i < 3; $i++)
    {
        echo '<tr>';
        for($j = 0; $j < 3; $j++){
            $cell_value = $field[$i][$j];
            echo '<td>';
            echo "<form method='get' style='margin:0'>
                <input type='hidden' name='i' value='$i'>
                <input type='hidden' name='j' value='$j'>
                <input type='submit' value='$cell_value'>
            </form>";
            echo '</td>';
        }
        echo '</tr>'; // было <tr>, должно быть </tr>
    }
    ?>
</table>
<a href="/reset.php">Перезапустити гру</a>
</body>
</html>
