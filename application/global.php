<?php
//$siteroot="/treg/";
$siteroot="/treg2/";
//$siteroot-"/";

$webroot="http://tch.org/treg2/";
//$webroot="http://tch.org/treg/";
//$webroot="http://www.tournamentclearinghouse.com/";

$player_documentation_type=array("PLYRC_FRONT" => "Front of Player Card", 
                                "PLYRC_BACK" => "Back of Player Card", 
                                "PLYR_MREL" => "Medical Release");

$roster_documentation_type=array("RSTR_FRONT" =>  "League Roster", 
                                 "TMNT_TVL_PERM" => "Permission To Travel",
								 "TMNT_SIGN_OFF" => "Tournament Sign Off Sheet");

$tounament_documentation_type=array("TMNT_RULES" =>  "Tournament Rules");

$roster_item_type=array("PLAYER" => "Player", 
                        "GUEST" => "Guest", 
                        "HCOACH" => "Head Coach",
                        "ACOACH" => "Asst Coach",
                        "TRAINER" => "Trainer",
						"MANAGER" => "Manager");

$tournament_documentation_type=array("TEAM_INFO" =>  "Team Info", 
                                 "MEDIA_WAIVER" => "Media Waiver",
								 "OTHER" => "Other");
date_default_timezone_set("US/Eastern");
?> 
