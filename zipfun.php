<?php
/**
  fread�ϥե����륵��������ꤷ�ƥХ��ʥꡦ�⡼�ɤ��ɤ߹���ʸ������֤��ؿ�
  file_get_contents�ϥե������ʸ����������֤��ؿ�
��file��1�Ԥ��Ȥ�����˳�Ǽ�����֤��ؿ�
**/

function prezip_file($usrnum, $num){
  $url  = 'user'.$usrnum.'/file/'.$num.'.txt';
  $text = @file($url);
  if(!empty($text[1])){
    for($i=1;$i<count($text);$i++)  $contents[$i-1] = $text[$i];
    $contents = implode("", $contents);
  } else   $contents = "";
  $contents = mb_convert_encoding($contents, "SJIS", "EUC-JP");
  $text[0] = str_replace(PHP_EOL,"", $text[0]);
  $text[0] = mb_convert_encoding($text[0], "SJIS", "EUC-JP");

  return array($contents, $text[0].'.txt');
}

function prezip_folder($usrnum, $fnum, $num){
  $ftitle = popfoldertitle($usrnum,$fnum);
  $ftitle = mb_convert_encoding($ftitle, "SJIS", "EUC-JP");
  $url  = 'user'.$usrnum.'/file/folder'.$fnum.'/'.$num.'.txt';
  $text = @file($url);
  if(!empty($text[1])){
    for($i=1;$i<count($text);$i++)  $contents[$i-1] = $text[$i];
    $contents = implode("", $contents);
  } else  $contents = "";
  $contents = mb_convert_encoding($contents, "SJIS", "EUC-JP");
  $text[0] = str_replace(PHP_EOL,"", $text[0]);
  $text[0] = mb_convert_encoding($text[0], "SJIS", "EUC-JP");

  return array($contents, $ftitle.'/'.$text[0].'.txt');
}
?>