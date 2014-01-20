<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<script language="JavaScript">
<!--
var counter = 0;

function moreFields()
{
	counter++;
	var newFields = document.getElementById('readroot').cloneNode(true);
	newFields.id = '';
	newFields.style.display = 'block';
	var newField = newFields.childNodes;
	for (var i=0;i<newField.length;i++)
	{
		var theName = newField[i].name
		if (theName)
			newField[i].name = theName + counter;
	}
	var insertHere = document.getElementById('writeroot');
	insertHere.parentNode.insertBefore(newFields,insertHere);
}

window.onload = moreFields;


--></script>
<body>
<?php
foreach ( $HTTP_GET_VARS as $key=>$value ) {
 print "$key == $value<BR>\n";
 }
 ?>
 
<div id="readroot" style="display: none">
<input type="button" value="Remove review" style="font-size: 10px"
		onClick="
			this.parentNode.parentNode.removeChild(this.parentNode);
		"><input name="cd_1" value="title"><select name="rankingsel_1">
		<option>Rating</option>
		<option value="excellent">Excellent</option>
		<option value="good">Good</option>
		<option value="ok">OK</option>
		<option value="poor">Poor</option>
		<option value="bad">Bad</option>
	</select>

	<textarea name="review_1">Short review</textarea>Radio buttons included to test them in Explorer:
	<input type="radio" name="something" value="test1">Test 1
	<input type="radio" name="something" value="test2">Test 2

</div>

<form>

<span id="writeroot"></span>
<input type="button" value="Give me more fields!" onClick="moreFields()">
<input type="submit" value="Send form" >

</form>

</body>
</html>
