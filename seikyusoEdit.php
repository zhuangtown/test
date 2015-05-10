<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
session_start();
mb_language("Japanese");
if(!isset($_SESSION["user_id"])){
    header("Location: Login.php");
}
?>

<?php
 include_once './Includes/DBconnect.php';
//DBへ接続
$db=DBconnect();
//DBの選択
mysql_set_charset('sjis');

//setsysテープルがら---------------------------これは会社の情報へ取り替え----------------------------------------------------------
    $sql_setsys="SELECT  `name`,`postcode`,`address`,`tel`,`fax` FROM `setsys` WHERE code=1";
    $res_setsys=mysql_query($sql_setsys,$db) or die ("DB putouterror setsys");
    $row_setsys=mysql_fetch_array($res_setsys);
	
	if(isset($_POST['saibanRes']))
	{$rest=substr($_POST["saibanRes"],8,3);}
	else
	{$rest=substr($_GET['saiban_res'],8,3);}
	
	$sql_filema="SELECT `name` FROM `customer` WHERE `code` ='". $rest."'";
	$res_filema=mysql_query($sql_filema, $db) or die ("DB putout error02");
	$row_filema=mysql_result($res_filema,0);
	$tori=$row_filema;
			
	
	//テキストファイルからデータを読み込む
$payCondition = "";
$explanation = "";
if (!($payCondition = file_get_contents("./files/payCondition.txt"))) {
    echo "ファイルが開けません。";
}
if (!($explanation = file_get_contents("./files/explanation.txt"))) {
    echo "ファイルが開けません。";
}
header('Cache-Control:no-cache');
			?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=shift_jis" />
<link rel="stylesheet" type="text/css" href="./js/menu/fixedMenu_style1.css" />
<script src="./js/calendar.js" language="JavaScript"></script>
<script src="./js/seikyuso.js" language="JavaScript"></script>
<script type="text/javascript" src="./js/menu/jquery-1.4.2.min.js" language="JavaScript"></script>
<script type="text/javascript" src="./js/menu/jquery.fixedMenu.js" language="JavaScript"></script>
<title>請 求 書</title>
</head>

<body>
<form action=seikyusoEdit.php method=post name=order>
<table width="849" border="0">
  <tr>
    <td width="843"><table width="693" border="0">
      <tr>
        <td width="432" align="center" style="font-family:'ＭＳ 明朝'; font-size:36px"><div style="font-weight:900"> 請 求 書</div></td>
        <td width="251"><table width="248" border="0" cellspacing="0">
      <tr>
        <td width="98"  style=" font-family:'ＭＳ ゴシック';font-size:12px">発&#12288;行&#12288;日:</td>
        <td width="134" style=" font-family:'ＭＳ ゴシック';font-size:12px"><?php echo  date('Y',time()). "年".date('m',time())."月".date('d',time())."日";?></td>
      </tr>
      <tr>
        <td width="98"  style=" font-family:'ＭＳ ゴシック';font-size:12px">番&#12288;&#12288;&#12288;号:</td>
        <td width="134" style=" font-family:'ＭＳ ゴシック';font-size:12px"><span><?php if(isset($_POST['saibanRes'])){echo $_POST['saibanRes'];}else{echo $_GET['saiban_res'];}?></span></td>
      </tr>
      
    </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="848" border="0">
  <tr>
    <td width="842">&nbsp;</td>
  </tr>
  <tr>
    <td ><div style="font-family:'ＭＳ 明朝'; font-size:18px"><b><u><?php echo $tori ?></div></u></b></td>
  </tr>
  
</table>
<table width="845"  border="0" style="margin: 0">
  <tr>
    <td width="386" height="133"   ><br/>
      <div style="font-family:'ＭＳ 明朝'; font-size:12px">&#12288;&#12288;平素は格別のご高配を、厚く御礼申し上げます。<br />
下記の通り請求致します。</div></td>
    <td width="449"><table width="437" height="131"  border="1" cellspacing="0">
      <tr>
        <td height="25" colspan="2" bgcolor="#CDE3F3"><div style="font-family:'ＭＳ ゴシック'; font-size:14px">取引元</div></td>
        </tr>
      <tr>
        <td width="301" height="98"   ><table style="font-size:10px;border:0;">
          <tr>
            <td  ><?php echo $row_setsys[0]?></td>
          </tr>
          <tr>
            <td><?php echo $row_setsys[1]?></td>
          </tr>
          <tr>
            <td><?php echo $row_setsys[2] ?></td>
          </tr>
          <tr>
            <td>電話番号：<?php echo $row_setsys[3] ?></td>
          </tr>
          <tr>
            <td >ファクス：<?php echo $row_setsys[4] ?></td>
          </tr>
        </table></td>
        <td width="120">&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
