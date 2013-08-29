<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<html>
  <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="css/font-awesome.css" rel="stylesheet" media="screen">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
        <script src="jpanelmenu.min.js" ></script>
        <style>
            
            
            .ktabbar {
                position: fixed;
                width: 100%;
                top: 0;
                right: 0;
                left: 0;
                z-index: 1;
            }
            
            .ktab {
                float: left;
                height: 32px;
                width:28%;
                border: 1px solid black;
                background-color: silver;
                font-size: 16px;
                line-height: 30px;
                text-align: center;
                text-decoration: none;
                text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
                vertical-align: middle;
                cursor: pointer;
                
                background: repeat-x;
                border: 1px solid #cccccc;
                border-color: #e6e6e6 #e6e6e6 #bfbfbf;
            }
            
            .ktab a {
                text-decoration: none;
                display: block;
                
                background: repeat-x;
                background: -o-linear-gradient(top, #ffffff, #e0e0e0);
                background: -webkit-linear-gradient(top, #ffffff, #e0e0e0);
                background: linear-gradient(top, #ffffff, #e0e0e0);
                height: 100%;
                
            }
            
            .ktab a:hover {
                text-decoration: none;
                background: -o-linear-gradient(top, #e0e0e0, #ffffff);
                background: -webkit-linear-gradient(top, #e0e0e0, #ffffff);
                background: linear-gradient(top, #e0e0e0, #ffffff); 
            }
            
            .contentbox {
                position: relative;
                top: 30px;
                display: block;
                width:100%;
                overflow: auto;
                
                
                
            }
            
            .boxentry {
                margin: 0px;
                
                border-top: 1px solid black;
               
                font-size: 120%;
                float: left;
                width: 98%;
                
            }
            .boxentry a {
                color: black;
                height: 36px;
                padding: 4px 6px;
                display: block;
                line-height: 36px;
            }
            
            .boxentry a:hover {
               
                background-color: lightblue;
                text-decoration: none;
            }
            
            #jPanelMenu-menu {
                overflow: visible;
                background: #3b3b3b;
            }
            
            #jPanelMenu-menu li a {
                background: #3b3b3b;
                background: -o-linear-gradient(top, #3e3e3e, #383838);
                background: -ms-linear-gradient(top, #3e3e3e, #383838);
                background: -moz-linear-gradient(top, #3e3e3e, #383838);
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0, #3e3e3e), color-stop(1, #383838));
                background: -webkit-linear-gradient(#3e3e3e, #383838);
                background: linear-gradient(top, #3e3e3e, #383838);
                font-family: "museo-sans","Museo Sans","Helvetica Neue",Helvetica,Arial,sans-serif;
                font-weight: 300;
                font-weight: 700;
                display: block;
                padding: 0.5em 5%;
                border-top: 1px solid #484848;
                border-bottom: 1px solid #2e2e2e;
                text-decoration: none;
                text-shadow: 0 -1px 2px #222;
                color: #f7f7f7;
                height: 32px;
                line-height: 32px;
            }
            
            #jPanelMenu-menu li a:hover {
                background: -o-linear-gradient(top, #6e6e6e, #383838);
                background: -webkit-linear-gradient(top, #6e6e6e, #383838);
                background: linear-gradient(top, #6e6e6e, #383838);
            }
            
            
            
            nav ul, nav ol {
                list-style: none;
                list-style-image: none;
                margin: 0;
            }
            
            
        </style>    
  </head>
  <body>
      <script>
          $(function() {
              var jpm = $.jPanelMenu({openPosition: "200px", 
                  afterOpen: function() {$("#tabhead").css("left", "200px")},
                  afterClose: function() {$("#tabhead").css("left", "0px")}
              });
              jpm.on();
          })
      </script>
      
      <div id="tabhead" class="ktabbar">
          <div style="width: 8%;min-width:40px" class="ktab">
            <a href="#menu" class="menu-trigger"><i style="color: black; line-height:30px" class="icon-reorder"></i></a>
		
          </div>
          <div id="hymntab" class="ktab"><a href="#"> Hyms</a></div>
          <div id="songindextab" class="ktab"><a href="#"> Index</a></div>
          <div id="lyrictab" class="ktab"><a href="#"> Lyrics</a></div>
          
      </div>
      <nav id="menu" style="display:none">
			<ul>
				<li><a href="http://bachurch.org">Oakland Church</a></li>
                                <li><a href="index.php">Song Book</a></li>
                                <li><a href="notes.php">Notes</a></li>
				<li><a href="setting.php">Setting</a></li>
                                <li><a href="about.php">About</a></li>
			</ul>
    </nav>
      <div id="hymn" class="contentbox">
                <li class="boxentry"><a bookid="31" href="#">Oakland 詩歌 1</a></li>
                <li class="boxentry"><a bookid="32" href="#">Oakland 詩歌 2</a></li>
                <li class="boxentry"><a bookid="33" href="#">Oakland 詩歌 3</a></li>
                <li class="boxentry"><a bookid="11" href="#">神家詩歌 1</a></li>
                <li class="boxentry"><a bookid="12" href="#">神家詩歌 2</a></li>
                <li class="boxentry"><a bookid="13" href="#">神家詩歌 3</a></li>
                <li class="boxentry"><a bookid="14" href="#">神家詩歌 4</a></li>
                <li class="boxentry"><a bookid="15" href="#">神家詩歌 5</a></li>
                <li class="boxentry"><a bookid="16" href="#">神家詩歌 6</a></li>
                <li class="boxentry"><a bookid="17" href="#">神家詩歌 7</a></li>
                <li class="boxentry"><a bookid="18" href="#">神家詩歌 8</a></li>
                <li class="boxentry"><a bookid="19"  href="#">神家詩歌 9</a></li>
                <li class="boxentry"><a bookid="20" href="#">神家詩歌 10</a></li>
                <li class="boxentry"><a bookid="21" href="#">神家詩歌 11</a></li>
      </div>
      <div id="songindex" style="display:none" class="contentbox">
          
      </div>
      
      <div id="lyrics" style="display:none" class="contentbox">
          
      </div>
  </body>
</html>

