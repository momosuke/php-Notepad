<?php
$usrnum = $_COOKIE['user_num_cookie'];
$shstr = htmlspecialchars($_POST['shstr']);
$shstr = stripslashes($shstr);
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
<head><title>
<?php
 if(empty($shstr)) echo 'メモ帳 > 検索[入力なし]';
 else              echo 'メモ帳 > 検索['.$shstr.']';
?>
</title></head>
<body><center>
<table border=0 width=80% height=85%><tr><td valign=top height=100><hr>
<h1>メモ帳</h1>
<hr>
<?php
if(empty($shstr)){
  print('入力がありません．');
  $check = false;
}else{
  require('function.php');
  $check = true;
  $shnum = 0;
  $contents = '';
}
if($check){
  echo '<ul>';
  // トップ
  $file = getfile($usrnum);
  if($file){
    foreach($file as $num){
      $str = "";
      $shflag = false;
      $shcount = 0;
      $flurl = 'user'.$usrnum.'/file/'.$num.".txt";
      $text  = file_get_contents($flurl);
      $buff  = explode("\n", $text);
      for($i=0;$i<count($buff);$i++){
        if(mb_ereg($shstr,$buff[$i])){
          if($i!=0){
            if($shcount < 5) $str .= $buff[$i].'<br>';
            $shcount++;
          }
          $shflag = true;
        }
      }
	  $shnum += $shcount;
      if($shflag){
        $contents .= '■<a href="view.php?title='.$num.'">';
        $contents .= $buff[0].'</a>';
        $contents .= '<b>[一致したデータ: '.$shcount.'件]</b>';
        $contents .= '<br>'.$str.'<br>';
      }
    }
  }
  // フォルダ及び内部ファイル
  $folder = getfolder($usrnum);
  if($folder){
    foreach($folder as $fnum){
      $ftitle = popfoldertitle( $usrnum, $fnum );
                                                           /**
      if(mb_ereg($shstr,$ftitle)){       // フォルダ名と一致
        $contents .= '■<a href="./?folder='.$fnum.'">';
        $contents .= $ftitle.'</a><br>';
      }
                                                           /**/
      $file = getfolderfile( $usrnum, $fnum );
      $maxnum = 0;
      if($file){
        foreach($file as $num){
          $sortfile[$num] = $num;
          if($num>$maxnum) $maxnum = $num;
        }
        for($i=1; $i<$maxnum+1; $i++){
          if($sortfile[$i]){
            $num = $sortfile[$i];
            $str = "";
            $shflag = false;
            $shcount = 0;
            $flurl = 'user'.$usrnum.'/file/folder'.$fnum.'/'.$num.".txt";
            $text  = file_get_contents($flurl);
            $buff  = explode("\n", $text);
            for($j=0;$j<count($buff);$j++){
              if(mb_ereg($shstr,$buff[$j])){
                if($j!=0){
                  if($shcount < 5) $str .= $buff[$j].'<br>';
                  $shcount++;
                }
                $shflag = true;
              }
            }
            $shnum += $shcount;
            if($shflag){
              $contents .= '■'.$ftitle.' -> ';
              $contents .= '<a href="view.php?folder='.$fnum.'&title='.$num.'">';
              $contents .= $buff[0].'</a>';
              $contents .= '<b>[一致したデータ: '.$shcount.'件]</b>';
              $contents .= '<br>'.$str.'<br>';
            }
          }
        }
      } // fileの有無
    }
  } // folderの有無
  echo '</ul>';
  if($shnum>0){
    echo '<h3>"'.$shstr.'" に一致したデータ('.$shnum.'件)</h3>';
    echo $contents;
  }else{
    echo '<b>"'.$shstr.'"'." に一致するデータは見つかりませんでした．</b><p>";
  }
}
// 戻る
echo '</td></tr><tr><td height=70><hr><p>';
$cfolder = @$_POST['folder'];
if($cfolder){
  echo '<p><a href="./?folder='.$cfolder.'">戻る</a>';
  echo '&nbsp;&nbsp;&nbsp;<a href="./">トップに戻る</a>';
} else {
  echo '<p><a href="./">トップに戻る</a>';
}
?>
</td></tr></table>
</body>
</html>