</table>
<table width="847" border="1"  cellpadding="0px" bgcolor="#FFFFFF" cellspacing="0px" style="font-family:'ＭＳ ゴシック'; font-size:12px">
  <colgroup>
  <col width="20%" />
  <col width="60%" />
  </colgroup>
  <tbody >
  
    <tr>
      <td height="25px" width="101" bgcolor="#CDE3F3"  align="center" >請求書No.</td>
      <td height="25px" width="734"  ><?php if(isset($_POST['saibanRes'])){echo $_POST['saibanRes'];}else{echo $_GET['saiban_res'];}?></td>
    </tr>
    <tr>
      <td height="25px" bgcolor="#CDE3F3" align="center" >業務名称</td>
      <td height="25px" ><input type="text" name="workName" id="workName"  onblur="onblurs() style="width: 300" maxlength="225" value="<?php if(isset($_POST['workName'])){echo $_POST['workName'];}?>"></td>
    </tr>
    <tr>
      <td height="25px" bgcolor="#CDE3F3" align="center" >作業内容</td>
      <td height="25px"><input type="text" name="workContents" value="<?php if(isset($_POST['workContents'])){echo $_POST['workContents'];}?>" style="width: 300" maxlength="225" onBlur="this.form.wk_1_stepContents.value=this.form.workContents.value;">
	  </td>
    </tr>
    <tr>
      <td height="25px" bgcolor="#CDE3F3"  align="center">期&#12288;&#12288;間</td>
      <td height="25px" >
	  <input type="text" name="periodStart" value="<?php if(isset($_POST['periodStart'])){echo $_POST['periodStart'];}?>" style="width: 95">
	  <input type="button" onClick="wrtCalendar(event,this.form.periodStart,'yyyy/mm/dd');" style="background-image: url("img/calendar.png"); background-color:#5483B6; color: #ffffff; width:35px; height:20px; border:0; cursor:pointer;" value="開始" name="Calendar">
       〜
	  <input type="text" name="periodEnd" value="<?php if(isset($_POST['periodEnd'])){echo $_POST['periodEnd'];}?>" style="width: 95">
	  <input type="button" onClick="wrtCalendar(event,this.form.periodEnd,'yyyy/mm/dd');" style="background-image: url("img/calendar.png"); background-color:#5483B6; color: #ffffff; width:35px; height:20px; border:0; cursor:pointer;" value="終了" name="Calendar">
      </TD>
	</tr>
    <tr>
      <td height="25px" bgcolor="#CDE3F3"  align="center" >支払条件</td>
      <td height="25px" ><input type="text" name="payCondition" value="<?php if(isset($_POST['payCondition'])){echo $_POST['payCondition'];}else{echo $payCondition;}?>" style="width: 300" maxlength="225"></td>
    </tr>
    <tr>
      <td height="25px" bgcolor="#CDE3F3" align="center">作業場所</td>
      <td height="25px"><input type="text" name="workPlace" value="<?php if(isset($_POST['workPlace'])){echo $_POST['workPlace'];}?>" style="width: 300" maxlength="225"></td>
    </tr>
    <tr>
      <td height="25px" bgcolor="#CDE3F3" align="center" >作業担当</td>
      <td ><input type="text" name="workCharge" value="<?php if(isset($_POST['workCharge'])){echo $_POST['workCharge'];}?>" style="width: 300" maxlength="225"></td>
    </tr>
  </tbody>
</table>
<table width="847" border="0">
  <tr>
    <td width="847" align="right" style="font-family:'ＭＳ ゴシック'; font-size:9px">時間単位：H&#12288;&#12288;金額単位：円</td>
  </tr>
</table>
<TABLE width="850" border="1"  cellspacing="0" style="font-family:'ＭＳ ゴシック'; font-size:12px">
  <COLGROUP>
  <COL width="5%">
  <COL width="35%">
  <COL width="10%">
  <COL width="10%">
  <COL width="10%">
  <COL width="10%">
  <COL width="10%">
  <col width="10%">
  <TBODY>
  <TR>
    <TD height="25px" bgcolor="#CDE3F3" align="center" >No.</TD>
    <TD height="25px" bgcolor="#CDE3F3"  align="center" >作業内容</TD>
    <TD height="25px" bgcolor="#CDE3F3"  align="center" >基準作業<br>
      時間下限</TD>
    <TD height="25px" bgcolor="#CDE3F3" align="center" >基準作業<br>
時間上限</TD>
    <TD height="25px" bgcolor="#CDE3F3"  align="center">実際稼動<br>
