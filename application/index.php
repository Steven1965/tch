<?php
	include ("global.php");
    include ("common_functions.php");
    include("header.php");
    include("login.php");

?>
	<TABLE BORDERCOLOR = "#000000" CELLPADDING=2 CELLSPACING=0 BGCOLOR="#ffffff">
		<COL WIDTH=0>
		<COL WIDTH=0>
		<COL WIDTH=500>
		<COL WIDTH=0>
		<COL WIDTH=0>
		<COL WIDTH=300>
		<COL WIDTH=0>
                <TBODY>
		<TR>
			<TD ROWSPAN=3 BGCOLOR="#6699000"> </TD>
			<TD COLSPAN=2 HEIGHT=30 VALIGN=TOP BGCOLOR="#6699000"> </TD>
			<TD ROWSPAN=3 BGCOLOR="#6699000"> </TD>
			<TD COLSPAN=2 HEIGHT=30 VALIGN=TOP BGCOLOR="#6699000"> </TD>
			<TD ROWSPAN=3 BGCOLOR="#6699000"> </TD>
		</TR>
		<TR>
                        <TD></TD>
                        <TD>
                         <P>Welcome to Tournament Clearing House.</P> 
                         <P>Sign In or register to help you manage your team's tournament registrations.</P> 
                         </TD>
                        <TD></TD>
                        <TD>
<?php
                              login_form();
?>
                         </td>
		</TR>
		<TR>
			<TD COLSPAN=5 HEIGHT=30 VALIGN=TOP BGCOLOR="#6699000"> </TD>
		</TR>
        </TABLE>

<?php
    include("trailer.php");
?>
