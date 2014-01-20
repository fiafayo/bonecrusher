/*
Please refer to readme.html for full Instructions

Text[...]=[title,text]

Style[...]=[TitleColor,TextColor,TitleBgColor,TextBgColor,TitleBgImag,TextBgImag,TitleTextAlign,TextTextAlign, TitleFontFace, TextFontFace, TipPosition, StickyStyle, TitleFontSize, TextFontSize, Width, Height, BorderSize, PadTextArea, CoordinateX , CoordinateY, TransitionNumber, TransitionDuration, TransparencyLevel ,ShadowType, ShadowColor]
*/

var FiltersEnabled = 1 // if your not going to use transitions or filters in any of the tips set this to 0

Text[0]=["Me Email","Click here to send me an email "]
Text[1]=["FORMAT no Perpanjangan TA","no S.Panj: <b><font color=009900>0117</font><font color=FF0000>2<font color=0066CC>0910</font></font></b>, <font color=009900><br>"+
		 "<strong>0117</strong></font>=nomer urut, <br><strong><font color=FF0000>2</font></strong>=semester genap , <br><strong><font color=FF0000><font color=0066CC>0910</font></font></strong>=tahun ajaran 2009-2010 <br><br>"+
		 "no S.Panj: <b><font color=009900>0045</font><font color=FF0000>1<font color=0066CC>1011</font></font></b>, <font color=009900><br>"+
		 "<strong>0045</strong></font>=nomer urut, <br><strong><font color=FF0000>1</font></strong>=semester ganjil, <br><strong><font color=FF0000><font color=0066CC>1011</font></font></strong>=tahun ajaran 2010-2011 <br> "]
Text[2]=["This is the title","Well How do you find this Tip message to be?"]
Text[3]=["Right","This tip Is right positioned"]
Text[4]=["Center","This tip Is center positioned"]
Text[5]=["Left","This tip Is left positioned"]
Text[6]=["Float","This tip Is float positioned at a (10,10) coordinate, It also floats with the scrollbars so it is always static"]
Text[7]=["Fixed","This tip Is fixed positioned at a (1,1) coordinate"]
Text[8]=["sticky style","This tip will sticky around<BR>This is useful when you want to insert a link like this <A href='http://migoicons.tripod.com'>Home Page</A>"]
Text[9]=["keep style","This sticks around the mouse"]
Text[10]=["Left coordinate control","This tip is right positioned with a 40 X coordinate "]
Text[11]=["Top coordinate control","This tip is right positioned with a 50 Y coordinate"]
Text[12]=["FORMAT no Surat Pengantar Nilai","no SPN: <b><font color=009900>0117</font><font color=FF0000>2<font color=0066CC>0910</font></font></b>, <font color=009900><br>"+
"<strong>0117</strong></font>=nomer urut, <br><strong><font color=FF0000>2</font></strong>=semester genap , <br><strong><font color=FF0000><font color=0066CC>0910</font></font></strong>=tahun ajaran 2009-2010 <br><br>"+
"no SPN: <b><font color=009900>0045</font><font color=FF0000>1<font color=0066CC>1011</font></font></b>, <font color=009900><br>"+
"<strong>0045</strong></font>=nomer urut, <br><strong><font color=FF0000>1</font></strong>=semester ganjil, <br><strong><font color=FF0000><font color=0066CC>1011</font></font></strong>=tahun ajaran 2010-2011 <br> "]
Text[13]=["FORMAT no Surat Tugas KP","no ST: <b><font color=009900>0117</font><font color=FF0000>2<font color=0066CC>0910</font></font></b>, <font color=009900><br>"+
"<strong>0117</strong></font>=nomer urut, <br><strong><font color=FF0000>2</font></strong>=semester genap , <br><strong><font color=FF0000><font color=0066CC>0910</font></font></strong>=tahun ajaran 2009-2010 <br><br>"+
"no ST: <b><font color=009900>0045</font><font color=FF0000>1<font color=0066CC>1011</font></font></b>, <font color=009900><br>"+
"<strong>0045</strong></font>=nomer urut, <br><strong><font color=FF0000>1</font></strong>=semester ganjil, <br><strong><font color=FF0000><font color=0066CC>1011</font></font></strong>=tahun ajaran 2010-2011 <br> "]
Text[14]=["FORMAT no SK Penguji","no SK: <b><font color=009900>0117</font><font color=FF0000>2<font color=0066CC>0910</font></font></b>, <font color=009900><br>"+
"<strong>0117</strong></font>=nomer urut, <br><strong><font color=FF0000>2</font></strong>=semester genap , <br><strong><font color=FF0000><font color=0066CC>0910</font></font></strong>=tahun ajaran 2009-2010 <br><br>"+
"no SK: <b><font color=009900>0045</font><font color=FF0000>1<font color=0066CC>1011</font></font></b>, <font color=009900><br>"+
"<strong>0045</strong></font>=nomer urut, <br><strong><font color=FF0000>1</font></strong>=semester ganjil, <br><strong><font color=FF0000><font color=0066CC>1011</font></font></strong>=tahun ajaran 2010-2011 <br> "]
Text[15]=["FORMAT no Surat Permohonan KP","no SP: <b><font color=009900>0117</font><font color=FF0000>2<font color=0066CC>0910</font></font></b>, <font color=009900><br>"+
"<strong>0117</strong></font>=nomer urut, <br><strong><font color=FF0000>2</font></strong>=semester genap , <br><strong><font color=FF0000><font color=0066CC>0910</font></font></strong>=tahun ajaran 2009-2010 <br><br>"+
"no SP: <b><font color=009900>0045</font><font color=FF0000>1<font color=0066CC>1011</font></font></b>, <font color=009900><br>"+
"<strong>0045</strong></font>=nomer urut, <br><strong><font color=FF0000>1</font></strong>=semester ganjil, <br><strong><font color=FF0000><font color=0066CC>1011</font></font></strong>=tahun ajaran 2010-2011 <br> "]
Text[16]=["","Some Lists <li>list one</li> <li>list two</li> <li>list three</li> <li>list four</li>"]



