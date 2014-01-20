<script language = "Javascript">
/**
 * DHTML date validation script for dd/mm/yyyy. Courtesy of SmartWebby.com (http://www.smartwebby.com/dhtml/)
 */
// Declaring valid date character, minimum year and maximum year
var dtCh= "/";
var minYear=1900;
var maxYear=2100;

function isInteger(s){
	var i;
    for (i = 0; i < s.length; i++){   
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}

function stripCharsInBag(s, bag){
	var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not in bag, append to returnString.
    for (i = 0; i < s.length; i++){   
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) returnString += c;
    }
    return returnString;
}

function daysInFebruary (year){
	// February has 29 days in any year evenly divisible by four,
    // EXCEPT for centurial years which are not also divisible by 400.
    return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
}
function DaysArray(n) {
	for (var i = 1; i <= n; i++) {
		this[i] = 31
		if (i==4 || i==6 || i==9 || i==11) {this[i] = 30}
		if (i==2) {this[i] = 29}
   } 
   return this
}

function isDate(dtStr){
	var daysInMonth = DaysArray(12)
	var pos1=dtStr.indexOf(dtCh)
	var pos2=dtStr.indexOf(dtCh,pos1+1)
	var strDay=dtStr.substring(0,pos1)
	var strMonth=dtStr.substring(pos1+1,pos2)
	var strYear=dtStr.substring(pos2+1)
	strYr=strYear
	if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1)
	if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1)
	for (var i = 1; i <= 3; i++) {
		if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)
	}
	month=parseInt(strMonth)
	day=parseInt(strDay)
	year=parseInt(strYr)
	if (pos1==-1 || pos2==-1){
		alert("The date format should be : mm/dd/yyyy")
		return false
	}
	if (strMonth.length<1 || month<1 || month>12){
		alert("Please enter a valid month")
		return false
	}
	if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
		alert("Please enter a valid day")
		return false
	}
	if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
		alert("Please enter a valid 4 digit year between "+minYear+" and "+maxYear)
		return false
	}
	if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
		alert("Please enter a valid date")
		return false
	}
return true
}

function ValidateForm(){
	var dt=document.frmSample.txtDate
	if (isDate(dt.value)==false){
		dt.focus()
		return false
	}
    return true
 }
var expDays = 30;
var exp = new Date(); 
exp.setTime(exp.getTime() + (expDays*24*60*60*1000));

function When(info){
			var mydate=new Date()
		var year=mydate.getYear()
		if (year < 1000)
		year+=1900
		var day=mydate.getDay()
		var month=mydate.getMonth()
		var daym=mydate.getDate()
		if (daym<10)
		daym="0"+daym
		var dayarray=new Array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu")
		var montharray=new Array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember")
		//document.write("<small><font color='#0080C0' face='arial'><b>"+dayarray[day]+", "+daym+" "+montharray[month]+" "+year+"</b></font></small>")

	// When
	    	var rightNow = new Date()
		var WWHTime = 0;
		WWHTime = GetCookie('WWhenH')
		
		WWHTime = WWHTime * 1

		var lastHereFormatting = new Date(WWHTime);  // Date-i-fy that number
	        var intLastVisit = (lastHereFormatting.getYear() * 10000)+(lastHereFormatting.getMonth() * 100) + lastHereFormatting.getDate()
	        var lastHereInDateFormat = "" + lastHereFormatting;  // Gotta use substring functions
	    //    var dayOfWeek = lastHereInDateFormat.substring(0,3)
	      //  var dateMonth = lastHereInDateFormat.substring(4,10)
		
		var hours = "" + lastHereFormatting.getHours()
		// var year = lastHereFormatting.getYear()
              //  if (year < 1000) year+=1900
		var minutes = "" + lastHereFormatting.getMinutes()
		if (minutes.substring(0,1) == minutes){
			minutes = "0" + minutes
		}
	        var WWHText = dayarray[day] + ",  "+daym+" " + montharray[month] + " " + year + " at " +  hours + ":" + minutes// display
	
		SetCookie ("WWhenH", rightNow.getTime(), exp)

	return WWHText;
}

