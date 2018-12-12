<?php
//入力チェック(受信確認処理追加)is がセットされてなかったらParamError (isはname email)
if(
  !isset($_POST["name"]) || $_POST["name"]=="" ||
  !isset($_POST["email"]) || $_POST["email"]==""   
){
  exit('ParamError');
}

//1. POSTデータ取得
$name   = $_POST["name"];
$email  = $_POST["email"];
$naiyou = $_POST["naiyou"];

//2. DB接続します(エラー処理追加)毎回コピペ
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}

//３．データ登録SQL作成
$sql = "INSERT INTO gs_an_table02(id, name, email, naiyou, indate) VALUES(NULL, :name, :email, :naiyou, sysdate())";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':email', $email PDO::PARAM_STR);  //Integer（数値の場合PDO::PARAM_INT)
$stmt->bindValue(':naiyou', $naiyou, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後 --毎回コピペ
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);

}else{
  //５．index.phpへリダイレクト
  header("Location: index.php");
  exit;

}
?>