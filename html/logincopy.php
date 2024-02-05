<?php
session_start();

//MySQLに接続
$mysqli = new mysqli('localhost', 'brightech', 'brightech', 'test');

if ($mysqli->connect_error) {
  echo $mysqli->connect_error;
  exit();
}

/**
 * 課題２：データベースにPOSTで取得したusername,password(ハッシュ化)と一致するものがあればセッションを開始し
 * $_SESSION['user_id']にユーザIDを,$_SESSION['user_name']にユーザ名を格納する処理を書いてください
 */
##
$user_name = htmlspecialchars($_POST['user_name'], ENT_QUOTES, "UTF-8");
$password = htmlspecialchars($_POST['password'], ENT_QUOTES, "UTF-8");

if (!is_null($user_name) && !is_null($password)) {
  $stmt = $mysqli->prepare('SELECT * FROM trx_users WHERE user_name = ?');
  $stmt->bind_param('s', $user_name);
  $stmt->execute();
  $result = $stmt->get_result()->fetch_assoc();

  if (!is_null($result) && (hash('sha256', $password) == $result['password'])) {
    $_SESSION['user_id'] = $result['id'];
  } else {
    echo "ログインに失敗しました</br>";
    session_destroy();
  }
}

// $user_name = null;
// $password = null;
// session_destroy();


if (isset($_SESSION['user_id'])) {
  // SESSION[user_id]に値入っていればログインしたとみなす

  echo "既にログインしています";
}
if (!isset($_SESSION['user_id'])) {
  // SESSION[user_id]に値入っていればログインしたとみなす

  echo '<section>
        <form action="logincopy.php" method="post">
            名前:<br>
            <input type="text" name="user_name" value="" required><br>
            <br>
            パスワード:<br>
            <input type="password" name="password" value="" required><br>
            <button type="submit">登録</button>
        </form>
    </section>';
}


$mysqli->close();
