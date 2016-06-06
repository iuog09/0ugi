function toggleLayer(Id)
{
	var obj = document.getElementById(Id);

	obj.style.display = obj.style.display=="none"?"":"none";
}

function showIF(Id, val, processEnable)
{
	var obj = document.getElementById(Id);
	var condition = (event.srcElement.value == val);
	var enb = (typeof processEnable == "undefined")?false:processEnable;

	if (obj == null) return false;
	obj.style.display = condition?"":"none";
	if (enb) obj.disabled = condition?false:true;
}

function enableIF(Id, bool)
{
	var obj = document.getElementById(Id);
	if (obj == null) return false;
	obj.disabled = !bool;
	if (bool) obj.focus();
}

// Allow only number input
function onlyNumber(evt)
{
	var Allow = [8,9,16,17,18,46,48,49,50,51,52,53,54,55,56,57,96,97,98,99,100,101,102,103,104,105,116];

	for (var i=0; i < Allow.length; i++) {
		if (evt.keyCode == Allow[i]) return true;
	}
	return false;
}


function focusPoint(obj)
{
	var objs = obj.form.elements[obj.name];
	
	if (objs[1].value == '') {
		objs[1].value = strRepeat('0', objs[1].maxLength);
	}
}

function blurPoint(obj)
{
	var objs = obj.form.elements[obj.name];
	if (obj.value == '') objs[1].value = '';
}

function strRepeat(str, rep)
{
	var ret = "";
	for (var i=0; i<rep; i++) ret += str;
	return ret;
}

function layerOn(Id)
{
	try {
		document.getElementById(Id).style.display = "";
	} catch(e){}
}

function layerOff(Id)
{
	try {
		document.getElementById(Id).style.display = "none";
	} catch(e){}
}

function popup(Id,Top,Left,Width,Height,Scroll)
{
	var W = screen.availWidth;
	var H = screen.availHeight;

	if (Left == 0) Left = (W-Width)/2;
	if (Top == 0) Top = (H-Height)/2;

	try {
		var win = window.open(
			'../admin/popup_view.php?id='+Id, 'Popup_'+Id, 
			'width='+Width+',height='+Height+',top='+Top+',left='+Left+',menubar=no,location=no,resizable=no,scrollbars='+(Scroll?'yes':'no')+',status=no'
		);
		win.focus();
	} catch(e) {}
}

/** 
* string String::cut(int len)
*/
String.prototype.cut = function(len) {
	var str = this;
	var l = 0;
	for (var i=0; i<str.length; i++) {
		l += (str.charCodeAt(i) > 128) ? 2 : 1;
		if (l > len) return str.substring(0,i) + "...";
	}
	return str;
}

/** 
* bool String::bytes(void)
*/
String.prototype.bytes = function() {
	var str = this;
	var l = 0;
	for (var i=0; i<str.length; i++) l += (str.charCodeAt(i) > 128) ? 2 : 1;
	return l;
}


function getCookie( cookieName ){
  var search = cookieName + "=";
  var cookie = document.cookie;

  // 현재 쿠키가 존재할 경우
  if( cookie.length > 0 )
  {
   // 해당 쿠키명이 존재하는지 검색한 후 존재하면 위치를 리턴.
   var startIndex = cookie.indexOf( cookieName );

   // 만약 존재한다면
   if( startIndex != -1 )
   {
    // 값을 얻어내기 위해 시작 인덱스 조절
    startIndex += cookieName.length;

    // 값을 얻어내기 위해 종료 인덱스 추출
    var  endIndex = cookie.indexOf( ";", startIndex );

    // 만약 종료 인덱스를 못찾게 되면 쿠키 전체길이로 설정
    if( endIndex == -1) endIndex = cookie.length;

    // 쿠키값을 추출하여 리턴
    return unescape( cookie.substring( startIndex + 1, endIndex ) );
   }
   else
   {
    // 쿠키 내에 해당 쿠키가 존재하지 않을 경우
    return false;
   }
  }
  else
  {
   // 쿠키 자체가 없을 경우
   return false;
  }
 }

 

 /**
  * 쿠키 설정
  * @param cookieName 쿠키명
  * @param cookieValue 쿠키값
  * @param expireDay 쿠키 유효날짜
  */
 function setCookie( cookieName, cookieValue)
 {
	document.cookie = cookieName + "=" + escape( cookieValue );
 }
 