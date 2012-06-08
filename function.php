<?php

function getfile($usrnum){
  $memo = glob('user'.$usrnum.'/file/*.txt');
  for($i=0;$i<count($memo);$i++){
    preg_match('((file\/)([0-9]+))',$memo[$i],$regs);
    $file[$i]=$regs[2];
  }
  return $file;
}

function getfolderfile($usrnum, $num){
  $memo = glob('user'.$usrnum.'/file/folder'.$num.'/*.txt');
  for($i=0;$i<count($memo);$i++){
    preg_match('((\/)([0-9]+))',$memo[$i],$regs);
    $file[$i]=$regs[2];
  }
  return $file;
}

function getfolder($usrnum){
  $memo = glob('user'.$usrnum.'/file/folder*');
  for($i=0;$i<count($memo);$i++){
    preg_match('((folder)([0-9]+))',$memo[$i],$regs);
    $num[$i]=$regs[2];
  }
  return $num;
}

function poptitle($usrnum,$num){
  $address= 'user'.$usrnum.'/file/'.$num.".txt";
  $handle = @fopen($address, "r");
  if(!feof($handle)){
    $title = fgets($handle, 4096);
    $title = str_replace(PHP_EOL,"",$title);
  }
  return $title;
}

function poptitlefolder($usrnum,$foldernumber,$num){
  $address= 'user'.$usrnum.'/file/folder'.$foldernumber.'/'.$num.".txt";
  $handle = @fopen($address, "r");
  if(!feof($handle)){
    $title = fgets($handle, 4096);
    $title = str_replace(PHP_EOL,"",$title);
  }
  return $title;
}

function popfoldertitle($usrnum,$num){
  $address= 'user'.$usrnum.'/file/folder'.$num.'/title';
  $handle = @fopen($address, "r");
  if(!feof($handle)){
    $title = fgets($handle, 4096);
    $title = str_replace(PHP_EOL,"",$title);
  }
  return $title;
}

function popnum($filenum){
  for($i=0;$i<count($filenum);$i++){
    $array[$i]=0;
  }
  for($i=0;$i<count($filenum);$i++){
    $r=$filenum[$i]-1;	// 配列の添え字に合わせる
    $array[$r]=1;	// 存在したら1を代入
  }
  for($i=0;$i<count($filenum);$i++){
    if($array[$i]==0){
      $num=$i+1;
      break;
    }
  }
  if($i==count($filenum)){
    $num=$i+1;
  }
  return $num;
}

function filenum($usrnum){
  $filenum = getfile($usrnum);
  $num     = popnum($filenum);
  return $num;
}

function folderfilenum($usrnum,$fldnum){
  $filenum = getfolderfile($usrnum,$fldnum);
  $num     = popnum($filenum);
  return $num;
}

function foldernum($usrnum){
  $filenum = getfolder($usrnum);
  $num     = popnum($filenum);
  return $num;
}

function seikei($buff){
  for($i=1;preg_match('(^\*)',$buff);$i++){
    if($i>7) break;
    $buff = substr($buff,1);
  }
  if($i>1){
    $i = 7 - $i;
    $buff = '<font size='.$i.'><b>'.$buff.'</b></font>';
  }
  return $buff;
}

function url($buff){
  preg_match('((http://|https://)([a-zA-Z0-9]+)(([-\.\/_~?=&%$#;]([-\.\/_~?=&%$#;a-zA-Z0-9]+))*))'
       ,$buff,$regs);
  $url  = '<a href="'.$regs[0].'" target="_blank">'.$regs[0].'</a>';
  $buff = str_replace($regs[0],$url,$buff);
  return $buff;
}

function ilist($buff,$iflag,$tflag){
  if($iflag==0){
    if(preg_match('(^\-)',$buff)){
      $buff = substr($buff,1);
      $buff = '<ul><li>'.$buff;
      $newiflag=1;
    }else{
      $newiflag=0;
    }
  }else{
    for($num=0;preg_match('(^\-)',$buff);$num++){
      if($num==3) break;
      $buff = substr($buff,1);
    }
    if($num==0){
      for($iflag;$iflag>0;$iflag--){
        $buff = '</li></ul>'.$buff;
      }
      $line = array($buff,$num,$tflag);
      return $line;
    }
    $newiflag = $num;
    $num     -= $iflag;
    if($num == 1){
      $buff = '<ul><li>'.$buff;
    }else{
      $buff = '</li><li>'.$buff;
      for($num;$num<0;$num++){
        $buff = '</li></ul>'.$buff;
      }
    }
  }
  $line = array($buff,$newiflag,$tflag);
  return $line;
}

function table($buff,$iflag,$tflag){
  if($tflag){
    if(preg_match('(^\|)',$buff)){
      $t    = explode("|",$buff);
      $buff = $t[0];
      for($j=1;$j<count($t);$j++){
        if($j==1){
          $buff .= '<tr><td>'.$t[1].'</td>';
        }else if($j==count($t)-1){
          $buff .= '<td>'.$t[count($t)-1].'</td></tr>';
        }else{
          $buff .= '<td>'.$t[$j].'</td>';
        }
      }
    }else{
      print('</table>');
      $tflag = false;
    }
  }else{
    if(preg_match('(^\|)',$buff)){
      $t    = explode("|",$buff);
      $buff = $t[0];
      $tflag = true;
      echo '<table border=1 frame="void" rules="all" cellpadding="2">';
      for($j=1;$j<count($t);$j++){
        if($j==1){
          $buff .= '<tr><td>'.$t[1].'</td>';
        }else if($j==count($t)-1){
          $buff .= '<td>'.$t[count($t)-1].'</td></tr>';
        }else{
          $buff .= '<td>'.$t[$j].'</td>';
        }
      }
    }
  }
  $line = array($buff,$iflag,$tflag);
  return $line;
}

?>
