<html>
<head>
	<meta charset="utf-8">
	<title>身内専用掲示板</title>
</head>
<body>	
	<?php
	$i = 0;
	$filename = "mission_3-5.txt";
	if(isset($_POST["comment"]) && $_POST["comment"] != ""
	&& isset($_POST["namae"]) && $_POST["namae"] != ""){//投稿フォーム
		$n = $_POST["namae"];
		$c = $_POST["comment"];
		$time = date("Y/m/d H:i:s");
		$pass = $_POST["pass"];
		if($_POST["sonzai"] != ""){//編集投稿
			$fp = fopen($filename,"r");//削除フォームの要領でファイルを取得していく
			$filehairetu = file($filename);
			$filecount = count($filehairetu);
			$fp = fopen($filename,"w");
			while($filecount > 0){
				$bangou = explode("<>",$filehairetu[$i]);
				if($bangou[0] == $_POST["sonzai"]){
					if($bangou[4] != $_POST["pass"] || empty($bangou[4])){//PASSの整合性を確認
						echo "パスワードが違います。"."<br>";
						fwrite($fp,$filehairetu[$i]);
					}else{
						fwrite($fp,$bangou[0]."<>".$n."<>".$c."<>".$time."<>".$pass."\r\n");
					}
				}else{
					fwrite($fp,$filehairetu[$i]);
				}
				$filecount = $filecount - 1;
				$i = $i + 1;
			}
			fclose($fp);
		}else{//新規投稿
			$fp = fopen($filename,"a");
			$count = count(file($filename)) + 1;
			fwrite($fp,$count."<>".$n."<>".$c."<>".$time."<>".$pass."<>"."\r\n");
		}
		$fp = fopen($filename,"r");//投稿を表示する
		while(!feof($fp)){
			$hairetu = fgets($fp);
			$youso = explode("<>",$hairetu);
			echo $youso[0]."<>".$youso[1]."<>".$youso[2]."<>".$youso[3]."<br>";	
		}
	}else if(isset($_POST["sakuzyo"]) && $_POST["sakuzyo"] != "") {//削除フォーム
		$fp = fopen($filename,"r");
		$filehairetu = file($filename);
		$filecount = count($filehairetu);
		$fp = fopen($filename,"w");
		while($filecount > 0){
			$bangou = explode("<>",$filehairetu[$i]);
			if($bangou[0] == $_POST["delete"]){
				if($bangou[4] != $_POST["sakupass"] || empty($bangou[4])){
					$count = count(file($filename)) + 1;
					echo "パスワードが違います。"."<br>";
					fwrite($fp,$count."<>".$bangou[1]."<>".$bangou[2]."<>".$bangou[3]."<>".$bangou[4]."<>"."\r\n");	
				}
			}else{
				$count = count(file($filename)) + 1;
				fwrite($fp,$count."<>".$bangou[1]."<>".$bangou[2]."<>".$bangou[3]."<>".$bangou[4]."<>"."\r\n");	
			}
			$filecount = $filecount - 1;
			$i = $i + 1;
		}
		$fp = fopen($filename,"r");//投稿を表示する
		while(!feof($fp)){
			$hairetu = fgets($fp);
			$youso = explode("<>",$hairetu);
			echo $youso[0]."<>".$youso[1]."<>".$youso[2]."<>".$youso[3]."<br>";	
		}
	}else if (isset($_POST["sub"]) && $_POST["sub"] != "") {//編集フォーム
		$filehairetu = file($filename);
		$filecount = count($filehairetu);
		while($filecount > 0){
			$bangou = explode("<>",$filehairetu[$i]);
			if($bangou[0] == $_POST["hen"]){
				$henname = $bangou[1];
				$hencomment = $bangou[2];
			}
			$filecount = $filecount - 1;
			$i = $i + 1;
		}
	}else{
		echo "※お名前とコメントを送信して下さい。".'<br>'.
"コメントを削除する場合は半角数字で投稿番号を入力して下さい。";
	}
	?>
	<form method = "post" form action = "mission_3-5.php">
		編集番号:<input type = "text" name = "hen"><br>
		<input type = "submit" name = "sub" value = "送信"><br><br>
		お名前:  <input type = "text" name = "namae" value= "<?php if(!empty($henname)) echo $henname; ?>" ><br>
		コメント:<input type = "text" name = "comment" value = "<?php if(!empty($hencomment)) echo $hencomment; ?>" ><br>
		PASS：<input type = "text" name = "pass" >
		<input type = "submit" name = "submit" value = "送信"><br><br>
		削除:<input type = "text" name = "delete"><br>
		PASS：<input type = "text" name = "sakupass" >
		<input type = "submit" name = "sakuzyo" value = "送信"><br>
		<input type = "hidden" name = "sonzai" value = "<?php if(!empty($_POST["hen"])) echo $_POST["hen"]; ?>">
	
	</form>
</body>
</html>	

