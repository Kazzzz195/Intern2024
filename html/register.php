
<section>
    <form action="" method="post">
        名前:<br>
        <input type="text" name="name" value=""><br>
        <br>
        パスワード:<br>
        <input type="text" name="password" value=""><br>
        <input type="submit" value="登録">
    </form>
    
</section>
<?php
// 接続
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$mysqli = new mysqli('localhost', 'brightech', 'brightech', 'test');

//接続状況の確認
if($mysqli->connect_error){
        echo $mysqli->connect_error;
        echo "データベースに接続できませんでした。";
        exit();
}else{
        $mysqli->set_charset('utf8');
}


$name = htmlspecialchars($_POST['name'], ENT_QUOTES, "UTF-8"); 
$pass = htmlspecialchars($_POST['password'], ENT_QUOTES, "UTF-8"); 

$stmt = $mysqli->prepare("INSERT INTO `trx_users ` ( `user_name`, `password`) VALUES (?,?);");
$stmt->bind_param('ss', $user_name,$password);
  $stmt->execute();
if ($stmt === false) {
    die('prepare() に失敗しました: ' . htmlspecialchars($mysqli->error));
    error_log("SQLエラー: " . $mysqli->error);
    echo "データベースエラーが発生しました。";
}

$stmt->bind_param("ss", $name, $pass);
$stmt->execute();

if ($stmt === false) {
    die('execute() に失敗しました: ' . htmlspecialchars($stmt->error));
    error_log("SQLエラー: " . $mysqli->error);
    echo "データベースエラーが発生しました。";
}

error_log("SQLエラー: " . $mysqli->error);
    echo "データベースエラーが発生しました。";
    exit();

// 切断
$mysqli->close();
header("Location: ./login.php");
exit();
}
?>



