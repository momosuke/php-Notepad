<?php
function update($usrnum, $foldernumber, $num, $title, $contents){
										/**
  // タイトルを固定
  if(empty($foldernumber)) $title = poptitle($usrnum, $num);
  else                     $title = poptitlefolder($usrnum,$foldernumber,$num);
										/**/
  // ディレクトリの指定
  if(empty($foldernumber)){
    $file1 = 'user'.$usrnum.'/file/'.$num.".txt";
  }else{
    $foldertitle = popfoldertitle($usrnum, $foldernumber);
    $file1 = 'user'.$usrnum.'/file/folder'.$foldernumber.'/'.$num.".txt";
  }

  file_put_contents($file1, $title.PHP_EOL.$contents);

  //PHP_EOL は OSの改行コードを示す定数
  print('&nbsp;&nbsp;'.$title.' を更新しました．');

}
?>
