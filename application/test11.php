<?php
include header.php
?>

	<form  enctype="multipart/form-data" action="insert.php"  method="post">
	
	<table border= 0 cellpadding="1" cellspacing="0"class="txt" align="left"  >

	<tr bgcolor = "lightgreen">
	<td align="RIGHT" class="bText"  >
	<div align="right"><strong>Player</strong></div></td>
	<td bgcolor="lightgreen"></td>
	</tr> 
		
		
	<tr>
	<td align="RIGHT" class="bText">
	<div align="right"><strong>First name:</strong></div></td>
	<td  onMouseOver="this.className='borderOn'" onMouseOut="this.className='borderOff'" class="borderOff"> <b>
	<input type="TEXT" name="Text1"   >
	
	</b></tr> <!-- input type = text-->

	<tr>
	<td align="RIGHT" class="bText">
	<div align="right"><strong>Last name:</strong></div></td>
	<td onMouseOver="this.className='borderOn'" onMouseOut="this.className='borderOff'" class="borderOff"> <b>
	<input  type="TEXT" name="Text2"  >
	
	
	
	</b></tr> <!-- input type = text-->

	<tr>
	<td align="RIGHT" class="bText">
	<div align="right"><strong>Birth date:</strong></div></td>
	<td onMouseOver="this.className='borderOn'" onMouseOut="this.className='borderOff'" class="borderOff"> <b>
	<input type="TEXT" name="Text3"  >
	</b></tr> <!-- input type = date-->

<tr>
	<td align="RIGHT" >
	<div align="right"><b><input type="submit"  value="Add" style="width: 100px" value="Wide button" class = "btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" onclick="this.form.target='_blank';return true ReqField1Validator();" ></td>
	</tr>
	<!-- Add button -->

	<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
    <input name="userfile" type="file" id="userfile"> 
	
	<tr>
	<td align="RIGHT" >
	<div align="right"><b><a href ="info.php"><input type ="image" src="back.png" alt="Go back to All records"></a></td>
	</tr>
	<!-- Go to records button -->
	
	</table>
	</form>
	
<?php 
include trailer.php

?>	