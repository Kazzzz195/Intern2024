<?php
session_start();
// 接続
$mysqli = new mysqli('localhost', 'brightech', 'brightech', 'test');

//接続状況の確認
if($mysqli->connect_error){
        echo $mysqli->connect_error;
        exit();
}


//get session 
  $user_id = $_SESSION['user_id'] ;
  
//join table
  $stmt = $mysqli->prepare('SELECT * FROM `trx_comments` AS `comments`
  	  JOIN `trx_users` AS `users` ON `users`.`id` = `comments`.`user_id`;  '); 
  $stmt->execute();
  $result = $stmt->get_result();
  

    // 入力されたテキストを取得
    $text = htmlspecialchars($_POST['comment'], ENT_QUOTES, "UTF-8");

    // コメントを挿入
    $stmt2 = $mysqli->prepare("INSERT INTO trx_comments(user_id, text) VALUES (?,?)"); 
    $stmt2->bind_param("is", $user_id, $text);
    $stmt2->execute();


echo "<table>\n";
echo "<tr><th>ID</th><th>ユーザ名</th><th>コメント</th></tr>\n";
while($row = $result->fetch_assoc() ){
    // 何行も文字列書くときはこのようなヒアドキュメントが便利
    $html = <<<TEXT
while($row = $result->fetch_assoc()){
    echo "<tr>\n";
    echo "<td>{$row['id']}</td>\n";
    echo "<td>{$row['user_name']}</td>\n";
    echo "<td>{$row['text']}</td>\n";
    echo "</tr>\n";
}
TEXT;
    echo $html;
}


echo "</table>";


// HTML内でユーザー名を表示
echo "ログイン中のユーザー名: $user_id";


?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>ログイン</h2>
		<form action="" method="post">
		  text: <input type="text" name="comment" /><br/>
		  <input type="submit" />
		</form>
	</body>
</html>

