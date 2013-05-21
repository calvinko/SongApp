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
            
        </style>
        <link href="css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="font-awesome.css" rel="stylesheet" media="screen">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
        <script src="js/bootstrap.min.js"></script>
        <script>
            
            
            function loadsong(songid) {
                $.post("getSongText.php", {songid: songid}, function(retdata) {
                    var ret = $.parseJSON(retdata);
                    
                    $("#phonesongtext").empty();
                    $("#phonesongtext").append("<pre style='font-size: 14px'>" + ret.songtext + "</pre>");
                    $("#phoneindex").hide();
                    $("#phonesongtext").animate({left: '1px'});
                    
                })
            }
            
            function loadsongindex(bookid) {
                $.post("getSongIndex.php", {bookid: bookid}, function(retdata) {
                    var ret = $.parseJSON(retdata);
                    $("#phoneindex").empty();
                    $.each(ret.data, function(index, val) {
                        var elm = $("<a href='#'>" + val.songnum + ". " + val.songname + "</a>");
                        elm.attr("songid", val.songid);  
                        elm.click(function() {
                            loadsong($(this).attr('songid'));
                        });
                        $("#phoneindex").append($("<div class='songindexentry'></div>").append(elm));
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
                    $("#phoneindex").show();
                    $("#phonesongtext").css("left",'400px');
                })
                loadsongindex(31);
            })
        </script>
    </head>
    <body>
        
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                   
                    
                        <ul class="nav">
                            <li id="nav-home"><a class="brand" href="./bible.php"><i style="color:orangered" class="icon-home"></i></a></li>
                            <li id="nav-back"><button style="padding-left:4px;" class="btn"><i class="icon-reply"></i>Back</button></li>
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
                                    1 愛是當 
                                </ul>
                            </li>
                            <li class="active"><a class="ktooltip" data-toggle="tooltip" title="Index" href="#">Index</a></li>
                        </ul>
                    
                </div>
            </div>
        </div>
        <div id="phonebox" style="padding: 0px; margin-left: -20px; margin-right: -18px; position: relative" class="visible-phone">
            <div style="position: absolute" id="phoneindex">
                
            </div>
            <div style="position: absolute; left:300px; width:100%" id="phonesongtext">
                
            </div>
        </div>
        <div class="hidden-phone">
            Desktop
        </div>
            
    </body>
</html>
