<?php
  session_start();
  //MySQLに接続
  $mysqli = new mysqli('localhost', 'brightech', 'brightech', 'test');

  if($mysqli->connect_error){
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
  $stmt = $mysqli->prepare('SELECT * FROM trx_users WHERE user_name =? '); 
  $stmt->bind_param('s', $user_name);
  $stmt->execute();
  $result = $stmt->get_result()->fetch_assoc();
  // var_dump($stmt);
  // var_dump($user_name);
  // var_dump($password);
  //var_dump($result['password']);
  // var_dump($result);
  
  if(!is_null($result) && (hash('sha256', $password) == $result['password'])){ 
  
    $_SESSION['user_id'] = $result['id'];
  }else {
   session_destroy();
  }
  
  
  if(isset($_SESSION['user_id'])) {
    // SESSION[user_id]に値入っていればログインしたとみなす
   
	  echo "既にログインしています";
    header("Location: ./table.php");
   
  }
  $mysqli->close();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>ログイン</h2>
		<form action="login.php" method="post">
		  ユーザ: <input type="text" name="user_name" /><br/>
		  パスワード: <input type="password" name="password" /><br/>
		  <input type="submit" />
		</form>
    <form action="./newUser.php">
        <input type="submit" value="新規登録">
    </form>
	</body>
</html>
