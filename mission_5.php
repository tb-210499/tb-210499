<?php
$dsn = 'mysql:dbname=tb210499db;host=localhost';
$user ='tb-210499';
$password ='UTEjy8bdDh';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

$sql = "CREATE TABLE IF NOT EXISTS tbtest_neo"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"//投稿番号のカラム
	. "name char(32),"//名前のカラム
	. "comment TEXT,"//コメントのカラム
	. "date_t TIMESTAMP,"//日付のカラム
	. "pass TEXT"//パスワードのカラム
	.");";
	$stmt = $pdo->query($sql);
	
	//カラム名を表示
//$sql="DESCRIBE tbtest_neo";
//	$result = $pdo -> query($sql);
//		foreach ($result as $row){
//			echo $row[0];
	//		echo '<br>';
//		}
//		echo "<hr>";
?>

<html>

<head>
  <meta charset="utf-8">
</head>

<body>

<?php
	if(!empty($_POST["hensu"])){   //編集番号が空じゃなかったら
	if(!empty($_POST["pass_h"])){  //パスワードが空ではなかったとき
		$hensuget=$_POST["hensu"];
		$pass_h_get=$_POST["pass_h"];
		
		$sql="SELECT * FROM tbtest_neo WHERE id=$hensuget";
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			$hen_pass = $row["pass"];
			//パスワードが一致していた場合
			if($pass_h_get==$hen_pass){
				$hennumber = $row["id"];
				$henname = $row["name"];
				$hencomment = $row["comment"];
			}
		}
	}
	}
?>

  <form action="mission_5.php" method="POST">
        名前:<input type="text" name="name" placeholder="お名前"
              value=<?php if(!empty($henname)){
                           echo $henname;
                          } ?>
             ><br>
    コメント:<input type="text" name="comment" size="30" placeholder="コメントを記入してください"
              value=<?php if(!empty($hencomment)){
                           echo $hencomment;
                          } ?>
             ><br>
             <input type="hidden" name="henban" 
               value=<?php if(!empty($hennumber)){
                           echo $hennumber;
                          } ?>
             >
  パスワード:<input type="password" name="pass_n_c"><br>
             <input type="submit" value="送信">
  </form>

  <form action="mission_5.php" method="POST">
     削除番号:<input type="number" name="delete" placeholder="番号"><br>
   パスワード:<input type="password" name="pass_d"><br>
              <input type="submit" value="削除"><br>

  </form>
  <form action="mission_5.php" method="POST">
     編集番号:<input type="number" name="hensu" placeholder="番号"><br>
   パスワード:<input type="password" name="pass_h"><br>
              <input type="submit" value="編集"><br>
  </form>
</body>
</html>

<?php

			//編集機能
	
if(!empty($_POST["name"])){    //名前が空白でなかった場合、名前を取得
if(!empty($_POST["comment"])){  //コメントが空白ではなかった場合、コメントを取得
	if(!empty($_POST["henban"])){  //隠された番号入力フォームから編集番号が送られてきたら
	if(!empty($_POST["pass_n_c"])){
		$passget_h=$_POST["pass_n_c"];
		$henban_get=$_POST["henban"];  //編集番号を変数に格納
		$name_h=$_POST["name"];
		$comment_h=$_POST["comment"];
		$date_h=date("Y/m/d H:i:s");

		$sql="SELECT * FROM tbtest_neo WHERE id=$henban_get";
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
			foreach ($results as $row){
			$pass_g = $row["pass"];
				if($passget_h==$pass_g){
					$id=$henban_get;
					$name=$name_h;
					$comment=$comment_h;
					$date=$date_h;
					$pass=$passget_h;	
					$sql_h = 'update tbtest_neo set name=:name,comment=:comment,date_t=:date_t,pass=:pass where id=:id';
					$stmt = $pdo->prepare($sql_h);
					$stmt->bindParam(':name', $name, PDO::PARAM_STR);
					$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
					$stmt->bindParam(':date_t', $date, PDO::PARAM_STR);
					$stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
					$stmt->bindParam(':id', $id, PDO::PARAM_INT);
					$stmt->execute();
				}
			}
	}
	}else{ //隠されたフォームから何も送られてきていない場合

                    //	新規投稿

	if(!empty($_POST["name"])){    //名前が空白でなかった場合、名前を取得
	if(!empty($_POST["comment"])){    //コメントが空白でなかった場合、コメントを取得
	if(!empty($_POST["pass_n_c"])){  //パスワードが空白ではなかった場合、
		$nameget=$_POST["name"];
		$commentget=$_POST["comment"];
		$date_get=date("Y/m/d H:i:s");
		$pass_get=$_POST["pass_n_c"];  //送られてきたデータを変数に格納

		//それぞれのカラムに入力していく
		$sql = $pdo -> prepare("INSERT INTO tbtest_neo (name, comment,date_t,pass) VALUES (:name, :comment, :date_t, :pass)");
		$sql -> bindParam(':name', $nameget, PDO::PARAM_STR);
		$sql -> bindParam(':comment', $commentget, PDO::PARAM_STR);
		$sql -> bindParam(':date_t', $date_get, PDO::PARAM_STR);
		$sql -> bindParam(':pass', $pass_get, PDO::PARAM_STR);
		$name = $nameget;
		$comment = $commentget;
		$date=$date_get;
		$pass=$pass_get;
		$sql -> execute();
	}
	}
	}
	}
}
}
	//削除機能

	if(!empty($_POST["delete"])){    //削除番号欄が空じゃなかったら
	if(!empty($_POST["pass_d"])){    //パスワードが空じゃなかったら
		$delete_d=$_POST["delete"];
		$passget_d=$_POST["pass_d"];

		//select文で送られてきた番号と一致するidのレコードを取得する
		$sql="SELECT * FROM tbtest_neo WHERE id=$delete_d";
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			$password = $row["pass"];
			//パスワードが一致していたら削除する
			if($passget_d == $password){
				$sql = 'delete from tbtest_neo where id=:id';
				$stmt = $pdo->prepare($sql);
				$stmt->bindParam(':id', $delete_d, PDO::PARAM_INT);
				$stmt->execute();
			}
		}
	}
	}
		//表示機能
		
		$sql = 'SELECT * FROM tbtest_neo';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			//$rowの中にはテーブルのカラム名が入る
				echo $row['id'].',';
				echo $row['name'].',';
				echo $row['comment'].',';
				echo $row['date_t'].'<br>';
				echo "<hr>";
		}
?>