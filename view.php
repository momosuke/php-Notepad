<?php
$usrnum = $_COOKIE['user_num_cookie'];
$num = htmlspecialchars($_GET['title']);
$foldernumber = htmlspecialchars(@$_GET['folder']);
if(!empty($num)){
  require('function.php');
  if(empty($foldernumber)){
    $flurl = 'user'.$usrnum.'/file/'.$num.".txt";
    $foldername = "�ȥå�";
  }else{
    $flurl = 'user'.$usrnum.'/file/folder'.$foldernumber.'/'.$num.".txt";
    $foldername = popfoldertitle( $usrnum, $foldernumber );
  }
  $text  = file_get_contents($flurl);
  $text = preg_replace("(\t)", '����', $text);
  $buff  = explode("\n", $text);
}
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
<head><title>
<?php
if(empty($num)) echo '���Ģ > ��⤬����ޤ���';
else            echo '���Ģ > '.$foldername.' > '.$buff[0];
?>
</title></head>
<body><center>
<table border=0 width=80% height=95%><tr><td valign=top height=100><hr>
<?php
if(empty($num)){
  print('��⤬¸�ߤ��ޤ���');
  $check = false;
}else{
  if(empty($foldernumber)){
    echo '<h4><a href="./">'.$foldername.'</a> > '.$buff[0].'</h4>';
    echo '<h1>'.$buff[0].'</h1>';
    echo '<a href="./edit.php?title='.$num.'">�Խ�</a>��';
    echo '<a href="./">������</a>';
  }else{
    echo '<h4><a href="./?folder='.$foldernumber.'">'.$foldername.'</a> > '.$buff[0].'</h4>';
    echo '<h1>'.$buff[0].'</h1>';
    echo '<a href="./edit.php?title='.$num.'&folder='.$foldernumber.'">�Խ�</a>��';
    echo '<a href="./?folder='.$foldernumber.'">������</a>';
  }
  echo '</td></tr><tr><td valign=top><hr>';
  $iflag = 0;
  $tflag = false;
  $line = array('',$iflag,$tflag);
  for($i=1;$i<count($buff);$i++){
    $line[0] = seikei($buff[$i]);
    $line[0] = url($line[0]);
    $line    = ilist ($line[0],$line[1],$line[2]);
    $line    = table ($line[0],$line[1],$line[2]);
    if($line[1]||$line[2]) echo  $line[0];
    else                   echo  $line[0]."<br>";
  }
  $line[0] = "";
  $line = ilist($line[0],$line[1],$line[2]);
  $line = table($line[0],$line[1],$line[2]);
  echo $line[0];
  echo "</td></tr><tr><td height=70><hr><p>";
  echo '<a href="./edit.php?title='.$num;
  echo '&folder='.$foldernumber.'">�Խ�</a>��';
}
if(empty($foldernumber)){
  echo '<a href="./">������</a>';
}else{
  echo '<a href="./?folder='.$foldernumber.'">������</a>';
}
?>
</td></tr></table>
</body>
</html>
