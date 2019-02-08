<?php

    require_once("authutil.php");
    $userid = 0;
    $instid = 1;
    $userprofile = array();
    $astatus = Authenticate::validateAuthCookie();
    if ($astatus) {
        $userid = Authenticate::getUserId();
        $userprofile = getUserProfile($userid);
    } else {
        //header("Location: login.php?dpage=songmgmt");
    }
    
?>   

<html>
    <head>    
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
        <link href="font-awesome-3.2.1/css/font-awesome.css" rel="stylesheet" media="screen">
       
       
        <style>
            
            body {
                padding-top: 55px;
                padding-bottom: 30px;
                background: url(/images/body-bg1.png);
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
                opacity: 0.8;
            }
            
            .songindexentry a:hover {
               
                
                opacity: 1;
                text-decoration: none;
            }
            
            .songindexentry a.selected {
                opacity: 0.8;
                background-color: lightcyan;
                
                
            }
            
            .active {
                background-color: lightgray;
            }
            
        </style>
        
        <script type="text/javascript">
            var userid = <?php echo $userid ?>;

            function loadsong(songid, songname) {
                $.post("getSongText.php", {songid: songid}, function(retdata) {
                    var ret = $.parseJSON(retdata);
                    $("#desktopsongtext").empty();
                    
                    $("#desktopsongtext").append("<h3>" + songname + "</h3><pre style='font-size: 22px; line-height:26px;'>" + ret.songtext + "</pre>");
                   
                })
            }

            function loadsongbook() {
                $.post("getSongBook.php", {church: "Oakland"}, function(retdata) {
                    var ret = $.parseJSON(retdata);
                    $("#nav-songbook").empty();
                    $.each(ret, function(index, val) {
                        var elm = $("<a href='#'>" + val.name + "</a>");
                        var bid = val.bookid;
                        elm.attr("bookid", val.bookid);  
                        elm.click(function() {
                            songBook.bookid = val.bookid;
                            songBook.currsongindex = -1;
                            songBook.loadindex();
                            //$("#tabletsongindex").show();
                            //$("#tabletongtext").hide();
                        });
                        $("#nav-songbook").append($("<li></li>").append(elm));
                    });
                });
            
            }
            
            var songBook = {
                bookid: 31,
                currsongindex: -1,
                currsongname: "",
                currsongrid: "0",
                currsongtext: "Loading ...",
                songdisplaymode: "view",
                songindexmode: "view",
                songlist: [],
                displayindex: function() {
                    var thisobj = this;
                    $("#desktopsongindex").empty();
                    $.each(this.songlist, function(index, val) {
                        var elm = $("<a class='pull-left1' href='#'>" + val.songnum + ". " + val.songname + "</a>");
                        var editelm = $("<button class='pull-right btn btn-default btn-xs'><i class='glyphicon glyphicon-trash'></i></button>");
                        elm.attr("songid", val.songid);
                        elm.attr("songindex", index);
                        elm.attr("songnum", val.songnum);
                        if (thisobj.currsongindex == index) {
                            elm.addClass("selected");
                        }
                        elm.click(function() {
                            $("#desktopsongindex a").removeClass("selected");
                            $(this).addClass("selected");
                            thisobj.currsongindex = parseInt($(this).attr("songindex"));
                            thisobj.loadsongtext();
                        });
                        $("#desktopsongindex").append($("<div class='songindexentry'></div>").append(elm));
                    })
                    
                },
                loadindex: function() {
                    
                    var obj = this;
                    $.post("/SongApp/getSongIndex.php", {bookid: this.bookid}, function(retdata) {
                        var ret = $.parseJSON(retdata);
                        obj.songlist = ret.data;
                        obj.displayindex();
                        obj.loadsongtext();
                    });
                },
                loadsongtext: function() {
                    var thisobj = this;
                    var songindex = thisobj.currsongindex;
                    if (songindex >= 0) {
                        var songid = thisobj.songlist[songindex].songid;
                        $.post("/SongApp/getSongText.php", {songid: songid}, function(retdata) {
                            var ret = $.parseJSON(retdata);
                            $("#songid").text(songid);
                            thisobj.currsongtext = ret.songtext;  
                            thisobj.currsongrid = ret.relsongid;
                            thisobj.displaySong();

                        });
                    } else {
                        $("#songtext").empty();
                    }
                },
                reload: function() {
                    var obj = this;
                    $.post("/SongApp/getSongIndex.php", {bookid: this.bookid}, function(retdata) {
                        var ret = $.parseJSON(retdata);
                        obj.songlist = ret.data;
                        obj.loadindex();
                    });    
                },
                displaySong: function() {
                    var thisobj = this;
                    if (this.currsongindex == -1) {
                        $("#songtext").empty();
                        return;
                    }
                    if (!this.songlist[this.currsongindex]) return;
                    var songname = this.songlist[this.currsongindex].songname;
                    var relsongid = this.songlist[this.currsongindex].relsongid;
                    var mode = this.songdisplaymode;
                    if (mode == "edit") {
                        var songid = this.songlist[this.currsongindex].songid;
                        $("#songtext").empty();
                        var input = $("<input name='songname' type='text' class='form-control'></input>");
                        input.val(songname);
                        var sbut = $("<button style='margin-right: 8px;' class='btn btn-primary'>Save</button>");
                        sbut.click(function () {
                            var text = $("#songtext textarea").val();
                            var sname = $("#songtext input[name='songname']").val();
                            var relsongid = $("#songtext input[name='relsongid']").val();
                            $.post("updateSong.php", {songid: songid, songname: sname, songtext: text, relsongid: relsongid}, function(retdata) {
                                thisobj.songdisplaymode = "read";
                                thisobj.reload();
                            });
                        })
                        var cbut = $("<button class='btn btn-default'>Cancel</button>");
                        cbut.click(function() {
                            thisobj.songdisplaymode = "read";
                            thisobj.displaySong();
                        })
                        
                        var linkinput = $("<span>relsongid: </span><input name='relsongid' type='text' size='10' class=''></input>");
                        linkinput.val(this.currsongrid);
                        $("#songtext").append(linkinput);
                        $("#songtext").append(input);
                        $("#songtext").append("<textarea style='height:500px' class='form-control' row='30' col='80'>" + this.currsongtext +"</textarea>")
                        $("#songtext").append(sbut).append(cbut);
                    } else {
                        $("#songtext").empty();
                        $("#songtext").append("<h3>" + songname + "</h3><pre style='font-size: 18px; line-height:26px;'>" + this.currsongtext + "</pre>");                   
                    }
                }
            }
            
            $(function() {
                if (userid != 0) {
                    $("#nav-setting, #nav-user").removeClass("hide");
                } else {
                    $("#nav-login, #nav-signup").removeClass("hide");
                }
                loadsongbook();
                songBook.reload();
                $("#nav-songbook li a").click(function(ev) {
                    var t = $(this).text();
                    
                    $("#booktitle").text(t);
                    var bid = parseInt($(this).attr('bookid'));
                    songBook.bookid = bid;
                    songBook.currsongindex = -1;
                    songBook.loadindex();
                })
                $("#editsongbtn").click(function() {
                    if (songBook.songdisplaymode != "edit") { 
                        songBook.songdisplaymode = "edit";
                        songBook.loadsongtext();
                    }
                });
                $("#delsongbtn").click(function() {
                    var songid = songBook.songlist[songBook.currsongindex].songid;
                    songBook.songdisplaymode = "read";
                    $.post("delSongFromBook.php", {bookid: songBook.bookid, songnum: songBook.currsongindex+1, songid: songid}, function(retdata) {
                        var retobj = $.parseJSON(retdata);
                        if (retobj.status == '1') {
                            songBook.reload();
                        } else {
                            $("#mdialog modal-body p").text(retobj.error);
                            $('#mdialog').modal()
                        }
                    });
                });
                $("#addsongbtn").click(function() {
                    if (songBook.bookid != 0) {
                        $.post("addSongToBook.php", {bookid: songBook.bookid}, function(retdata) {
                            var ret = $.parseJSON(retdata);
                            if (ret.status == '1') {
                                var snum = ret.songnum; 
                                $("#desktopsongindex").empty();
                                songBook.currsongindex = parseInt(snum) - 1;
                                songBook.songdisplaymode = "edit";
                                songBook.reload();
                            } else {
                                alert("User not allowed to edit Book");
                            }
                            
                        });
                    };
                });
                $("#upsongbtn").click(function() {
                
                    if (songBook.bookid != 0) {
                        var songid = songBook.songlist[songBook.currsongindex].songid;
                        $.post("moveSongInBook.php", {bookid: songBook.bookid, songnum: songBook.currsongindex+1, songid:songid, dir:"up"}, function(retdata) {
                            var ret = $.parseJSON(retdata);
                            songBook.currsongindex = parseInt(ret.snum) - 1;
                            songBook.songdisplaymode = 'view';
                            songBook.reload();
                        })
                    }
                
                });
                $("#downsongbtn").click(function() {
                    if (songBook.bookid != 0) {
                        var songid = songBook.songlist[songBook.currsongindex].songid;
                        $.post("moveSongInBook.php", {bookid: songBook.bookid, songnum: songBook.currsongindex+1, songid:songid, dir:"down"}, function(retdata) {
                            var ret = $.parseJSON(retdata);
                            songBook.currsongindex = parseInt(ret.snum) - 1;
                            songBook.songdisplaymode = 'view';
                            songBook.reload();
                        })
                    }
                
                });
                $(".ktooltip").tooltip({placement: "bottom"});
            })
             
        </script>
    </head>
    <body>
        
        <!-- Top Navigation Bar -->
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">

                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php"><i style="color:orangered" class="icon-star"></i>&nbsp; BibleCircle</a>
                    <ul class="nav navbar-nav">
                        <li class=""><a href="./index.php">Home</a></li>
                        <li class=""><a class="ktooltip" data-toggle="tooltip" title="Bible" href="./bible.php">Bible</a></li>
                        <li class="active"><a class="ktooltip" data-toggle="tooltip" title="Song Books Management" href="./songmgmt.php">Song Books</a></li>
                    </ul>
                </div>

                <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav pull-right">

                            <li id="nav-setting" class="dropdown hide">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-cog"></i>
                                    Settings
                                    <b class="caret"></b>
                                </a>

                                <ul class="dropdown-menu">
                                        <li class="disabled"><a href="#"><i id="track" class="icon-check"></i>&nbsp Track Reading</a></li>
                                        <li><a href="javascript:;"><i class="icon-list-alt"></i>&nbsp Account Settings</a></li>
                                        <li class="hide"><a href="javascript:;"><i class="icon-lock"></i>&nbsp Privacy Settings</a></li>
                                        <li class="divider"></li>
                                        <li><a href="javascript:;">Help</a></li>
                                </ul>

                            </li>

                            <li id="nav-user" class="dropdown hide">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <i class="icon-user"></i> 
                                            <?php echo $userprofile['firstname'] ?>
                                            <b class="caret"></b>
                                    </a>

                                    <ul class="dropdown-menu">
                                            <li><a href="javascript:;"><i class="icon-user"></i>&nbsp Profile</a></li>
                                            <li class="divider"></li>
                                            <li><a href="logout.php"><i class="icon-signout"></i>&nbsp Logout</a></li>
                                    </ul>

                            </li>

                            <li id="nav-login" class="hide"><a href="login.php" class="ktooltip" data-toggle="tooltip" title="Login or Sign up to track Reading">Login</a></li>
                    </ul> 

                </div>

            </div>

        </div>
        
        <!-- Main Content -->
        
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div style="padding: 3px 0px;" class="btn-toolbar">

                        <div class="btn-group pull-right" style="width:400px; padding-left:6px">
                            <div class="input-group">
                                <input style="float: left" type="text" size="6" class="form-control form-inline">
                                <div class="input-group-btn">
                                    <button class="btn btn-default">Search</button>
                                </div>
                            </div>    
                        </div>
                        
                        <div style="height: 32px; width: 100px;vertical-align: middle;line-height: 32px;" class="pull-right">
                                songid
                                <span id="songid" class="pull-right">---</span>                            
                        </div>
                        <div style="margin-right:15px; height: 32px; width: 100px;vertical-align: middle;line-height: 32px;" class="pull-right">
                                author
                                <span id="songauthor" class="pull-right">Ko</span>                            
                        </div>

                        <div class="btn-group pull-left">
                            <a style="display:none" class="btn btn-default" href="#">New Song Book</a>
                            <h4>Manage Song Book</h4>

                        </div>

                        <div class="btn-group"></div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div style="" class="panel panel-default">
                        <div style="padding:4px 6px" class="panel-heading">
                            <div class="btn-toolbar">
                                <div class="btn-group">
                                   
                                    <button style="" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        <span id="booktitle">Oakland 詩歌 1</span>&nbsp<span class="caret"></span>
                                    </button>


                                    <ul id="nav-songbook" class="dropdown-menu">
                                        <li><a bookid="31" href="#">Oakland 詩歌 1</a></li>
                                        <li><a bookid="32" href="#">Oakland 詩歌 2</a></li>
                                        <li><a bookid="33" href="#">Oakland 詩歌 3</a></li>
                                        <li><a bookid="34" href="#">Oakland 詩歌 4</a></li>
                                    </ul>
                                </div>
                                <div class="btn-group pull-right">
                                    <button style="height:30px; padding-top: 0px" id="delsongbtn" class="ktooltip btn btn-sm btn-default" title="Delete Song"><i class="glyphicon glyphicon-trash"></i></button>
                                    <button style="height:30px; padding-top: 0px" id="editsongbtn" class="ktooltip btn btn-sm btn-default" title="Edit Song"><i class="glyphicon glyphicon-edit"></i></button>
                                    <button style="height:30px; padding-top: 0px" id="upsongbtn" class="ktooltip btn btn-sm btn-default" title="Move Up - Not Done"><i class="glyphicon glyphicon-circle-arrow-up"></i></button>
                                    <button style="height:30px; padding-top: 0px" id="downsongbtn" class="ktooltip btn btn-sm btn-default" title="Move Down - Not Done"><i class="glyphicon glyphicon-circle-arrow-down"></i></button>
                                    <button style="height:30px; padding-top: 0px" id="addsongbtn" class="ktooltip btn btn-sm btn-default" title="Add Song to Book"><i class="glyphicon glyphicon-plus-sign"></i></button>
                                    
                                </div>
                                
                                <div class="btn-group pull-right">
                                    
                                </div>
                                
                            </div>
                        </div>
                        <div style="height:800px; overflow:scroll" class="panel-content">
                            <div id="desktopsongindex"></div>
                        </div>
                        
                    </div>
                    
                </div>
                <div class="col-md-8">
                    <div style="height:800px" class="well">
                        <div id="songtext"></div>
                    </div>
                </div>
            </div>
        </div>
        <div id="mdialog" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Error</h4>
              </div>
              <div class="modal-body">
                <p></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        
    </body>
        
</html>
