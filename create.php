<?php
function create($usrnum, $foldernumber, $title){

  $contents = '';
  
  // �ǥ��쥯�ȥ�λ���Ƚ�ʣ�γ�ǧ
  $exist = false;
  if($foldernumber==0){
    $next = filenum($usrnum);
    $flurl = 'user'.$usrnum.'/file/'.$next.".txt";
    $file   = getfile($usrnum);
    if($file){
      foreach($file as $number){
        if($title == poptitle($usrnum, $number)){
          $exist = true;
          break;
        }
      }
    }
  }else{
    $next = folderfilenum($usrnum, $foldernumber);
    $foldertitle = popfoldertitle($usrnum, $foldernumber);
    $flurl = 'user'.$usrnum.'/file/folder'.$foldernumber.'/'.$next.".txt";
    $file   = getfolderfile($usrnum, $foldernumber);
    if($file){
      foreach($file as $number){
        if($title == poptitlefolder($usrnum, $foldernumber, $number)){
          $exist = true;
          break;
        }
      }
    }
  }

  // �ե�����κ���
  if($exist){
      $contents .= '&nbsp;&nbsp;���Υ����ȥ�ϴ���¸�ߤ��Ƥ��ޤ���';
    if($foldernumber==0){
      $contents .= '<p>&nbsp;&nbsp;<a href="./">������</a>';
    }else{
      $contents .= '<p>&nbsp;&nbsp;<a href="./?folder='.$foldernumber.'">������</a>';
    }
  }else{
    file_put_contents($flurl, $title);
    $contents .= '&nbsp;&nbsp;'.$title." ��������ޤ�����";
    if(empty($foldernumber)){
      $contents .= '<p>&nbsp;&nbsp;<a href="./edit.php?title='.$next.'">�Խ�</a>��';
      $contents .= '<a href="./">������</a>';
    }else{
      $contents .= '<p>&nbsp;&nbsp;<a href="./edit.php?title='.$next.'&folder='.$foldernumber.'">�Խ�</a>��';
      $contents .= '<a href="./?folder='.$foldernumber.'">������</a>';
    }
  }

  return $contents;
}
?>
