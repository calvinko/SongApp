<?php

$mobile = false;
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
    $mobile = true;
    //header('Location: http://detectmobilebrowser.com/mobile');
}

if ($_GET['mobile']) {
    $mobile = true;
}
?>

<!DOCTYPE html>
<html>
    
<?php 
    if ($mobile) {
?>

    
<?php } else {    ?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
        
        <style>
            body {
                padding-top: 45px;
                padding-bottom: 30px;
            }
            
             .overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 10;
                background-color: rgba(0,0,0,0.2); /*dim the background*/
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
            
            .bcol {
                padding-top:16px;
            }
            
            #songindexpane {
                height: 760px;
                overflow: scroll;
                display:block;
            }
            
        </style>
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
        <script>
            var linksongid;
            function setcookie(title, value, exp) {
                var expdate = new Date();
                expdate.setDate(expdate.getDate() + exp);
                document.cookie = title+'='+value+';expires='+expdate.toGMTString()+';path=/SongApp/';
            }
            
            function loadsongpane2(songid) {
                $.post("getSongText.php", {songid: songid}, function(retdata) {
                    var ret = $.parseJSON(retdata);
                    $("#dt-pane2 .ncol").html("<h3>" + ret.songname + "</h3>");
                    
                    $("#dt-pane2 .songtext").html("<pre style='font-size: 22px; line-height:24px;'>" + ret.songtext + "</pre>");
                    $("#songindexpane").hide();
                    $("#dt-pane1").removeClass("col-md-8");
                    $("#dt-pane1").addClass("col-md-6");
                    $("#dt-pane2").show();
                });  
            }
            
            function copypane(p1, p2) {
                p2.find(".songtext").html(p1.find(".songtext pre").clone());
                p2.find(".ncol").html(p1.find(".ncol").clone());
            }
            
            function loadsong(songid, songname) {
                $("#loading-overlay").removeClass("hide");
                $.post("getSongText.php", {songid: songid}, function(retdata) {
                    var ret = $.parseJSON(retdata);
                    linksongid = ret.relsongid;
                    $("#desktopsongtext, #tabletsongtext").empty();
                    $("#dt-pane1 .ncol").html("<h3>" + songname + "</h3>");
                    if (ret.relsongid != "0") {
                        var but = $('<button class="btn btn-default">Rel. Song <i class="fa fa-bookmark"></i></button>');
                        but.click(function () {
                            loadsongpane2(ret.relsongid);
                        });
                        $("#dt-pane1 .bcol .linkgp").html(but);
                    } else {
                        $("#dt-pane1 .bcol .linkgp").empty();
                    }
                    $("#tabletsongtext").append("<h4>" + songname + "</h4><pre style='font-size: 26px; line-height:30px;'>" + ret.songtext + "</pre>");
                    $("#desktopsongtext").append("<pre style='font-size: 26px; line-height:30px;'>" + ret.songtext + "</pre>");
                    $("#loading-overlay").addClass("hide");
                    $("#tabletsongindex").hide();
                    $("#tabletsongtext").show('fast');
                })
            }

            function loadsonglist() {
                $.post("getSongBook", function(retdata) {
                    var sblist = $.parseJSON(retdata);
                    $.each(sblist), function(index, sbook) {
                        console.log(sbook.name);
                    }
                });
            }
            
            function loadsongindex(bookid, attribute) {
                $("#loading-overlay").removeClass("hide");
                $.post("getSongIndex.php", {bookid: bookid}, function(retdata) {
                    var ret = $.parseJSON(retdata);
                    $("#tabletsongindex").empty();
                    $("#desktopsongindex").empty();
                    $.each(ret.data, function(index, val) {
                        var elm = $("<a href='#'>" + val.songnum + ". " + val.songname + "</a>");
                        elm.attr("songid", val.songid);  
                        elm.click(function() {
                            loadsong($(this).attr('songid'), val.songname);
                            $("#nav-home").hide();
                            $("#nav-back").show();
                        });
                        
                        var pmark = "";
                        if (val.page != '0') {
                            pmark = $("<span style='float:right; height:32px'>p. " + val.page + "</span>")
                        }
                        var elm1;
                        if (attribute > 0) {
                            elm1 = $("<a href='#'>" + val.songnum + ". " + val.songname + "</a>");
                        } else {
                            elm1 = $("<a href='#'>" + val.songname + "</a>");
                        }
                        elm1.append(pmark);
                        elm1.attr("songid", val.songid); 
                        elm1.click(function() {
                            loadsong($(this).attr('songid'), val.songname);
                        });
                        $("#tabletsongindex").append($("<div class='songindexentry'></div>").append(elm));
                        $("#desktopsongindex").append($("<div class='songindexentry'></div>").append(elm1));
                        showsongindexpanel();
                    })
                    $("#loading-overlay").addClass("hide");
                })
            }
            
            function loadsongbook() {
                $.post("getSongBook.php", {church: "Oakland"}, function(retdata) {
                    var ret = $.parseJSON(retdata);
                    $("#nav-songbook").empty();
                    $.each(ret, function(index, val) {
                        var elm = $("<a href='#'>" + val.name + "</a>");
                        var bid = val.bookid;
                        var attr = val.attribute;
                        elm.attr("bookid", val.bookid);  
                        elm.click(function() {
                            $("#booktitle").text(val.name);
                            loadsongindex(bid, attr);
                            $("#tabletsongindex").show();
                            $("#tabletongtext").hide();
                        });
                        $("#nav-songbook").append($("<li></li>").append(elm));
                    });
                });
            }
            
            function changefontsize(pane, unit) {
                var fontSize = pane.find(".songtext pre").css('font-size').split('px')[0];
                
                var fontInt = parseInt(fontSize) + unit;
                var lineHeight = fontInt + 4;
                fontSize = fontInt + 'px';
                pane.find(".songtext pre").css('font-size', fontSize);
                pane.find(".songtext pre").css('line-height', lineHeight + 'px');
            }
            
            function showsongindexpanel() {
                 $("#songindexpane").show();
                 $("#dt-pane2").hide();
            }
            
            $(function() {
                $("#nav-songbook li a").click(function(ev) {
                    var t = $(this).text();
                    
                    $("#booktitle").text(t);
                    var bid = parseInt($(this).attr('bookid'));
                    //alert(bid);
                    loadsongindex(bid);
                    
                    $("#tabletsongindex").show();
                    $("#tabletongtext").hide();
                })
                $("#nav-back").click(function () {
                    
                    $("#tabletsongindex").show();
                    $("#tabletsongtext").hide();
                    $("#nav-back").hide();
                    $("#nav-home").show();
                })
                $("#nav-back").hide();
               
                 $("#btn-incfont1").click(function() {
                    changefontsize($("#dt-pane1"), 1);
                });
                
                $("#btn-decfont1").click(function() {
                    changefontsize($("#dt-pane1"), -1);
                });
                
                $("#btn-incfont2").click(function() {
                    changefontsize($("#dt-pane2"), 1);
                });
                
                $("#btn-decfont2").click(function() {
                    changefontsize($("#dt-pane2"), -1);
                });
                
                $("#btn-toggleindex").click(function() {
                    if ($("#songindexpane").is(":visible")) {
                        $("#songindexpane").toggle();
                    } else {
                        $("#songindexpane").toggle();
                        $("#dt-pane2").hide();
                    }
                    
                });
                
                $("#btn-copypane").click(function() {
                    copypane($("#dt-pane1"), $("#dt-pane2"));
                });
                
                $("#btn-togglepane").click(function() {
                    if ($("#dt-pane2").is(":visible")) {
                        $("#dt-pane2").hide();
                        $("#dt-pane1").addClass("col-md-8");
                        $("#dt-pane1").removeClass("col-md-6");
                    } else {
                        $("#songindexpane").hide();
                        $("#dt-pane1").removeClass("col-md-8");
                        $("#dt-pane1").addClass("col-md-6");
                        $("#dt-pane2").show();
                        
                    }
                    
                });
                loadsongbook(); 
                loadsongindex(31);
            })
        </script>
    </head>
    <body>
       
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <span class="navbar-brand">SongApp</span>
                </div>
                       
                        <ul class="nav navbar-nav">
                            <li id="nav-home"><a class="brand" href="./index.php"><i style="color:orangered" class="icon-home"></i></a></li>
                            <li id="nav-back"><a><i style='color:skyblue;' class="icon-hand-left"></i></a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <span id="booktitle">Oakland 詩歌 1</span>
                                    <i class="caret"></i>
                                </a>
                                <ul id="nav-songbook" class="dropdown-menu">
                                </ul>
                            </li>
                            
                            <li><a id ="btincfont"><i class="icon-font"></i><i class="icon-caret-up"></i></a></li>
                            <li><a id ="btdecfont"><i class="icon-font"></i><i class="icon-caret-down"></i></a></li>
                            <li><a class="ktooltip" data-toggle="tooltip" title="Index" onclick="setcookie('church','oakland',100)">Setting</a></li>
                            <li class=""><a class="ktooltip" data-toggle="tooltip" title="Song Books Management" href="songmgmt.php">Song Management</a></li>
                            
                        </ul>
                    
                
            </div>
        </div>
        <div id="phonebox" style="padding: 0px; margin-left: 0px; margin-right: 0px; position: relative" class="visible-sm">
            <div style="position: absolute" id="tabletsongindex">
                
            </div>
            <div style="position: absolute; width:100%" id="tabletsongtext">
                
            </div>
        </div>
        <div class="container visible-lg visible-md">
            <div style="max-width:1200px" class="row">
                <div style="padding-top:12px; padding-bottom: 5px" class="col-md-12">
                        
                    <div class="btn-group">
                        <button id="btn-toggleindex" class="btn btn-default"><i class="fa fa-caret-square-o-left"></i></button>
                        <button id="btn-togglepane" class="btn btn-default"><i class="fa fa-columns"></i></button>
                        <button id="btn-copypane" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
                        

                    </div>
                    
                   
                </div>
                <div id="songindexpane" style="height: 800px" class="col-md-4">
                    <div id="desktopsongindex"></div>
                </div>
                <div id="dt-pane1" class="col-md-8 panel panel-default">
                    <div class="">
                        <div class="ncol col-md-7"></div>
                        <div class="bcol col-md-5">
                            <div class="btn-group">
                                <button id="btn-incfont1" class="btn btn-default"><i class="fa fa-search-plus"></i></button>
                                <button id="btn-decfont1" class="btn btn-default"><i class="fa fa-search-minus"></i></button>
                            </div>
                            <div class="linkgp btn-group">
                                
                            </div>
                        </div>
                        
                    </div>
                    <div id="desktopsongtext" style="font-size: 26px; min-height:600px" class="songtext panel-body col-md-12">
                        
                    </div>
                </div>
                <div id="dt-pane2" style="display:none" class="col-md-6 panel panel-default">
                     <div class="">
                        <div class="ncol col-md-8"></div>
                        <div class="bcol col-md-4">
                            <div class="btn-group">
                                <button id="btn-incfont2" class="btn btn-default"><i class="fa fa-search-plus"></i></button>
                                <button id="btn-decfont2" class="btn btn-default"><i class="fa fa-search-minus"></i></button>
                            </div>
                        </div>
                    </div>
                    <div id="desktopsongtext2" class="songtext panel-body col-md-12" style="font-size: 20px; min-height: 600px">
                        
                    </div>
                </div>
            </div>
        </div>
            
        <div id="loading-overlay" style="text-align: center" class="hide overlay">    
            <div style="display:inline-block; margin: 220px auto">
                <div style="background-color: #000; padding: 2px 30px; border-radius: 5px;  font-size: 16px; color: white;">
                    Loading <img src="images/loading-b1.gif" height="50">
                </div>
                <br/>
                
            </div>
        </div>
    </body>
    
    
<?php } ?>
</html>
