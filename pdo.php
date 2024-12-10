<?php

/**
 * DB接続関数
 *
 * @return \PDO
 */
function dbConnect(): \PDO
{
    //DBへの接続準備
    // MAMPの場合
    // $dsn = 'mysql:dbname=todo_app;host=localhost;charset=utf8';
    // Dockerの場合
    $dsn = 'mysql:dbname=todo_app;host=mysql;charset=utf8';
    $user = 'root';
    $password = '';
    $options = array(
        // SQL実行失敗時に例外を飛ばす
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // デフォルトフェッチモードを連想配列形式に設定
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // バッファードクエリを使う(一度に結果セットをすべて取得し、サーバー負荷を軽減)
        // SELECTで得た結果に対してもrowCountメソッドを使えるようにする
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    );
    // PDOオブジェクト生成（DBへ接続）
    $dbh = new PDO($dsn, $user, $password, $options);
    return $dbh;
}

/**
 * Undocumented function
 *
 * @param \PDO $dbh
 * @param String $sql
 * @param array|null $data
 * @return \PDOStatement|false
 * 
 * @throws Exception
 */
function queryPost($dbh, $sql, $data): \PDOStatement|false
{
    //クエリー作成
    $stmt = $dbh->prepare($sql);
    //プレースホルダに値をセットし、SQL文を実行
    $stmt->execute($data);
    return $stmt;
}
