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
        <style>
            .ktabbar {
                position: fixed;
                width: 100%;
                top: 0;
                right: 0;
                left: 0;
                z-index: 100;
            }
            
            .ktab {
                float: left;
                height: 32px;
                width:30%;
                border: 1px solid black;
                background-color: silver;
                font-size: 16px;
                line-height: 30px;
                text-align: center;
                
                text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
                vertical-align: middle;
                cursor: pointer;
                background-color: #f5f5f5;
                background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6);
                background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6));
                background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6);
                background-image: -o-linear-gradient(top, #ffffff, #e6e6e6);
                background-image: linear-gradient(to bottom, #ffffff, #e6e6e6);
                background-repeat: repeat-x;
                border: 1px solid #cccccc;
                border-color: #e6e6e6 #e6e6e6 #bfbfbf;
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
        </style>    
  </head>
  <body>
      <script>
          $(function() {
              
          })
      </script>
      <div class="ktabbar">
          <div style="width: 6%;" class="ktab"><a href=""><i style="padding-top:5px;"class="icon-home"></i></a></div>
          <div id="hymntab" class="ktab">Hyms</div>
          <div id="songindextab" class="ktab">Index</div>
          <div id="lyrictab" class="ktab">Lyrics</div>
          
      </div>
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