時間</TD>
    <TD height="25px" bgcolor="#CDE3F3"  align="center" >基準単価</TD>
    <TD height="25px" bgcolor="#CDE3F3"  align="center" >超過控除</TD>
    <TD height="25px" bgcolor="#CDE3F3"  align="center" >交通費</TD></TR>
  
 <?php 
            for($i=1;$i<=10;$i++){
          
            
            ?>
            <TR>
                <TD class="l-cellodd"><input type="text" name="wk_<?php echo $i?>_id" value="<?php if(isset($_POST['wk_'.$i.'_id'])){echo $_POST['wk_'.$i.'_id'];}else{echo $i;}?>" readonly=true style="background: transparent; border-width: 0px; width: 100% ;text-align: center;">
                </TD>
                <TD class="l-cellodd"><input type="text" name="wk_<?php echo $i?>_stepContents" value="<?php if(isset($_POST['wk_'.$i.'_stepContents'])){echo $_POST['wk_'.$i.'_stepContents'];}?>" style="background: transparent; border-width: 0px; width: 100%">
                </TD>
                <TD class="l-cellodd"><input type="text" name="wk_<?php echo $i?>_number" value="<?php if(isset($_POST['wk_'.$i.'_number'])){echo $_POST['wk_'.$i.'_number'];}?>" style="background: transparent; border-width: 0px; width: 100%">
                </TD>
                <TD class="l-cellodd"><input type="text" name="wk_<?php echo $i?>_unitPrice" value="<?php if(isset($_POST['wk_'.$i.'_unitPrice'])){echo $_POST['wk_'.$i.'_unitPrice'];}?>" style="background: transparent; border-width: 0px; width: 100%">
                </TD>
                <TD class="l-cellodd"><input type="text" name="wk_<?php echo $i?>_time" value="<?php if(isset($_POST['wk_'.$i.'_time'])){echo $_POST['wk_'.$i.'_time'];}?>" style="background: transparent; border-width: 0px; width: 100%">
                </TD>
                 <TD class="l-cellodd"><input type="text" name="wk_<?php echo $i?>_addtime" value="<?php if(isset($_POST['wk_'.$i.'_addtime'])){echo $_POST['wk_'.$i.'_addtime'];}?>" style="background: transparent; border-width: 0px; width: 100%">
                </TD>
                <TD class="l-cellodd"><input type="text" name="wk_<?php echo $i?>_subtracttime" value="<?php if(isset($_POST['wk_'.$i.'_subtracttime'])){echo $_POST['wk_'.$i.'_subtracttime'];}?>" style="background: transparent; border-width: 0px; width: 100%">
                </TD> 
                <TD class="l-cellodd"><input type="text" name="wk_<?php echo $i?>_trance" value="<?php if(isset($_POST['wk_'.$i.'trance'])){echo $_POST['wk_'.$i.'_trance'];}?>" style="background: transparent; border-width: 0px; width: 100%">
                </TD>
            </TR>
            <?php 
            }
            ?>
       
   </TBODY>
</TABLE>
</div>
</td>
<table width="857" border="0" style="font-family:'ＭＳ ゴシック'; font-size:12px">
  <tr>
    <td width="581">&nbsp;</td>
    <td width="266"><table  width="231" border="1" align="right" cellspacing="0">
      <tr>
        <td width="82" bgcolor="#CDE3F3" align="center" ><span class="style1">合計金額</span></td>
          <td width="133" align="right">{&&sumprice&}</td>
        </tr>
      <tr>
        <td bgcolor="#CDE3F3"  align="center">消費税(8%)</td>
          <td align="right">{&&shz&}</td>
        </tr>
      <tr>
        <td bgcolor="#CDE3F3" align="center" >その他</td>
          <td align="right">{&&trance&}</td>
        </tr>
      <tr>
        <td bgcolor="#CDE3F3"  align="center">合計金額(税込)</td>
          <td align="right">{&&sumpricez&}</td>
        </tr>
    </table></td>
  </tr>
</table>
 <table width="210" border="0">
   <tr>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
 </table>
 <p>&nbsp;</p>
 <table  border="0" style="font-family:'ＭＳ ゴシック'; font-size:12px">
   <tr>
     <td>上記金額を下記の口座へお振込願います。
     </td>
   </tr>
 </table>
 <table width="398" border="0" cellspacing="0" style="font-family:'ＭＳ ゴシック'; font-size:12px">
   <tr>
     <td width="392"><TABLE width="279" border="1" cellspacing="0" >
   <TBODY>
     <TR>
	    <TD align=left bgcolor="#CDE3F3" class="l-cellcenter style1">銀行</TD>
       <TD width="186" align=left class="l-cellcenter">三井住友銀行 神田支店</TD>
      </TR>
     <TR>
	 <TD width="77" bgcolor="#CDE3F3"><span class="style1">口座番号</span></TD>
       <TD align=left>(普)12345678</TD>
      </TR>
	 <TR>
	 <TD width="77" height="22" bgcolor="#CDE3F3"><span class="style1">口座名義</span></TD>
       <TD align=left>ｶ)ｼﾝﾒﾄﾘｸｽ</TD>
      </TR>
   </TBODY>
 </TABLE></td>
   </tr>
</table>
 <DIV class=list>
  <p>&nbsp;</p>
  <TABLE  style="font-family:'ＭＳ ゴシック'; font-size:12px">
  <TBODY>
    <TR><TD class=l-cellodd>摘要：</TD></TR>
    <TR><TD class=l-cellodd><textarea name="explanation" cols=137% rows=10 value=""><?php if(isset($_POST['explanation'])){echo $_POST['explanation'];}else{echo $explanation;}?>
                           </textarea>
	</TD>
	</TR>
	<TR><TD align=center><br><input type="submit" name="confirm" value="確認">
         </TD>
    </TR>
  </TBODY>
</TABLE>
</DIV>
</form>
</body>
</html>
