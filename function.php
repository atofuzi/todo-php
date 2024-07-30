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
 * Todoリスト一覧の取得
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
 * Todoリストの保存
 * 
 * @param String $task
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
 * Todoの削除
 * 
 * @param int $id
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
 * Todoの完了・未完了切り替え
 * 
 * @param int $id
 * @param bool $is_completed
 */
function toggleComplated($id, $is_completed): void
{
    var_dump((bool)$is_completed);
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
