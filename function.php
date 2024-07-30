<?php
require('pdo.php');

//================================
// ログ
//================================
//ログを取るか
ini_set('log_errors', 'on');
//ログの出力ファイルを指定
ini_set('error_log', 'php.log');

//================================
// デバッグ
//================================
//デバッグフラグ
$debug_flg = true;
//デバックログ関数
function debug($str)
{
    global $debug_flg;
    if (!empty($debug_flg)) {
        error_log('デバッグ：' . $str);
    }
}

/**
 * Todoの取得
 * @param int $id 取得対象のTodoのID
 *
 * @return array
 */
function getTodo(int $id): array
{
    try {
        $dbh = dbConnect();
        $sql = 'SELECT * FROM todos WHERE id = :id';
        $data = [
            ':id' => $id
        ];

        $stmt = queryPost($dbh, $sql, $data);

        if ($stmt) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result : [];
        } else {
            throw new Exception("SQLエラー " . $sql);
        }
    } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
    }
}

/**
 * TODOリスト一覧の取得
 *
 * @return array
 */
function getTodos(): array
{
    try {
        $dbh = dbConnect();
        $sql = 'SELECT * FROM todos';

        $stmt = queryPost($dbh, $sql, null);

        if ($stmt) {
            return $stmt->fetchAll();
        } else {
            throw new Exception("SQLエラー " . $sql);
        }
    } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
    }
}

/**
 * TODOリストの保存
 * @param String $task
 * 
 */
function saveTodo($task): void
{
    try {
        $dbh = dbConnect();
        $sql = 'INSERT INTO todos (task, created_at, updated_at) VALUE (:task, :created_at, :updated_at)';
        $data = [
            ':task' => $task,
            ':created_at' => date('Y-m-d H:i:s'),
            ':updated_at' => date('Y-m-d H:i:s'),
        ];
        queryPost($dbh, $sql, $data);
    } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
    }
}

/**
 * TODOリストの削除
 * @param integer $id
 * 
 */
function deleteTodo($id): void
{
    try {
        $dbh = dbConnect();
        $sql = 'DELETE FROM todos WHERE id = :id';
        $data = [
            ':id' => $id
        ];
        queryPost($dbh, $sql, $data);
    } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
    }
}

/**
 * TODOリストの完了・未完了切り替え
 * @param integer $id
 * @param bool $is_completed
 * 
 */
function toggleComplated($id, $is_completed): void
{
    try {
        $dbh = dbConnect();
        $sql = 'UPDATE todos SET is_completed = :is_completed, updated_at = :updated_at WHERE id = :id';
        $data = [
            ':is_completed' => $is_completed ? 0 : 1,
            ':updated_at' => date('Y-m-d H:i:s'),
            ':id' => $id
        ];
        queryPost($dbh, $sql, $data);
    } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
    }
}


//================================
// バリデーションメソッド
//================================
/**
 * 完了状態更新時のパラメータのバリデーションチェック
 *
 * @param mixed $id
 * @param mixed $is_completed
 * @return boolean
 */
function validateToggleComplete($id, $is_completed): bool
{
    // クエリパラメータの場合、数値文字列のためis_numericを使用
    if (!is_numeric($id)) return false;
    if (!is_numeric($is_completed)) return false;

    // NOTE: is_completedには0か1以外の数値が入ってくるはずがないため、そのチェックを行なっている
    // 数値文字列のため、厳密比較を行うためにint型にキャストしている
    if ((int)$is_completed !== 0 && (int)$is_completed !== 1) return false;
    return true;
}

/**
 * タスク削除時のパラメータのバリデーションチェック
 *
 * @param mixed $id
 * @return boolean
 */
function validateDeleteTodo($id): bool
{
    if (!is_numeric($id)) return false;
    return true;
}

/**
 * Todoの存在チェック
 *
 * @param int $id チェック対象のTodoのID
 * @return bool
 */
function validateExistTodo(int $id): bool
{
    return !empty(getTodo($id)) ? true : false;
}