Style[0]=["white","black","#000099","#E8E8FF","","","","","","","","","","",200,"",2,2,10,10,51,1,0,"",""]
Style[1]=["white","black","#000099","#E8E8FF","","","","","","","center","","","",200,"",2,2,10,10,"","","","",""]
Style[2]=["white","black","#000099","#E8E8FF","","","","","","","left","","","",200,"",2,2,10,10,"","","","",""]
Style[3]=["white","black","#000099","#E8E8FF","","","","","","","float","","","",200,"",2,2,10,10,"","","","",""]
Style[4]=["white","black","#000099","#E8E8FF","","","","","","","fixed","","","",200,"",2,2,1,1,"","","","",""]
Style[5]=["white","black","#000099","#E8E8FF","","","","","","","","sticky","","",200,"",2,2,10,10,"","","","",""]
Style[6]=["white","black","#000099","#E8E8FF","","","","","","","","keep","","",200,"",2,2,10,10,"","","","",""]
Style[7]=["white","black","#000099","#E8E8FF","","","","","","","","","","",200,"",2,2,40,10,"","","","",""]
Style[8]=["white","black","#000099","#E8E8FF","","","","","","","","","","",200,"",2,2,10,50,"","","","",""]
Style[9]=["white","black","#000099","#E8E8FF","","","","","","","","","","",200,"",2,2,10,10,51,0.5,75,"simple","gray"]
Style[10]=["white","black","black","white","","","right","","Impact","cursive","center","",3,5,200,150,5,20,10,0,50,1,80,"complex","gray"]
Style[11]=["white","black","#000099","#E8E8FF","","","","","","","","","","",200,"",2,2,10,10,51,0.5,45,"simple","gray"]
Style[12]=["white","black","#000099","#E8E8FF","","","","","","","","","","",200,"",2,2,10,10,"","","","",""]

applyCssFilter()

