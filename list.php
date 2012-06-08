<?php

function list_main($user_num, $user_id, $delete){


  /**********************************
  [type] 0:list
   1:create file   4:create folder
   2:delete file   5:delete folder
   3:update file
  ***********************************/


  /*�����-BEGIN*/
  require('function.php');

  // FLDNUM //
  if(!empty($_GET['folder']))       $foldernumber = htmlspecialchars($_GET['folder']);
  else if(!empty($_POST['folder'])) $foldernumber = $_POST['folder'];

  // FLDNAME //
  if(!empty($foldernumber)){
    $folder = getfolder($user_num);
    $foldername = "no data";
    foreach($folder as $fld){
      if($foldernumber == $fld)
        $foldername = popfoldertitle($user_num,$foldernumber);
    }
  }else $foldername = '�ȥå�';

  // TYPE //
  if(!empty($_GET['type']))       $type = htmlspecialchars($_GET['type']);
  else if(!empty($_POST['type'])) $type = $_POST['type'];
  if(empty($type))  $type = 0;
  if( $type==3 ){
    if(!empty($_POST['no']))     $no = $_POST['no'];
    if(empty($no))  $head = 'No data';
  }
  if( $type==1 || $type==3 || $type==4 ){
    if(empty($_POST['title']))  $head = 'No data';
    else { 
      $in_title = htmlspecialchars($_POST['title']);
      $in_title = stripslashes($in_title);
    }
  }
  if( $type==2 || $type==5 ){
    if(!empty($_POST['check']))     $check = $_POST['check'];
    else if(!empty($_GET['check'])) $check = htmlspecialchars($_GET['check']);
  }

  echo "<html>";
  echo "<meta http-equiv='Content-Type' content='text/html; charset=euc-jp'>";
  echo "<head><title>";
  /*�����-END*/


  /*�ڡ��������ȥ�-BEGIN*/
  switch($type){
   case 0:  echo '���Ģ > '.$foldername; break;
   case 1:
     if(!empty($_POST['title'])) $head = $foldername.'/'.$in_title;
     echo '���Ģ > �������� > '.$head; break;
   case 2:
     if(!empty($check)){
       if(is_array($check))  $head = "�ե�������";
       else {
         if(empty($foldernumber)) $head = poptitle($user_num,$check);
         else   $head = poptitlefolder($user_num,$foldernumber,$check);
       } 
     } else  $head = "No data";
     $head = $foldername.'/'.$head;
     echo '���Ģ > ��� > '.$head;
     break;
   case 3:
     if(!empty($_POST['title'])) $head = $foldername.'/'.$in_title;
     echo '���Ģ > ���� > '.$head; break;
   case 4:
     if(!empty($_POST['title'])) $head = $in_title;
     echo '���Ģ > �����ե�������� > '.$head; break;
   case 5:
     if(!empty($check))
       if(is_array($check))  $head = "�ե�������";
       else                  $head = popfoldertitle($user_num,$check);
     else   $head = "No data";
     echo '���Ģ > �ե������� > '.$head; break;
   case 6: echo '���Ģ > ���������'; break;
  }
  echo "</title></head>";
  /*�ڡ��������ȥ�-END*/


  /*�ڡ����إå��� -BEGIN*/
  echo "<body>";
  echo "<center>";
  echo "<table border=0 width=70%>";
  echo "<tr><td align=right><b>".$user_id."</b></td>";
  echo "<form method='POST' action='./'><td width='50' align=right>";
  echo "<input type='submit' name='loginn' value='LOGOFF'>";
  echo "</td></form></tr>";
  echo "</table>";
  echo "<hr width=70%>";
  /*�ڡ����إå��� -END*/


  /*�ڡ����ᥤ��ʾ�¦��-BEGIN*/
  echo "<table border=0 width=70%>";
  echo "<tr><td><table border=0>";
  echo "<tr><td><font size=6>���Ģ</font></td></tr></table></td>";
  echo "<td>&nbsp;&nbsp;&nbsp;</td>";
  echo "<td align=right><table border=0><tr>";
  echo "<form method='POST' action='./'><td align=center width=50>";
  echo '<b>ɽ������</b></td></tr><tr><td>';
  if(!empty($foldernumber))
    echo '<input type="hidden" name="folder" value="'.$foldernumber.'">';
    if($delete==0) echo '<input type="hidden" name="delete" value="2"><input type="submit" value="����⡼��">';
    else           echo '<input type="hidden" name="delete" value="1"><input type="submit" value="�̾�⡼��">';
  echo "</td></form></tr></table></td>";
  echo "<td>&nbsp;&nbsp;&nbsp;</td>";
  echo "<td width=50% align=center><table border=0>";
  echo "<tr><td><b>�����ե�����</b></td><td></td>";
  echo "<td>&nbsp;&nbsp;&nbsp;</td>";
  echo "<td><b>�����ե����</b></td><td></td></tr>";
  echo "<form method='POST' action='./'><tr><td>";
  echo "<input type='hidden' name='type' value=1>";
  if(!empty($foldernumber))
    echo '<input type="hidden" name="folder" value="'.$foldernumber.'">';
  echo "<input type='text' name='title' size=15></td>";
  echo "<td><input type='submit' value='����'>";
  echo "</td></form><td></td>";
  echo "<form method='POST' action='./'><td>";
  echo "<input type='hidden' name='type' value=4>";
  if(!empty($foldernumber))
    echo '<input type="hidden" name="folder" value="'.$foldernumber.'">';
  echo "<input type='text' name='title' size=15></td>";
  echo "<td><input type='submit' value='����'>";
  echo "</td></tr></form></table>";
  echo "</td></tr></table>";
  echo "<table border=1 width=70% frame='void' rules='cols' cellpadding='5' bordercolor=Silver>";
  echo "<tr><hr colspan=2 width=70%>";
  /*�ڡ����ᥤ��ʾ�¦��-END*/


  /* �ե�����ڤӥե�����κ��� */
  if($type==1){
    if(empty($_POST['title'])){
      $makefile_contents = '�����ȥ�����Ϥ��Ƥ���������';
    }else{
      require('create.php');
      if(empty($foldernumber))  $makefile_contents = create($user_num, 0, $in_title);
      else			$makefile_contents = create($user_num, $foldernumber, $in_title);
    }
  }else if($type==4){
    if(empty($in_title)){
      $makefolder_contents = '�����ȥ�����Ϥ��Ƥ���������';
    }else{
      require('folder.php');
      $makefolder_contents = create_folder( $user_num, $in_title );
    }
    if(empty($foldernumber))  $makefolder_contents .= '<p>&nbsp;&nbsp;<a href="./">���</a>';
    else                      $makefolder_contents .= '<p>&nbsp;&nbsp;<a href="./?folder='.$foldernumber.'">���</a>';
  }


  /* �ե�����ڤӥե�����κ�� */
  else if($type==2){
    if(!empty($check)){
      require('delfun.php');
      if(empty($foldernumber)) $fnum = 0;
      else                     $fnum = $foldernumber;
      if(is_array($check)){
        for($i=0; $i<count($check); $i++){
          $dfile[$i] = delete_file($user_num, $fnum, $check[$i]);
        }
      } else  $dfile = delete_file($user_num, $fnum, $check);
    }
  }else if($type==5){
    require('delfun.php');
    if(!empty($check)){
      if(is_array($check)){
        for($i=0; $i<count($check); $i++){
          $dfolder[$i] = delete_folder($user_num, $check[$i]);
        }
      } else  $dfolder = delete_folder($user_num, $check);
    }
  }


  /*�ڡ����ᥤ��ʺ�¦��-BEGIN*/
  echo "<td width=30% valign='top'>";
  echo "<table border=0><tr><td><font size=5>&nbsp;�ե����&nbsp;</font><hr size=1></td></tr></table>";
  if($delete==0){
    echo "<ul type=circle>";
    echo "<li>&nbsp;<a href='./'>�ȥå�</a></li><p>";
    $folder = getfolder($user_num);
    if( is_array($folder) ){
      foreach($folder as $fnum){
        $title = popfoldertitle($user_num,$fnum);
        echo '<li>';
        echo '&nbsp;<a href="./?folder='.$fnum.'">'.$title.'</a>';
        echo '</li><p>';
      }
    }
    echo "</ul><br>";
  }else{
    echo '<form method="POST" action="./"><table border=0><tr><td>&nbsp;&nbsp;&nbsp;</td><td>';
    echo '<input type="hidden" name="type" value=5>';
    echo '<input type="checkbox" name="check[]" value=0>';
    echo "&nbsp;<a href='./'>�ȥå�</a><p>";
    $folder = getfolder($user_num);
    if( is_array($folder) ){
      foreach($folder as $fnum){
        $title = popfoldertitle($user_num,$fnum);
        echo '<input type="checkbox" name="check[]" value='.$fnum.'>';
        echo '&nbsp;<a href="./?folder='.$fnum.'">'.$title.'</a>';
        echo '<p>';
      }
    }
    echo '<input type="submit" value="�ե�������"></td></form></tr></table><br>';
  }
  echo "<div><table border=0><tr><td><font size=5>&nbsp;��&nbsp;&nbsp;��&nbsp;</font><hr size=1></td></tr></table></div>";
  if($delete==0) echo "<div style='position:relative;top:10px;left:0;'>";
  echo "<form method='POST' action='./search.php'>";
  if(!empty($foldernumber))
    echo '<input type="hidden" name="folder" value="'.$foldernumber.'">';
  echo "&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='shstr'> <input type='submit' value='����'></form>";
  if($delete==0) echo "</div>";
  echo "</td><td width=30% valign='top'>";
  /*�ڡ����ᥤ��ʺ�¦��-END*/


  /*�ڡ����ᥤ��ʱ�¦��-BEGIN*/
  switch($type){
  case 0:
   if(empty($foldernumber)){
     echo '<table border=0><tr><td><font size=5>&nbsp;�ȥå�&nbsp;</font><hr size=1></td></tr></table>';
     $file = getfile($user_num);
     if(empty($file)){
       echo '&nbsp;&nbsp;�ե����뤬����ޤ���';
     }
     $maxnum = 0;
     if($file){
       if($delete==0){
         echo '<ul type=circle>';
         foreach($file as $num){
           $sortfile[$num] = $num;
           if($num>$maxnum) $maxnum = $num;
         }
         for($i=1; $i<$maxnum+1; $i++){
           if($sortfile[$i]){
             $title = poptitle($user_num,$sortfile[$i]);
             echo '<li>';
             echo '&nbsp;<a href="./view.php?title='.$sortfile[$i].'">'.$title.'</a>';
             echo '</li><p>';
           }
         }
         echo '</ul>';
       }else{
         echo '<form method="POST" action="./"><table border=0><tr><td>&nbsp;&nbsp;&nbsp;</td><td>';
         echo '<input type="hidden" name="type" value=2>';
         foreach($file as $num){
           $sortfile[$num] = $num;
           if($num>$maxnum) $maxnum = $num;
         }
         for($i=1; $i<$maxnum+1; $i++){
           if($sortfile[$i]){
             $title = poptitle($user_num,$sortfile[$i]);
             echo '<input type="checkbox" name="check[]" value='.$sortfile[$i].'>';
             echo '&nbsp;<a href="./view.php?title='.$sortfile[$i].'">'.$title.'</a>';
             echo '<p>';
           }
         }
         echo '<input type="submit" value="�ե�������"></td></form></tr></table>';
       }
     }
   }else{
     echo '<table border=0><tr><td><font size=5>&nbsp;'.$foldername.'&nbsp;</font><hr size=1></td></tr></table>';
     $file = getfolderfile($user_num,$foldernumber);
     if(empty($file)){
       echo '&nbsp;&nbsp;�ե����뤬����ޤ���';
     }
     $maxnum = 0;
     if( is_array($file) ){
       if($delete==0){
         echo '<ul type=circle>';
         foreach($file as $num){
           $sortfile[$num] = $num;
           if($num>$maxnum) $maxnum = $num;
         }
         for($i=1; $i<$maxnum+1; $i++){
           if($sortfile[$i]){
             $title = poptitlefolder($user_num,$foldernumber,$sortfile[$i]);
             echo '<li>';
             echo '&nbsp;<a href="./view.php?title='.$sortfile[$i].'&folder='.$foldernumber.'">'.$title.'</a>';
             echo '</li><p>';
           }
         }
         echo '</ul>';
       }else{
         echo '<form method="POST" action="./"><table border=0><tr><td>&nbsp;&nbsp;&nbsp;</td><td>';
         echo '<input type="hidden" name="type" value=2>';
         echo '<input type="hidden" name="folder" value='.$foldernumber.">";
         foreach($file as $num){
           $sortfile[$num] = $num;
           if($num>$maxnum) $maxnum = $num;
         }
         for($i=1; $i<$maxnum+1; $i++){
           if($sortfile[$i]){
             $title = poptitlefolder($user_num,$foldernumber,$sortfile[$i]);
             echo '<input type="checkbox" name="check[]" value='.$sortfile[$i].'>';
             echo '&nbsp;<a href="./view.php?title='.$sortfile[$i].'&folder='.$foldernumber.'">'.$title.'</a>';
             echo '<p>';
           }
         }
         echo '<input type="submit" value="�ե�������"></td></form></tr></table>';
       }
     }
   }
   break;

  case 1:
   echo '<table border=0><tr><td><font size=5>&nbsp;��������&nbsp;</font><hr size=1></td></tr></table>';
   echo $makefile_contents;
   break;

  case 2:
   echo '<table border=0><tr><td><font size=5>&nbsp;�ե�������&nbsp;</font><hr size=1></td></tr></table>';
   if(empty($dfile)){
     print('&nbsp;&nbsp;�ե���������򤷤Ƥ���������');
   }else{
     if(is_array($dfile)){
       print('&nbsp;&nbsp;�ʲ��Υե�����������ޤ���<br><ul>');
       foreach($dfile as $d) print('<p><li>'.$foldername.' > '.$d.'</li>');
       print('</ul>');
     } else  print('&nbsp;&nbsp;['.$foldername.']�ե������ '.$dfile.' �������ޤ���');
   }
   if(empty($foldernumber)) {
     echo '<p>&nbsp;&nbsp;<a href="./">���</a>';
   } else {
     echo '<p>&nbsp;&nbsp;<a href="./?folder='.$foldernumber.'">���</a>';
   }
   break;

  case 3:
   echo '<table border=0><tr><td><font size=5>&nbsp;�ե����빹��&nbsp;</font><hr size=1></td></tr></table>';
   $check = true;
   if( empty($no) || empty($in_title) ){
     print('&nbsp;&nbsp;��⤬¸�ߤ��ޤ���');
     if(empty($foldernumber))  print('<p>&nbsp;&nbsp;<a href="./">���</a>');
     else       print('<p>&nbsp;&nbsp;<a href="./?folder='.$foldernumber.'">���</a>');
     $check = false;
   }
   if($check){
     require('update.php');
     $contents = htmlspecialchars($_POST['contents']);
     $contents = stripslashes($contents);
     update($user_num, $foldernumber, $no, $in_title, $contents);

     if(empty($foldernumber)){
       echo '<p>&nbsp;&nbsp;<a href="./view.php?title='.$no.'">���</a>��';
       echo '<a href="./">������</a>';
     }else{
       echo '<p>&nbsp;&nbsp;<a href="./view.php?title='.$no.'&folder='.$foldernumber.'">���</a>��';
       echo '<a href="./?folder='.$foldernumber.'">������</a>';
     }
   }
   break;

  case 4:
   echo '<table border=0><tr><td><font size=5>&nbsp;�����ե��������&nbsp;</font><hr size=1></td></tr></table>';
   echo $makefolder_contents;
   break;

  case 5:
   echo '<table border=0><tr><td><font size=5>&nbsp;�ե�������&nbsp;</font><hr size=1></td></tr></table>';
   if( empty($dfolder) ){
     print('&nbsp;&nbsp;�ե���������򤷤Ƥ���������');
   }else{
     if(is_array($dfolder)){
       print('<p>&nbsp;&nbsp;�ʲ��Υե�����������ޤ���<ul>');
       foreach($dfolder as $d) print('<p><li>'.$d.'</li>');
       print('</ul>');
     } else  print('&nbsp;&nbsp;['.$dfolder.']�ե�������������ޤ�����');
   }
   echo '<p>&nbsp;&nbsp;<a href="./">�ȥå�</a>';
   break;

  case 6:
   echo '<table border=0><tr><td><font size=5>&nbsp;���������&nbsp;</font><hr size=1></td></tr></table>';
   echo '<br><table border=0><tr><td>&nbsp;&nbsp;&nbsp;<b>'.$user_id.'.zip</b>&nbsp;&nbsp;&nbsp;</td>';
   echo '<form method="post" action="make_zip.php"><td>';
   echo '<input type="submit" value="���������">';
   echo '</td></form></tr></table><br><br>';
   echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="./">�ȥåפ����</a>';
   break;
  }
  echo "</ul></td></tr>";
  echo "</table>";
  /*�ڡ����ᥤ��ʱ�¦��-END*/


  /*�ڡ����եå��� -BEGIN*/
  echo "<hr width=70%>";
  if($type != 6)
    echo '<a href="./?type=6">�ե���������������</a>';
  echo "</body></html>";
  /*�ڡ����եå��� -END*/


}
