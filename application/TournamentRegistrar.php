<?php
    include("header.php");
?>
	<!--TABLE BORDER BORDERCOLOR = "#rrggbb" CELLPADDING=2 CELLSPACING=2 BGCOLOR="#ffffff"-->
	<TABLE BORDER=2 BORDERCOLOR = "#ffffff" CELLPADDING=2 CELLSPACING=2 BGCOLOR="#000000">
		<COL WIDTH=0>
		<COL WIDTH=300>
		<COL WIDTH=0>
		<COL WIDTH=300>
		<COL WIDTH=0>
                <TBODY>
		<TR> <TD HEIGHT=20 ></TD><TD></TD><TD></TD><TD></TD><TD></TD></TR>
		<TR> <TD HEIGHT=20 ></TD><TD></TD><TD></TD><TD></TD><TD></TD></TR>
		<TR> <TD HEIGHT=20 ></TD><TD></TD><TD></TD><TD></TD><TD></TD></TR>
		<TR> <TD HEIGHT=20 ></TD><TD></TD><TD></TD><TD></TD><TD></TD></TR>
		<TR> <TD HEIGHT=20 ></TD><TD></TD><TD></TD><TD></TD><TD></TD></TR>
                </TBODY>
        </TABLE>

	<TABLE BORDER=2 BORDERCOLOR = "#000000" CELLPADDING=2 CELLSPACING=0 BGCOLOR="#ffffff">
		<COL WIDTH=0>
		<COL WIDTH=300>
		<COL WIDTH=0>
		<COL WIDTH=300>
		<COL WIDTH=0>

		<TR>
			<TD COLSPAN=8 HEIGHT=30 WIDTH=800 VALIGN=TOP BGCOLOR="#418246"> </TD>
		</TR>
		<TR>
			<TD ROWSPAN=3 BGCOLOR="#418246"> </TD>
			<TD COLSPAN=3 HEIGHT=10 WIDTH=800 VALIGN=TOP BGCOLOR="#418246"> </TD>
			<TD ROWSPAN=3 BGCOLOR="#418246"></TD>
			<TD COLSPAN=2 HEIGHT=10 WIDTH=800 VALIGN=TOP BGCOLOR="#418246"> </TD>
			<TD ROWSPAN=3 BGCOLOR="#418246"></TD>
		</TR>
<!-- BEGIN MAIN CONTENTS -->
		<TR VALIGN=TOP>
                        <TD></TD>
			<TD>
                            <P> Web Blurb goes here </P>
			</TD>
                        <TD></TD>
			<TD>
				<P ALIGN=CENTER>&nbsp; 
				</P>
				<P ALIGN=CENTER>Please enter username and password: 
				</P>
				<FORM ACTION="/TournamentRegistrar/login.php" METHOD="POST">
					<DIV ALIGN=LEFT>
						<P>UserName: <INPUT TYPE=TEXT NAME="username" 
                                                              SIZE=20 STYLE="width: 1.92in; height: 0.26in">
												</P>
					</DIV>
					<DIV ALIGN=LEFT>
						<P>Password: <INPUT TYPE=PASSWORD NAME="pass" 
                                                              SIZE=30 STYLE="width: 2.85in; height: 0.26in"></P>
					</DIV>
					<DIV ALIGN=CENTER>
						<P><INPUT TYPE=SUBMIT NAME="submit" VALUE="login" 
                                                    STYLE="width: 0.49in; height: 0.28in">
						<INPUT TYPE=RESET VALUE="RESET" STYLE="width: 0.7in; height: 0.28in">
												</P>
					</DIV>
				</FORM>
                                <!--"/TournamentRegistrar/TournamentRegistrar.php" -->
				<P ALIGN=CENTER><A HREF="/TournamentRegistrar/register.php">register</A></P>
			</TD>
                        <TD></TD>
		</TR>
		<TR>
			<TD COLSPAN=8 HEIGHT=5 VALIGN=TOP BGCOLOR="#418246">
			</TD>
		</TR>
</TABLE>
<?php
    include("trailer.php");
?>
