<?php
$usrnum = $_COOKIE['user_num_cookie'];
$num = htmlspecialchars($_GET['title']);
$foldernumber = htmlspecialchars($_GET['folder']);
if(!empty($num)){
  require('function.php');
  if(empty($foldernumber)){
    $flurl = 'user'.$usrnum.'/file/'.$num.".txt";
    $foldername = "�ȥå�";
  }else{
    $flurl = 'user'.$usrnum.'/file/folder'.$foldernumber.'/'.$num.".txt";
    $foldername = popfoldertitle($usrnum, $foldernumber);
  }
  $text  = file_get_contents($flurl);
  $text = preg_replace("(\t)", '����', $text);
  $buffer  = explode("\n", $text);
}
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp">

<head><title>
<?php
if(empty($num)) echo '���Ģ > �Խ�[��⤬����ޤ���]';
else            echo '���Ģ > �Խ� > '.$foldername.'/'.$buffer[0];
?>
</title></head>
<body><center>
<table border=0 width=80%><tr><td>
<?php
if(empty($num)){
  print('��⤬¸�ߤ��ޤ���');
  $check = false;
}else{
  $check = true;
  if(empty($foldernumber)){
    echo '<hr>';
    echo '<h4><a href="./">'.$foldername.'</a> > '.$buffer[0].'</h4>';
    echo '<form method="POST" action="./">';
    echo '<input type="hidden" name="type" value=3>';
    echo '<input type="text" name="title" value="'.$buffer[0].'" size="50">';
    echo '<p><a href="./view.php?title='.$num.'">���</a>��';
    echo '<a href="./">������</a><hr>';
  }else{
    echo '<hr>';
    echo '<h4><a href="./?folder='.$foldernumber.'">'.$foldername.'</a> > '.$buffer[0].'</h4>';
    echo '<form method="POST" action="./">';
    echo '<input type="hidden" name="type" value=3>';
    echo '<input type="text" name="title" value="'.$buffer[0].'" size="50">';
    echo '<p><a href="./view.php?title='.$num.'&folder='.$foldernumber.'">���</a>��';
    echo '<a href="./?folder='.$foldernumber.'">������</a><hr>';
    echo '<input type="hidden" name="folder" value="'.$foldernumber.'">';
  }
}

if($check){
  											/**
  echo '<hr><h1>'.$buffer[0].'</h1>';
  echo '<form method="POST" action="./">';
  echo '<input type="hidden" name="type" value=3>';
  echo '<input type="hidden" name="title" value="'.$buffer[0].'" size="50">';
  											/**
  if(empty($foldernumber)){
    echo '<p><a href="./view.php?title='.$num.'">���</a>��';
    echo '<a href="./">������</a><hr>';
  }else{
    echo '<p><a href="./view.php?title='.$num.'&folder='.$foldernumber.'">���</a>��';
    echo '<a href="./?folder='.$foldernumber.'">������</a><hr>';
    echo '<input type="hidden" name="folder" value="'.$foldernumber.'">';
  }
  											/**/
  echo '<input type="hidden" name="no" value="'.$num.'">';
  echo '<textarea name="contents" rows="28" cols="125">';
  for($i=1;$i<count($buffer);$i++){
    echo $buffer[$i];
  }
  echo '</textarea> <p>';
  echo '<input type="submit" value="����">';
  echo '</form>';
}

?>
<hr>
<?php
if(empty($foldernumber)){
  echo '<p><a href="./view.php?title='.$num.'">���</a>��';
  echo '<a href="./">������</a>';
}else{
  echo '<p><a href="./view.php?title='.$num.'&folder='.$foldernumber.'">���</a>��';
  echo '<a href="./?folder='.$foldernumber.'">������</a>';
}
?>
</td></tr></table>
</body>
</html>
