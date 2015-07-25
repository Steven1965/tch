  function printTabHeader(){
      print("<link rel=\"stylesheet\" href=\"../llims.css\" media=\"screen\" type=\"text/css\"></link>");
      print("<link rel=\"stylesheet\" href=\"../htab.css\" media=\"screen\" type=\"text/css\"></link>");
      print("<script language=\"JavaScript\" src=\"../tabControl.js\"></script>");
  }



  function printTab($position, $tabName) {
                print("<div class=\"tab\" style=\"left:" + ((position-2)*120+10) + "\" id=\"tab" + (position-1) + "\"
                        onClick=\"showPanel(" + (position -1) + ")\">");
                print(tabName);
                print("</div>");
  }

  function printFormSections($position, $tabName, $startIndex, $endIndex) {
    print("<div class=\"section\" id=\"section" + ($position-1) + "\">");
    print("<div class=\"panel\" id=\"panel" + ($position-1) + "\">");

    print("<br>");
    print("<em>" + $tabName + "</em>");
    print("<br>");
    //printSections(startIndex, endIndex);
    print("</div>");
    //printFooter(position);
    print("</div>");
  }

