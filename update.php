<?php
function update($usrnum, $foldernumber, $num, $title, $contents){
										/**
  // �����ȥ�����
  if(empty($foldernumber)) $title = poptitle($usrnum, $num);
  else                     $title = poptitlefolder($usrnum,$foldernumber,$num);
										/**/
  // �ǥ��쥯�ȥ�λ���
  if(empty($foldernumber)){
    $file1 = 'user'.$usrnum.'/file/'.$num.".txt";
  }else{
    $foldertitle = popfoldertitle($usrnum, $foldernumber);
    $file1 = 'user'.$usrnum.'/file/folder'.$foldernumber.'/'.$num.".txt";
  }

  file_put_contents($file1, $title.PHP_EOL.$contents);

  //PHP_EOL �� OS�β��ԥ����ɤ򼨤����
  print('&nbsp;&nbsp;'.$title.' �򹹿����ޤ�����');

}
?>
