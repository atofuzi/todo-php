<?php
require('function.php');
require('Entity/todo.php');
// TODO一覧を取得
$todos = getTodos();

// タスクを追加
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['task'])) {

    // Todoオブジェクトをインスタンス化
    $todo = new Todo(null, $_POST['task'], true);
    saveTodo($todo);
    header('Location: ' . $_SERVER['PHP_SELF']);
}

// タスクの完了状態を切り替え
if (isset($_GET['toggle'])) {
    $id = $_GET['toggle'];
    $is_completed = $_GET['is_completed'];

    try {
        // パラメータのバリデーションチェック
        if (!validateToggleComplete($id, $is_completed)) {
            throw new InvalidArgumentException();
        }
        // 完了状態の切り替え
        toggleComplated($id, $is_completed);
    } catch (InvalidArgumentException $e) {
        debug("パラメータの値が不正");
    } finally {
        header('Location: ' . $_SERVER['PHP_SELF']);
    }
}

// タスクを削除
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        // クエリパラメータのバリデーションチェック
        if (!validateDeleteTodo($id)) {
            throw new InvalidArgumentException();
        }
        // 削除
        deleteTodo($id);
    } catch (InvalidArgumentException $e) {
        debug("パラメータの値が不正");
    } finally {
        header('Location: ' . $_SERVER['PHP_SELF']);
    }
}
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
        <h1>Todo リスト</h1>

        <form method="post" action="">
            <input type="text" name="task" placeholder="新しいタスクを入力" required>
            <input type="submit" value="追加">
        </form>

        <ul class="todo-list">
            <?php foreach ($todos as $todo) : ?>
                <li class="<?php echo $todo['is_completed'] ? 'completed' : ''; ?>">
                    <span class="task"><?php echo $todo['task']; ?></span>
                    <div class="actions">
                        <a href="?toggle=<?php echo $todo['id']; ?>&is_completed=<?php echo 3; ?>" class="toggle"><?php echo $todo['is_completed'] ? '✓' : '○'; ?></a>
                        <a href="?delete=<?php echo $todo['id']; ?>" class="delete">×</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>

</html>