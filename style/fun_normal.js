function $2(id)
{
	return document.getElementById(id);	
}
function tr_onMouseOver(obj)
{ obj.style.background="#FFFDFD";
}
function tr_onMouseOut(obj)
{
obj.style.background="#f5f5f5";
}
function EnterSelect(id,svalue)
{    
var slt=document.getElementById(id)
var strempty="";
if(slt!=null)
   for(var i=0;i<=slt.childNodes.length-1;i++)
       if((slt.childNodes[i].value+strempty)==svalue )
          { 
             slt.childNodes[i].selected=true;
             break;
          }
}
function EnterCheckBox(name,svalue)
{
var str=""
var slt=document.getElementsByName(name);
var arr=svalue.split(',');
for(var indexI=0;indexI<=slt.length-1;indexI++)
   {
	   for(var indexJ=0;indexJ<=arr.length-1;indexJ++)
	   {
		  if(( "" + slt[indexI].value)==(""+arr[indexJ]))
			{
			   slt[indexI].checked=true;
			}
	   }
   }
}

function EnterRadio(name,svalue)
{
var str="";
var slt=document.getElementsByName(name);
for(var indexI=0;indexI<=slt.length-1;indexI++)
   if((slt[indexI].value+str)==(svalue+str))
	{
	  slt[indexI].checked=true;
		 break;
	 }
}

