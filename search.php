<?php
$usrnum = $_COOKIE['user_num_cookie'];
$shstr = htmlspecialchars($_POST['shstr']);
$shstr = stripslashes($shstr);
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
<head><title>
<?php
 if(empty($shstr)) echo '���Ģ > ����[���Ϥʤ�]';
 else              echo '���Ģ > ����['.$shstr.']';
?>
</title></head>
<body><center>
<table border=0 width=80% height=85%><tr><td valign=top height=100><hr>
<h1>���Ģ</h1>
<hr>
<?php
if(empty($shstr)){
  print('���Ϥ�����ޤ���');
  $check = false;
}else{
  require('function.php');
  $check = true;
  $shnum = 0;
  $contents = '';
}
if($check){
  echo '<ul>';
  // �ȥå�
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
        $contents .= '��<a href="view.php?title='.$num.'">';
        $contents .= $buff[0].'</a>';
        $contents .= '<b>[���פ����ǡ���: '.$shcount.'��]</b>';
        $contents .= '<br>'.$str.'<br>';
      }
    }
  }
  // �ե�����ڤ������ե�����
  $folder = getfolder($usrnum);
  if($folder){
    foreach($folder as $fnum){
      $ftitle = popfoldertitle( $usrnum, $fnum );
                                                           /**
      if(mb_ereg($shstr,$ftitle)){       // �ե����̾�Ȱ���
        $contents .= '��<a href="./?folder='.$fnum.'">';
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
              $contents .= '��'.$ftitle.' -> ';
              $contents .= '<a href="view.php?folder='.$fnum.'&title='.$num.'">';
              $contents .= $buff[0].'</a>';
              $contents .= '<b>[���פ����ǡ���: '.$shcount.'��]</b>';
              $contents .= '<br>'.$str.'<br>';
            }
          }
        }
      } // file��̵ͭ
    }
  } // folder��̵ͭ
  echo '</ul>';
  if($shnum>0){
    echo '<h3>"'.$shstr.'" �˰��פ����ǡ���('.$shnum.'��)</h3>';
    echo $contents;
  }else{
    echo '<b>"'.$shstr.'"'." �˰��פ���ǡ����ϸ��Ĥ���ޤ���Ǥ�����</b><p>";
  }
}
// ���
echo '</td></tr><tr><td height=70><hr><p>';
$cfolder = @$_POST['folder'];
if($cfolder){
  echo '<p><a href="./?folder='.$cfolder.'">���</a>';
  echo '&nbsp;&nbsp;&nbsp;<a href="./">�ȥåפ����</a>';
} else {
  echo '<p><a href="./">�ȥåפ����</a>';
}
?>
</td></tr></table>
</body>
</html>
