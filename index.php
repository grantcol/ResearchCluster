<!-- index.php -->
<?php session_start(); ?>
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
            <li role="presentation" class="active"><a href="#">Home</a></li>
            <li role="presentation"><a href="https://github.com/grantcol/ResearchCluster">About</a></li>
            <li role="presentation"><a href="history.php">History</a></li>
          </ul>
        </nav>
        <h3 class="text-muted">Research Team 8</h3>
      </div>

      <div class="jumbotron">
        <h3>Search Reasearch Papers</h3>
          <form class="form-inline">
            <div class="form-group">
              <label class="sr-only" for="searchField">Search</label>
              <input class="form-control" id="searchField" placeholder="Author, Keyword, Topic" onkeyup="autoCompleteQuery();">
              <ul id="ac_list">
                <!--li><a href="#" class="dropdown_link">Machine Learning</a></li>
                <li><a href="#" class="dropdown_link">Robot</a></li>
                <li><a href="#" class="dropdown_link">Web</a></li>-->
              </ul>
            </div>
            <div class="form-group">
              <select class="form-control" id="freqField">
                <option>5</option>
                <option>10</option>
                <option>15</option>
                <option>20</option>
                <option>25</option>
              </select>
            </div>
            <div class="form-group">
              <select class="form-control" id="typeField">
                <option>Topic</option>
                <option>Author</option>
                <option>Publication</option>
              </select>
            </div>
            <a href="#" id="search_btn" class="btn btn-primary">Search</a>
          </form>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div id="word_cloud"></div>
        </div>
      </div>
      <!--<div class="row marketing">
        <div class="col-lg-6">
          <h4>Subheading</h4>
          <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>

          <h4>Subheading</h4>
          <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>

          <h4>Subheading</h4>
          <p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
        </div>

        <div class="col-lg-6">
          <h4>Subheading</h4>
          <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>

          <h4>Subheading</h4>
          <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>

          <h4>Subheading</h4>
          <p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
        </div>
      </div>-->

      <footer class="footer">
        <p>&copy; CS310 Team 8, Spring 2015</p>
      </footer>

    </div> <!-- /container -->
    <script type="text/javascript" src="../js/jquery-1.11.2.min.js"></script>
    <script src='../js/nprogress.js'></script>
    <script type="text/javascript">
    $("#search_btn").click(function(){
      NProgress.start();
       var q = $("#searchField").val();
       var t = $("#typeField option:selected").text();
       var f = $("#freqField option:selected").text();
       console.log(q);
        $.ajax({ 
          url : 'php/request_local.php',
          type : 'POST',
          data : { query : q,  type : t, freq : f},
          success : function(data) {
            console.log(data);
            data = JSON.parse(data);
            console.log(data);
            $("#word_cloud").html(data);
            NProgress.done();
          },
          error: function (jqXHR, textStatus, errorThrown) { console.log("REQUEST FAILED"); }
        });
    });
    $(".dropdown_link").click(function(){
      var text = $(this).text();
      $("#searchField").val(text);
    });
    function autoCompleteQuery() {
      var minLen = 0;
      var hintStr = $("#searchField").val();
      if(hintStr.length > minLen) {
        $('#ac_list').show();
      }
      else {
        $('#ac_list').hide();
      }
    }
    </script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <!--<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>-->
  </body>
</html>
