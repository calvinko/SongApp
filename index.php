<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <style>
            body {
                padding-top: 45px;
                padding-bottom: 30px;
            }
            
            .songindexentry {
                margin: 0px;
                
                border-top: 1px solid black;
               
                font-size: 120%;
                float: left;
                width: 98%;
                
            }
            .songindexentry a {
                color: black;
                height: 36px;
                padding: 4px 6px;
                display: block;
                line-height: 36px;
            }
            
            .songindexentry a:hover {
               
                background-color: lightblue;
                text-decoration: none;
            }
            
            #phonesongtext {
                display: none;
            }
            
        </style>
        <link href="css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="css/font-awesome.css" rel="stylesheet" media="screen">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
        <script src="js/bootstrap.min.js"></script>
        <script>
            
            
            function loadsong(songid, songname) {
                $.post("getSongText.php", {songid: songid}, function(retdata) {
                    var ret = $.parseJSON(retdata);
                    
                    $("#phonesongtext, #tabletsongtext").empty();
                    $("#phonesongtext").append("<h4>" + songname + "</h4><pre style='font-size: 14px'>" + ret.songtext + "</pre>");
                    $("#tabletsongtext").append("<h4>" + songname + "</h4><pre style='font-size: 18px'>" + ret.songtext + "</pre>");
                    $("#phonesongindex").hide();
                    //$("#phonesongtext").animate({left: '1px'});
                    $("#phonesongtext").show('fast');
                })
            }
            
            function loadsongindex(bookid) {
                $.post("getSongIndex.php", {bookid: bookid}, function(retdata) {
                    var ret = $.parseJSON(retdata);
                    $("#phonesongindex").empty();
                    $("#tabletsongindex").empty();
                    $.each(ret.data, function(index, val) {
                        var elm = $("<a href='#'>" + val.songnum + ". " + val.songname + "</a>");
                        elm.attr("songid", val.songid);  
                        elm.click(function() {
                            loadsong($(this).attr('songid'), val.songname);
                            $("#nav-home").hide();
                            $("#nav-back").show();
                        });
                        
                        var elm1 = $("<a href='#'>" + val.songnum + ". " + val.songname + "</a>");
                        elm1.attr("songid", val.songid); 
                        elm1.click(function() {
                            loadsong($(this).attr('songid'), val.songname);
                        });
                        $("#phonesongindex").append($("<div class='songindexentry'></div>").append(elm));
                        $("#tabletsongindex").append($("<div class='songindexentry'></div>").append(elm1));
                    })
                })
            }
            
            function loadsongbook() {
                $.post("getSongBook.php", {church: "Oakland"}, function(retdata) {
                    var ret = $.parseJSON(retdata);
                    $("#songbookindex").empty();
                    $.each(ret, function(index, val) {
                        var elm = $("<a href='#'>" + val.name + "</a>");
                        elm.attr("bookid", val.id);  
                        elm.click(function() {
                            alert("click");
                        });
                        $("#songbookindex").append($("<div class='songindexentry'></div>").append(elm));
                    });
                });
            
            }
            
            var songBookPhone = {
                bookid: 31,
                songnum: 1,
                loadindex: function() {
                    loadsongindex(this.bookid);
                }
            }
            
            
            $(function() {
                $("#nav-songbook li a").click(function(ev) {
                    var t = $(this).text();
                    
                    $("#booktitle").text(t);
                    var bid = parseInt($(this).attr('bookid'));
                    //alert(bid);
                    loadsongindex(bid);
                    
                    $("#phonesongindex").show();
                    $("#phonesongtext").hide();
                })
                $("#nav-back").click(function () {
                    
                    $("#phonesongindex").show();
                    //$("#phonesongtext").animate({left: '400px'});
                    $("#phonesongtext").hide();
                    $("#nav-back").hide();
                    $("#nav-home").show();
                })
                $("#nav-back").hide();
                loadsongbook(); 
                loadsongindex(31);
            })
        </script>
    </head>
    <body>
        
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                   
                    
                        <ul class="nav">
                            <li id="nav-home"><a class="brand" href="./index.php"><i style="color:orangered" class="icon-home"></i></a></li>
                            <li id="nav-back"><a><i style='color:skyblue;' class="icon-hand-left"></i></a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <span id="booktitle">Oakland 詩歌 1</span>
                                    <i class="caret"></i>
                                </a>
                                <ul id="nav-songbook" class="dropdown-menu">
                                    <li><a bookid="31" href="#">Oakland 詩歌 1</a></li>
                                    <li><a bookid="32" href="#">Oakland 詩歌 2</a></li>
                                    <li><a bookid="33" href="#">Oakland 詩歌 3</a></li>
                                    <li><a bookid="11" href="#">神家詩歌 1</a></li>
                                    <li><a bookid="12" href="#">神家詩歌 2</a></li>
                                    <li><a bookid="13" href="#">神家詩歌 3</a></li>
                                    <li><a bookid="14" href="#">神家詩歌 4</a></li>
                                    <li><a bookid="15" href="#">神家詩歌 5</a></li>
                                    <li><a bookid="16" href="#">神家詩歌 6</a></li>
                                    <li><a bookid="17" href="#">神家詩歌 7</a></li>
                                    <li><a bookid="18" href="#">神家詩歌 8</a></li>
                                    <li><a bookid="19"  href="#">神家詩歌 9</a></li>
                                    <li><a bookid="20" href="#">神家詩歌 10</a></li>
                                    <li><a bookid="21" href="#">神家詩歌 11</a></li>
                                     
                                </ul>
                            </li>
                            <li class="hidden-phone"><a class="ktooltip" data-toggle="tooltip" title="Index" href="#">Index</a></li>
                        </ul>
                    
                </div>
            </div>
        </div>
        <div id="phonebox" style="padding: 0px; margin-left: -20px; margin-right: -18px; position: relative" class="visible-phone">
            <div style="position: absolute" id="phonesongindex">
                
            </div>
            <div style="position: absolute; width:100%" id="phonesongtext">
                
            </div>
        </div>
        <div class="container-fluid hidden-phone">
            <div style="max-width:1100px" class="row-fluid">
                <div class="span4">
                    <div id="tabletsongindex"></div>
                </div>
                <div class="span8">
                    <div style="display: block; float: left; width: 100%">
                        <div class="btn-group">
                        <a id ="btincfont" class="btn btn-small"><i class="icon-font"></i><i class="icon-caret-up"></i></a>
                        <button id ="btdecfont" class="btn btn-small"><i class="icon-font"></i><i class="icon-caret-down"></i></button>
                        </div>
                    </div>
                    <div id="tabletsongtext"></div>
                </div>
            </div>
        </div>
            
    </body>
</html>
