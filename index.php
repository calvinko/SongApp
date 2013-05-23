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
            
            
            function loadsong(songid) {
                $.post("getSongText.php", {songid: songid}, function(retdata) {
                    var ret = $.parseJSON(retdata);
                    
                    $("#phonesongtext").empty();
                    $("#phonesongtext").append("<pre style='font-size: 14px'>" + ret.songtext + "</pre>");
                    $("#phonesongindex").hide();
                    //$("#phonesongtext").animate({left: '1px'});
                    $("#phonesongtext").show('fast');
                })
            }
            
            function loadsongindex(bookid) {
                $.post("getSongIndex.php", {bookid: bookid}, function(retdata) {
                    var ret = $.parseJSON(retdata);
                    $("#phonesongindex").empty();
                    $.each(ret.data, function(index, val) {
                        var elm = $("<a href='#'>" + val.songnum + ". " + val.songname + "</a>");
                        elm.attr("songid", val.songid);  
                        elm.click(function() {
                            loadsong($(this).attr('songid'));
                            $("#nav-home").hide();
                            $("#nav-back").show();
                        });
                        $("#phonesongindex").append($("<div class='songindexentry'></div>").append(elm));
                    })
                })
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
                    //$("#phonesongtext").css("left",'400px');
                })
                $("#nav-back").click(function () {
                    
                    $("#phonesongindex").show();
                    //$("#phonesongtext").animate({left: '400px'});
                    $("#phonesongtext").hide();
                    $("#nav-back").hide();
                    $("#nav-home").show();
                })
                $("#nav-back").hide();
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
                                    <span id="booktitle">神家詩歌 1</span>
                                    <i class="caret"></i>
                                </a>
                                <ul id="nav-songbook" class="dropdown-menu">
                                    <li><a bookid="31" href="#">Oakland 詩歌 1</a></li>
                                    <li><a bookid="32" href="#">Oakland 詩歌 2</a></li>
                                    <li><a bookid="33" href="#">Oakland 詩歌 3</a></li>
                                    <li><a href="#">神家詩歌 1</a></li>
                                    <li><a href="#">神家詩歌 2</a></li>
                                    <li><a href="#">神家詩歌 3</a></li>
                                    <li><a href="#">神家詩歌 4</a></li>
                                    <li><a href="#">神家詩歌 5</a></li>
                                    <li><a href="#">神家詩歌 6</a></li>
                                    <li><a href="#">神家詩歌 7</a></li>
                                    <li><a href="#">神家詩歌 8</a></li>
                                    <li><a href="#">神家詩歌 9</a></li>
                                    <li><a href="#">神家詩歌 10</a></li>
                                    <li><a href="#">神家詩歌 11</a></li>
                                     
                                </ul>
                            </li>
                            <li class="active"><a class="ktooltip" data-toggle="tooltip" title="Index" href="#">Index</a></li>
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
            <div class="row-fluid">
            <div class="span4">
                Index
            </div>
            <div class="span8">
                <div class="well"></div>
            </div>
            </div>
        </div>
            
    </body>
</html>