function Count(info){
	var psj=0;
	// How many times
		var WWHCount = GetCookie('WWHCount')
		if (WWHCount == null) {
			WWHCount = 0;
		}
		else{
			WWHCount++;
		}
		SetCookie ('WWHCount', WWHCount, exp);


	return WWHCount+1;
}



function set(){
//	VisitorName = prompt("Who are you?", "Nada");
//	SetCookie ('VisitorName', VisitorName, exp);
	SetCookie ('WWHCount', 0, exp);
	SetCookie ('WWhenH', 0, exp);
}

function getCookieVal (offset) {  
	var endstr = document.cookie.indexOf (";", offset);  
	if (endstr == -1)    
		endstr = document.cookie.length;  
		return unescape(document.cookie.substring(offset, endstr));
}

function GetCookie (name) {  
	var arg = name + "=";  
	var alen = arg.length;  
	var clen = document.cookie.length;  
	var i = 0;  
	while (i < clen) {    
	var j = i + alen;    
	if (document.cookie.substring(i, j) == arg)      
		return getCookieVal (j);    
		i = document.cookie.indexOf(" ", i) + 1;    
		if (i == 0) break;   
	}  
	return null;
}

function SetCookie (name, value) {  
	var argv = SetCookie.arguments;  
	var argc = SetCookie.arguments.length;  
	var expires = (argc > 2) ? argv[2] : null;  
	var path = (argc > 3) ? argv[3] : null;  
	var domain = (argc > 4) ? argv[4] : null;  
	var secure = (argc > 5) ? argv[5] : false;  
	document.cookie = name + "=" + escape (value) + 
	((expires == null) ? "" : ("; expires=" + expires.toGMTString())) + 
	((path == null) ? "" : ("; path=" + path)) +  
	((domain == null) ? "" : ("; domain=" + domain)) +    
	((secure == true) ? "; secure" : "");
}

function DeleteCookie (name) {  
	var exp = new Date();  
	exp.setTime (exp.getTime() - 1);  
	// This cookie is history  
	var cval = GetCookie (name);  
	document.cookie = name + "=" + cval + "; expires=" + exp.toGMTString();

}


/*function cetak() {
   yang_mau_dicetak=document.getElementById('halamanprint').innerHTML;
    windowbaru=window.open('about:blank','_window','location=0');
    windowbaru.document.write(yang_mau_dicetak);
    windowbaru.document.close();
    windowbaru.print();
    windowbaru.close();
}*/
function cetak() {
   
    window.print();
}


function last_visit()
{
		/***********************************************
		* Display time of last visit script- by JavaScriptKit.com
		* This notice MUST stay intact for use
		* Visit JavaScript Kit at http://www.javascriptkit.com/ for this script and more
		***********************************************/
		
		var lastvisit=new Object()
		lastvisit.firstvisitmsg="Anda pengunjung pertama hari ini !" //Change first visit message here
		lastvisit.subsequentvisitmsg="Terakhir dikunjungi <b>[displaydate]</b>" //Change subsequent visit message here
		
		lastvisit.getCookie=function(Name){ //get cookie value
		var re=new RegExp(Name+"=[^;]+", "i"); //construct RE to search for target name/value pair
		if (document.cookie.match(re)) //if cookie found
		return document.cookie.match(re)[0].split("=")[1] //return its value
		return ""
		}
		
		lastvisit.setCookie=function(name, value, days){ //set cookei value
		var expireDate = new Date()
		//set "expstring" to either future or past date, to set or delete cookie, respectively
		var expstring=expireDate.setDate(expireDate.getDate()+parseInt(days))
		document.cookie = name+"="+value+"; expires="+expireDate.toGMTString()+"; path=/";
		}
		
		lastvisit.showmessage=function(){
		if (lastvisit.getCookie("visitcounter")==""){ //if first visit
		lastvisit.setCookie("visitcounter", 2, 730) //set "visitcounter" to 2 and for 730 days (2 years)
		document.write(lastvisit.firstvisitmsg)
		}
		else
		document.write(lastvisit.subsequentvisitmsg.replace("\[displaydate\]", new Date().toLocaleString()))
		}
		
		lastvisit.showmessage()
}
//  End Script -->
</script>
