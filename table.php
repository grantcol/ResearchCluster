<?php 
session_start();
include 'php/funcs.php';
$word = $_GET["word"];
$req = buildRequest( $word );
$response = execRequest( $req );
$xml = new SimpleXMLElement($response);
$_SESSION['curr_query_xml'] = xmlObj2Str($xml);
$_SESSION["xml_p"] = "null";
$xml_p = array();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Narrow Jumbotron Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="jumbotron-narrow.css" rel="stylesheet">
    <link rel='stylesheet' href='../css/nprogress.css'/>

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!--<script src="../../assets/js/ie-emulation-modes-warning.js"></script>-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
    ul { 
      list-style-type: none; 
      list-style-image: none; 
    } 
    li{
      text-decoration: none;
      text-align: left;
    }
    </style>
  </head>

  <body>

    <div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation" class="active"><a href="index.php">Home</a></li>
            <li role="presentation"><a href="https://github.com/grantcol/ResearchCluster">About</a></li>
            <li role="presentation"><a href="history.php">History</a></li>
          </ul>
        </nav>
        <h3 class="text-muted">Research Team 8</h3>
      </div>
      <div id="sub_cloud"></div>
      <div>
        <div class="btn-group" role="group" aria-label="...">
          <a class="btn btn-default" id="save_btn" href="#" role="button">Save Results</a>
          <a class="btn btn-default" id="sub_btn" href="#" role="button">Subset Select</a>
        </div>
      </div>
      <table id="result_table" class="table table-hover table-condensed">
        <?php
        $count = 0;
        foreach($xml->document as $doc)
        {
          echo "<tr><td>

                <div class='checkbox'>
                <label>
                  <input type='checkbox' value='' id='sub_".$count."'>
                  Sub 
                </label>
                </div>

                <div class='checkbox'>
                <label>
                  <input type='checkbox' value='' id='save_".$count."'>
                  Save
                </label>
                </div>

                </td>";

          echo "<td>".$count.".</td><td>";
          echo "<p>".linkify($doc->title)."</p>";
          $a_str = "<p>";
          $authors = explode(";", $doc->authors);
          foreach($authors as $a) {
            $last = explode(",", $a);
            $a_str .= "<a href='cloud.php?type=auth&word=".$last[0]."'>".$a."</a>";
          }
          echo $a_str."</p>";
          echo "<p>IEEE</p>";
          echo "<p>".$doc->pubtitle."</p>";
          echo "<p><a href=".$doc->pdf.">PDF</a></p>";
          echo "</td></tr>";
          $xml_p[$count] = xmlDoc2Str($doc);
          $count++;
        }
        $_SESSION["xml_p"] = $xml_p;
        ?>
      </table>

      <footer class="footer">
        <p>&copy; CS310 Team 8, Spring 2015</p>
      </footer>

    </div> <!-- /container -->
    <script type="text/javascript" src="../js/jquery-1.11.2.min.js"></script>
    <script src='../js/nprogress.js'></script>
    <script type="text/javascript">

    function getSelected(sel) {
      var selected = [];
      var table = document.getElementById("result_table");
      for (var i = 0, row; row = table.rows[i]; i++) {
         var check = document.getElementById(sel+i);
         if(check.checked) { selected.push(i); console.log("selected "+i); }
      }
      return selected;
    }

    $("#save_btn").click(function() {
      var selected = getSelected("save_");
      if(selected.length > 0) 
      {
        NProgress.start();
        $.ajax({ 
          url : 'export.php',
          type : 'POST',
          data : { keys : selected },
          success : function(data) {
            console.log(data);
            //data = JSON.parse(data);
            NProgress.done();
          },
          error: function (jqXHR, textStatus, errorThrown) { console.log("REQUEST FAILED"); }
        });
      }
      else  { alert("No documents selected!"); }
    });

    $("#sub_btn").click(function() {
      var selected = getSelected("sub_");
      if(selected.length > 0) {
        NProgress.start();
        $.ajax({
          url : 'subCloud.php',
          type : 'POST',
          data : { keys : selected },
          success : function(data) {
            data = JSON.parse(data);
            console.log(data);
            $("#sub_cloud").html(data);
            NProgress.done();
          },
          error : function (jqXHR, textStatus, errorThrown) { console.log("REQUEST FAILED"); }
        });
      }
      else { alert("No documents selected!"); }
    });

    </script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <!--<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>-->
  </body>
</html>
