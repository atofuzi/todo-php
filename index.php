<?php
require('function.php');

// Todo一覧を取得
// $todos = getTodos();
// debug($_POST['age']);
// debug($_POST['name']);
// // Todoを追加
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['task'])) {
//     $todo = htmlspecialchars($_POST['task']);
//     saveTodo($todo);
//     header('Location: ' . $_SERVER['PHP_SELF']);
// }

// // Todoの完了状態を切り替え
// if (isset($_GET['toggle'])) {
//     $id = $_GET['toggle'];
//     $is_completed = $_GET['is_completed'];

//     toggleComplated($id, $is_completed);
//     header('Location: ' . $_SERVER['PHP_SELF']);
// }

// // Todoを削除
// if (isset($_GET['delete'])) {
//     $id = $_GET['delete'];
//     // TODO: バリデーション
//     deleteTodo($id);
//     header('Location: ' . $_SERVER['PHP_SELF']);
// }
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars("Todo \n リスト", ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>火災保険申込フォーム</h1>
        <form method="post" action="">
            <input type="text" name="name" placeholder="お名前"  value="<?php echo $_POST["name"]?>">
            <input type="text" name="age" placeholder="年齢" value="<?php echo $_POST["age"]?>">
            <input type="text" name="fire-type" placeholder="申込商品名" value="<?php echo $_POST["fire-type"]?>">
            <input type="submit" value="送信">
        </form>
        <!-- <form method="post" action="">
            <input type="text" name="task" placeholder="新しいタスクを入力" required>
            <input type="submit" value="追加">
        </form>

        <ul class="todo-list">
            <?php foreach ($todos as $todo) : ?>
                <li class="<?php echo $todo['is_completed'] ? 'completed' : ''; ?>">
                    <span class="task"><?php echo $todo['task']; ?></span>
                    <div class="actions">
                        <a href="?toggle=<?php echo $todo['id']; ?>&is_completed=<?php echo $todo['is_completed'] ?>" class="toggle"><?php echo $todo['is_completed'] ? '✓' : '○'; ?></a>
                        <a href="?delete=<?php echo $todo['id']; ?>" class="delete">×</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul> -->
    </div>
</body>

</html>