<?php
$cur_page = $_REQUEST["cur_page"];
if($cur_page=="")
        $cur_page=1;
if($max=="")
	$max=mysql_fetch_array(mysql_query("select count(*) ".$sql_model,$cn));
$sql="select ";
$count_col=count($col);
for($i=0;$i<count($col);$i++){
	if(strncmp($col[$i],"_op",3)==0){
		$sql.="'".$col[$i]."'";
	}else{
		$sql.=$col[$i];
	}
	if($i!=$count_col-1){
		$sql.=",";
	}
}
$sql.=$sql_model." limit ".($cur_page-1)*$pagesize.",".$pagesize;
$result=mysql_query($sql,$cn);
echo mysql_error();
$max_page=floor($max[0]/$pagesize)+1;
?>
<table border="0" cellspacing="0" cellpadding="0" class="d">
  <tr>
<td>
          <?php if($cur_page>1){?>
      <a href=<?php echo $PHP_SELF;?>?cur_page=1&<?php echo $addtion?>>
      <?php }?>
      首页</a> &nbsp;
      <?php if($cur_page>1){?>
      <a href=<?php echo $PHP_SELF;?>?cur_page=<?php echo $cur_page-1?>&<?php echo $addtion?>>
      <?php }?>
      上一页</a> &nbsp;
      <?php if($max_page>1&&$cur_page<$max_page){?>
      <a href=<?php echo $PHP_SELF;?>?cur_page=<?php echo $cur_page+1?>&<?php echo $addtion?>>
      <?php }?>
      下一页</a> &nbsp;
      <?php if($max_page>1&&$cur_page<$max_page){?>
      <a href=<?php echo $PHP_SELF;?>?cur_page=<?php echo $max_page?>&<?php echo $addtion?>>
      <?php }?>
      尾页</a>&nbsp;当前页数:<?php echo $cur_page?>/总页数:<?php echo $max_page?> 总数:<?php echo $max[0]?>
    </td>
  </tr>
</table>
<table border="1" >
  <tr align="center" >
<?php
$map_tmp="map_".$col[5];
$map_tmp=$$map_tmp;
for($i=0;$i<count($col_name);$i++){
?>
<td><?php echo $col_name[$i]?></td>
<?php }?>
  </tr>
  <?php while($rs=mysql_fetch_array($result)){?>
  <tr>
<?php
for($i=0;$i<count($col_name);$i++){
?>
        <td>
<?php
	$map_tmp="map_".$col[$i];
	$url_tmp="url_".$col[$i];
	$map_tmp=$$map_tmp;
	$url_tmp=$$url_tmp;
	$count = 1;
	if($url_tmp!=""){
		$count = count($url_tmp);
	}
for($k=0;$k<$count;$k++){
	$target=$col[$i]."_target";
	$target=$$target;
	if($url_tmp!=""){
		echo "[<a href=".$url_tmp[$k].$rs[$key_col].$target.">";
	}
	$value = $rs[$i];
	if($map_tmp[$value]!=""){
		 echo $map_tmp[$value][$k];
	}else{
		 echo $value;
	}
	if($url_tmp!=""){
		echo "</a>]";
	}
}
	?>
</td>
<?php }?>
  </tr>
<?php }?>
</table>
