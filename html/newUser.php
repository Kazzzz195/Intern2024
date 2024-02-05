<?php
  /**
   * 課題１：mysqliを用いてMySQLに接続し，POSTで受け取ったデータをtrx_usersにINSERTする処理を書いてください
   * パスワードはハッシュ化する必要があるので，以下の$password_hashを用いてください
   */

$mysqli = new mysqli('localhost', 'brightech', 'brightech', 'test');

//接続状況の確認
if($mysqli->connect_error){
        echo $mysqli->connect_error;
        exit();
}else{
        $mysqli->set_charset("utf8");
        echo 'データベース接続成功';
}



	
$name = htmlspecialchars($_POST['username'], ENT_QUOTES, "UTF-8");

$pass = htmlspecialchars($_POST['password'], ENT_QUOTES, "UTF-8");

$password_hash = hash("sha256", $pass);

$stmt = $mysqli->prepare("INSERT INTO trx_users( user_name, password) VALUES (?,?)");
$stmt->bind_param("ss", $name, $password_hash);
$stmt->execute();



// 切断
$mysqli->close();
?>

<!DOCTYPE html>
<html>
  <head>
		<meta charset="utf-8">*:
	</head>
	<body>
		<h2>ユーザ追加</h2>
		<form action="newUser.php" method="post">
		  ユーザ: <input type="text" name="username" /><br/>
		  パスワード: <input type="password" name="password" /><br/>
		  <input type="submit" />
		</form>
	</body>
</html>