function EnterRadioIndex(name,index2)
{
var str="";
var slt=document.getElementsByName(name);
for(var indexI=0;indexI<=slt.length-1;indexI++)
   if((slt[indexI].value+str)==(svalue+str))
	{
	  slt[indexI].checked=true;
		 break;
	 }
}
//--------------------------表单验证
//验证长度的函数，首先调用验证是否为空的函数
function CheckIsNull(Inform,Inputname,Inputvalue){ 
   var Form=Inform+"." 
   eval("Temp="+Form+Inputname+".value;"); 
   if(Temp=="")
   { 
      alert("提醒您:"+Inputvalue+"不能为空!"); 
      eval(Form+Inputname+".className='RedInput';"); 
      eval(Form+Inputname+".focus();"); 
      return false; 
   }
   else
   { 
     eval(Form+Inputname+".className="+Form+Inputname+".className.replace('RedInput','');"); 
    return true; 
   } 
}
//2个文本框是否是一样的
function CheckIsSame(Inform,Inputname1,Inputname2,Inputvalue1,Inputvalue2){
if (!CheckIsNull(Inform,Inputname1,Inputvalue1)) 
   return false;
else if(!CheckIsNull(Inform,Inputname2,Inputvalue2)) 
   return false; 
else
{
var Form=Inform+".";
eval("Temp1="+Form+Inputname1+".value;");
eval("Temp2="+Form+Inputname2+".value;");
if(Temp1!=Temp2)
{
alert(Inputvalue1+"与"+Inputvalue2+"必须相同");
return false;
}
else
  return true;
}
}
//验证长度函长度介于a,b
function CheckLength(Inform,Inputname,Inputvalue,InputMinSize,InputMaxSize){
//验证是否为空！
if (!CheckIsNull(Inform,Inputname,Inputvalue)) 
   return false;
else
{
var Form=Inform+"." 
eval("Temp="+Form+Inputname+".value;"); 
if (Temp.length<parseInt(InputMinSize)||Temp.length>parseInt(InputMaxSize))
{
alert(Inputvalue+"的长度必须在"+InputMinSize+"-"+InputMaxSize+"之间！");
eval(Form+Inputname+".className='RedInput';"); 
 eval(Form+Inputname+".focus();"); 
return false;}
else{ 
 eval(Form+Inputname+".className="+Form+Inputname+".className.replace('RedInput','');"); 
    return true; 
} 
}
}
//验证长度函数二，该函数主要判断当不要求是否为空、只要求最大长度的时候使用
function CheckLengthMax(Inform,Inputname,Inputvalue,InputMaxSize){
var Form=Inform+"." 
eval("Temp="+Form+Inputname+".value;"); 
if (Temp.length>parseInt(InputMaxSize)){
alert(Inputvalue+"的长度必须小于"+InputMaxSize+"！");
eval(Form+Inputname+".className='RedInput';"); 
 eval(Form+Inputname+".focus();"); 
return false;}
else{ 
 eval(Form+Inputname+".className="+Form+Inputname+".className.replace('RedInput','');"); 
    return true; 
}
}
//验证是否为合法HTTP的函数
function CheckIsHTTP(Inform,Inputname,Http){
 if (!CheckIsNull(Inform,Inputname,Http))return false; 
   else{ 
      var Form=Inform+"." 
         eval("Temp="+Form+Inputname+".value;"); 
      if(Temp.search(/^http:\/\//)==-1) 
          { alert("提醒您:"+Http+"格式不正确！"); 
            eval(Form+Inputname+".focus();"); 
            return false; 
             } 
   else{ 
            return true; 
       } 
      }	
}
//验证是否为合法IP的函数
function CheckIsIP(Inform,Inputname,IP){
 if (!CheckIsNull(Inform,Inputname,IP))return false; 
   else{ 
      var Form=Inform+"." 
         eval("Temp="+Form+Inputname+".value;"); 
      if(Temp.search(/(\d+)\.(\d+)\.(\d+)\.(\d+)/g)==-1) 
          { alert("提醒您:"+IP+"格式不正确！"); 
            eval(Form+Inputname+".focus();"); 
            return false; 
             } 
   else{ 
            return true; 
       } 
      }
}
//验证是否为合法email的函数
function CheckIsEmail(Inform,Inputname,Email){ 
   if (!CheckIsNull(Inform,Inputname,Email))return false; 
   else{ 
      var Form=Inform+"." 
         eval("Temp="+Form+Inputname+".value;"); 
      if(Temp.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/)==-1) 
          { alert("提醒您:"+Email+"格式不正确！"); 
            eval(Form+Inputname+".focus();"); 
            return false; 
             } 
   else{ 
            return true; 
       } 
      }   
} 
//验证是否是数字
function CheckIsNum(Inform,Inputname,Num){ 
   if (!CheckIsNull(Inform,Inputname,Num))return false; 
else{ 
         var Form=Inform+"." 
         eval("Temp="+Form+Inputname+".value;"); 
      if(isNaN(Temp)){ 
                    alert("提醒您:"+Num+"应该为数字！"); 
                    eval(Form+Inputname+".className='RedInput';"); 
                    eval(Form+Inputname+".focus();"); 
                    return false; 
                     } 
   else{ 
        eval(Form+Inputname+".className="+Form+Inputname+".className.replace('RedInput','');"); 
           return true; 
          } 
    } 
} 
//验证是否为手机号码
function CheckIsMobile(Inform,Inputname,Mobile){ 
   if (!CheckIsNull(Inform,Inputname,Mobile))return false; 
   else{ 
  var Form=Inform+"." 
  eval("Temp="+Form+Inputname+".value;"); 
  if(Temp.search(/^1[3|5]\d{9}$/)==-1) 
  {   alert("提醒您:"+Mobile+"不为合法手机号码！"); 
   eval(Form+Inputname+".className='RedInput';"); 
   eval(Form+Inputname+".focus();"); 
   return false; 
  } 
  else{ 
           eval(Form+Inputname+".className="+Form+Inputname+".className.replace('RedInput','');"); 
              return true; 
       } 
 } 
} 
//验证是否为日期  文本框中输入的。 
function CheckIsDate(Inform,Inputname,date){
//.先判断是否为空，如果为空，直接返回false
 if(!CheckIsNull(Inform,Inputname,date)) return false;
 else{
var Form=Inform+".";
 //.再判断是否为日期格式
 eval("DateValue="+Form+Inputname+".value;");
 //.如果是数字的话,返回false
 if(DateValue.substring(4,5)!="-"||isNaN(DateValue.substring(0,4))||DateValue.substring(0,1)=="0"){
 alert(date+"格式不正确,格式:yyyy-mm-dd,且年份第一位不能为0,不能包含字母！");
 eval(Form+Inputname+".className='RedInput';"); 
 eval(Form+Inputname+".focus();");
 return false;
 }else{//.总体判断月开始
  if(DateValue.indexOf("-")==DateValue.lastIndexOf("-")||isNaN(DateValue.substring(5,DateValue.lastIndexOf("-")))||DateValue.substring(5,DateValue.lastIndexOf("-")).length>2||DateValue.substring(5,DateValue.lastIndexOf("-"))>12){
  alert(date+"格式不正确,格式:yyyy-mm-dd，且月份不能大于12,不能包含字母！");
  eval(Form+Inputname+".className='RedInput';"); 
  eval(Form+Inputname+".focus();");
  return false;
  }else{//.总体判断日期开始
   if(DateValue.substring(DateValue.lastIndexOf("-")+1).length>2||DateValue.substring(DateValue.lastIndexOf("-")+1)>31||isNaN(DateValue.substring(DateValue.lastIndexOf("-")+1)) ){
   alert(date+"格式不正确,格式:yyyy-mm-dd，且日期不能大于31,不能包含字母！");
   eval(Form+Inputname+".className='RedInput';"); 
   eval(Form+Inputname+".focus();");
   return false;
   }else{//.开始判断月份的大小
   var year=DateValue.substring(0,4);
   var month=DateValue.substring(5,DateValue.lastIndexOf("-"));
   var day=DateValue.substring(DateValue.lastIndexOf("-")+1);
     if(parseInt(month)==2){//..判断二月的情况
  if (year%4==0 && year%100 !=0 ||year%400 ==0 ){
    if(day>29){
     alert(date+"不正确,"+year+"年的二月最多只有29天！");
        eval(Form+Inputname+".className='RedInput';"); 
        eval(Form+Inputname+".focus();");
        return false;
    }
  }else{
   if(day>28){
     alert(date+"不正确,"+year+"年的二月最多只有28天！");
        eval(Form+Inputname+".className='RedInput';"); 
        eval(Form+Inputname+".focus();");
        return false;
    } 
  }
  }//.判断二月结束
  else if(parseInt(month)==1||parseInt(month)==3||parseInt(month)==7||parseInt(month)==8||month==10||month==12){//.判断有31天月份开始
     if(day>31){
  alert(date+"不正确,"+parseInt(month)+"月最多只有31天！");
        eval(Form+Inputname+".className='RedInput';"); 
        eval(Form+Inputname+".focus();");
        return false;
  }
 }//.判断有31的函数结束。
  else{//.有30天的情况
     if(day>30){
  alert(date+"不正确,"+parseInt(month)+"月最多只有30天！");
        eval(Form+Inputname+".className='RedInput';"); 
        eval(Form+Inputname+".focus();");
        return false;
  }
   } //.判断日期为30天结束    
   }  //.判断月份结束
  }//.总体判断日期结束
 }//..总体判断月结束
return true;
}
}
//验证是否选中单选框
function CheckRadio(Inputform,Inputname,Inputvalue){
var Form=Inputform+".";
var InputName=Inputname;
var flag=false;
eval("len="+Form+InputName+".length"); 
for (i=0;i<parseInt(len);i++){
eval("val="+Form+InputName+"["+i+"]"+".checked");
if(val){
flag=true;
}
}
if (flag==false){
alert("提醒您:"+Inputvalue+"必须选择！");
return false;

}else{
              return true;
}
}
//判断复选框是否被选中
function CheckCheckbox(Inputform,Inputname,Inputvalue){
       var Form=Inputform+"."; 
 var InputName=Inputname;  
 var flag=false;        
       eval("len0="+Form+InputName+".length;");
 eval("len="+parseInt(len0));
       for(i=0;i<len;i++){
  eval("val="+Form+InputName+"["+i+"].checked");
           if (val){
     flag=true;
  }
       }
if(flag==true){
    return true;
 }
else
{
    alert("提醒您：请选择"+Inputvalue+"!");
    return false;
}
}
//验证下拉列表框是否选定！
function CheckSelect(Inputform,Inputname,Inputvalue){
     var Form=Inputform+"."; 
  var InputName=Inputname; 
  eval("val="+Form+InputName+".value;");
  if (val==""){
     alert("提醒你：请选择"+Inputvalue+"!");
  return false;
  }else{return true;}
}
//判断指定表单中是否有特殊字符的判断.(本处特殊字符验证只是验证了数字,字母以及下划线)
function CheckIsChar(Inputform,Inputname,Inputvalue){
if (!CheckIsNull(Inputform,Inputname,Inputvalue))return false; 
var Form=Inputform+".";
var Name=Inputname;
eval("Value="+Form+Name+".value;");
eval("Len="+Form+Name+".value.length;");
for(var i=0;i<Len;++i)
     {
       tkey=Value.charAt(i);
    var str_val=tkey.charCodeAt(0);
       if(str_val>=48&&str_val<=57||str_val>=65&&str_val<=90||str_val>=97&&str_val<=122||str_val==95)
       {
    }
    else
    {
    alert("提醒您:"+Inputvalue+"只能包含字母,数字或者下划线!");
       eval(Form+Inputname+".focus();");
    return false;
    }
     }
  return true;}
//.汉字的判断
function CheckIsChinese(Inputform,Inputname,Inputvalue){
if (!CheckIsNull(Inputform,Inputname,Inputvalue))return false; 
var Form=Inputform+".";
var Name=Inputname;
eval("Value="+Form+Name+".value;");
eval("Len="+Form+Name+".value.length;");
for(i=0;i<Len;i++){ 
char=Value.charCodeAt(i); 
if(!(char>255)){ 
    alert("提醒您:"+Inputvalue+"只能是汉字!"); 
    eval(Form+Inputname+".focus();");
return false; 
} 
} 
return true;
}

function includeJsFile(id,src)
{
	var scriptTag = document.getElementById( id ); 
    var oHead = document.getElementsByTagName('HEAD')[0];
    while (tempScript = document.getElementById(id)) 
	{
		tempScript.parentNode.removeChild(tempScript);
		for (var prop in tempScript) 
		{
		  try
		  {
		  	delete tempScript[prop];
		  }
		  catch(e)
		  {
		  
		  }
		}
    }
    var oScript= document.createElement("script");
	oScript.id = id;
	oScript.charset='utf-8';
    oScript.type = "text/javascript"; 
    oScript.src=src;
    oHead.appendChild( oScript);
}



function getValueHTML(table,field,id,isnum,size)
{
	
	var obj= document.getElementById("" + field + id);
	var inputsize =  size || 5; 
	var value=$("#"+field + id).text();
	$(obj).unbind("click");
	//alert($("#" + field + id).html()); 
	$("#" + field + id).html("");
	$("#" + field + id).append("<input type='text' size='"+inputsize+"' id='input"+field+id+"' value='"+value+"' />");
	$("#" + field + id).append("<input type='button' value='修改' class='qianbibutton' onclick=\"changeValue('"+table+"','"+field+"','"+id+"','"+isnum+"','"+inputsize+"')\" />");
	var input3=document.createElement("input");
	input3.type="button";
	input3.value="取消";
	input3.className="qianbibutton";
	$(input3).bind("mouseup",function(){ $("#" + field + id).html(value);  $(obj).bind("click",function(){ getValueHTML(table,field,id,isnum,size) });        } );
	$("#" + field + id).append($(input3));

	
}

function changeValue(table,field,id,isnum,size)
{
	
	var value=document.getElementById("input" + field + id).value;
	if(isnum==1 && isNaN(value)  )
	{
		alert("提醒您:应该为数字！"); 
		return false;
	}
	var src="?table=" + table + "&field=" + field + "&size=" + size + "&isnum=" + isnum + "&id=" + id + "&value=" + encodeURI(value);
	
	includeJsFile("Ajax_change",src) 
}

function changeSuccess(flag,table,field,id,isnum,size)
{
  
	if(flag==1)
		alert("数据成功被修改 O(∩_∩)O~");
	else
		alert("没有任何数据更新 (╯﹏╰)!!!");
	var obj=document.getElementById("" + field + id);
	var value=document.getElementById("input" + field + id).value;
	obj.innerHTML=value;
	$(obj).unbind("click");
	$(obj).bind("click",function(){getValueHTML(table,field,id,isnum,size);});
}

