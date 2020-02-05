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
        <link href="css/songapp.css" rel="stylesheet" media="screen">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
        <script src="js/songbook.js" ></script>

    </head>
    <body>
        <script>
            var sapp = new SongApp();
            function showIndex(sa) {
                $.each(sa.getBookList(), function(bid, val) {
                    var elm = $("<a href='#'>" + val.name + "</a>");
                    elm.attr("bookid", bid);
                    elm.click(function() {
                        var sbook = sapp.getSongBook(bid);
                        sbook.loadindex();
                        $("#songindex").html("<div class='cimage'><img src='/images/uploading-big.gif'/></div>");
                        $(".contentbox").hide();
                        $("#songindex").show();
                    });
                    $("#m-nav-songbook").append($("<li class='boxentry'></li>").append(elm));
                });
            }


            $(function() {
                sapp.init(showIndex);
                $("#hymn ul li a").click(function(){
                    //var bookid = parseInt($(this).attr("bookid"));
                    var bookid = $(this).attr("bookid");
                    sbook = new SongBook(bookid, $(this).html());
                    $("#songindex").html("<div class='cimage'><img src='/images/uploading-big.gif'/></div>");
                    sbook.loadindex();
                    $(".contentbox").hide();
                    $("#songindex").show();
                })

                $(".atab").click(function() {
                    var tid = $(this).attr("tid");
                    $(".contentbox").hide();
                    $("#" + tid).show();
                })

                $("#bt-prev").click(function() {
                    sbook.loadprev();
                });

                $("#bt-next").click(function() {
                    sbook.loadnext();
                });

                $("#btincfont").click(function() {
                    var fontSize = $("#lyricsbox pre").css('font-size').split('px')[0];

                    var fontInt = parseInt(fontSize) + 1;
                    if (fontInt > 36) fontInt = 36;
                    var lineHeight = fontInt + 4;
                    fontSize = fontInt + 'px';
                    $("#lyricsbox pre").css('font-size', fontSize);
                    $("#lyricsbox pre").css('line-height', lineHeight + 'px');

                })

                 $("#btdecfont").click(function() {
                    var fontSize = $("#lyricsbox pre").css('font-size').split('px')[0];

                    var fontInt = parseInt(fontSize) - 1;
                    if (fontInt < 10) fontInt = 10;
                    var lineHeight = fontInt + 4;
                    fontSize = fontInt + 'px';
                    $("#lyricsbox pre").css('font-size', fontSize);
                    $("#lyricsbox pre").css('line-height', lineHeight + 'px');

                })
                mloadsongbook();
            });

      </script>

      <div class="ktabbar">
          <div style="width: 40px;" class="ktab"><a href=""><i style="padding-top:4px;" class="icon-home"></i></a></div>
          <div id="hymntab" tid="hymn" class="ktab atab">Library</div>
          <div id="songindextab" tid="songindex" class="ktab atab">Index</div>
          <div id="lyrictab" tid="lyricsbox" class="ktab atab">Lyrics</div>

      </div>
      <div id="hymn" class="contentbox">
          <ul id="m-nav-songbook"> style="margin: 0px">
          </ul>
      </div>
      <div id="songindex" style="display:none" class="contentbox">
          <h3>Song Index</h3>
      </div>
      <div id="lyricsbox" style="display:none" class="contentbox">
          <div class='stitle'>
              <div class='bname'>SongBook</div>
              <div class='btn-group fontctrl'>
                  <a id="bt-prev" class="btn"><i class="icon-arrow-left"></i></a>
                  <a style="margin-right: 5px;" id="bt-next" class="btn"><i class="icon-arrow-right"></i></a>
                  <a id ="btincfont" class="btn"><i class="icon-font"></i><i class="icon-caret-up"></i></a>
                  <a id ="btdecfont" class="btn"><i class="icon-font"></i><i class="icon-caret-down"></i></a>
              </div>
          </div>
          <div class="lyrics">
          </div>

      </div>
  </body>

