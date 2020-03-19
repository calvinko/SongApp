

var currentSongNum = 1;
var currentSongId = 1;
var currentSongName = "Song";

function SongApp(displaytype) {
    var me = this;
    var booklist = {}
    var bookData = {}
    var displayType = displaytype;
    if (displayType == undefined) {
        displayType == "desktop"
    }

    this.currentBook = 0;
    this.init = function(showListFunc) {
        me.loadBookList("Oakland", showListFunc)
    }

    this.loadBookList = function(chname, callback) {
        $.post("getSongBook.php", {church: chname}, function(retdata) {
            var ret = $.parseJSON(retdata);
            $("#m-nav-songbook").empty();
            $("#nav-songbook").empty();
            $.each(ret, function(index, val) {
                booklist[val.bookid] = {bookid: val.bookid, name: val.name, attribute: val.attribute};
            });
            if (callback) {
                callback(me);
            }
        });
    }

    this.getBookList = function() {
        return booklist;
    }

    this.getSongBook = function(bookid, type) {

        if (bookData[bookid] == undefined) {
            if (booklist[bookid]) {
                bookData[bookid] = new SongBook(bookid, booklist[bookid].name, booklist[bookid].attribute, displaytype);
                me.currentBook = bookData[bookid]
                return bookData[bookid];
            } else {
                return null;
            }
        } else {
            me.currentBook = bookData[bookid];
            return bookData[bookid];
        }
    }
}

function SongBook(bookid, bookname, attribute, type)
{
    var me = this;
    this.bookname = bookname;
    this.bookid = bookid;
    this.songnum = 1;
    this.curpage = '1';
    this.songname = {};
    this.songtext = [];
    this.songindex = [];
    this.songdata = []
    this.curindex = 0;
    this.showSongNumber = 0;

    this.loadindex = function() {
        $.post("getSongIndex.php", {bookid: this.bookid}, function(retdata) {
            var ret = $.parseJSON(retdata);
            me.songindex = [];
            me.songdata = ret.data;
            $("#songindex").html("<h3>" + me.bookname + "</h3>");
            me.createSongIndex();
        });
    };

    var createSongIndexMobile = function() {
        $.each(me.songdata, function(index, val) {
            var elm = $("<a href='#'>" + val.songnum + ". " + val.songname + "</a>");
            elm.attr("songid", val.songid);
            elm.click(function() {
                $("#lyricsbox .lyrics").html("<div class='cimage'><img src='/images/uploading-big.gif'/></div>");
                me.showsongtext(val.songid, val.songnum, val.songname);
                me.curindex = index;
                $(".contentbox").hide();
                $("#lyricsbox").show();
            });
            $("#songindex").append($("<div class='songindexentry'></div>").append(elm));
            me.songindex[index] = [val.songid, val.songname, val.songnum];
        });
    };

    var createSongIndexDesktop = function() {
        $("#desktopsongindex").empty();
        $.each(me.songdata, function(index, val) {
            var pmark = "";
            if (val.page != '0' && attribute > 2) {
                pmark = $("<span style='float:right; height:32px'>p. " + val.page + "</span>")
            }
            var elm;
            if (attribute > 0) {
                elm = $("<a href='#'>" + val.songnum + ". " + val.songname + "</a>");
            } else {
                elm = $("<a href='#'>" + val.songname + "</a>");
            }
            elm.append(pmark);
            elm.attr("songid", val.songid);
            elm.click(function(ev) {
                me.showSongTextDesktop(val.songid, val.songnum, val.songname);
                window.location.hash = me.bookid + '-' + val.songid;
                ev.preventDefault();
            });
            $("#desktopsongindex").append($("<div class='songindexentry'></div>").append(elm));
            showsongindexpanel();
        });
    };

    this.createSongIndex = function() {
        if (type == "mobile") {
            return createSongIndexMobile();
        } else {
            return createSongIndexDesktop();
        }
    };

    var showSongIndexPanel = function() {
        $("#songindexpane").show();
        $("#dt-pane2").hide();
    }

    this.getSongTextType = function(stext) {
        var i;
        for (i=0; i<10; i++) {
            if (stext.charCodeAt(i) > 128) {
                return 10;
            }
        }
        return 1;
    }

    this.showsongtext = function(sid, songnum, songname) {
        $.post("getSongText.php", {songid: sid}, function(retdata) {
            var ret = $.parseJSON(retdata);
            $("#lyricsbox .bname").html(me.bookname);
            $("#lyricsbox").attr("songid", sid);
            if (me.getSongTextType(ret.songtext) > 1) {
                $("#lyricsbox .lyrics").html("<pre style='font-size: 24px; line-height: 28px'>" + ret.songname + "\n\n" + ret.songtext + "</pre>");
            } else {
                $("#lyricsbox .lyrics").html("<pre style='font-size: 18px; line-height: 20px'>" + ret.songname + "\n\n" + ret.songtext + "</pre>");
            }

        });
    }

    this.showSongTextDesktop = function(sid, songnum, songname) {
        $("#loading-overlay").removeClass("hide");
        $.post("getSongText.php", {songid: sid}, function(retdata) {
            var ret = $.parseJSON(retdata);
            linksongid = ret.relsongid;
            $("#desktopsongtext").empty();
            $("#dt-pane1 .ncol").html("<h3>" + ret.songname + "</h3>");
            if (ret.relsongid != "0") {
                var but = $('<button class="btn btn-default">Rel. Song <i class="fa fa-bookmark"></i></button>');
                but.click(function () {
                    loadsongpane2(ret.relsongid);
                });
                $("#dt-pane1 .bcol .linkgp").html(but);
            } else {
                $("#dt-pane1 .bcol .linkgp").empty();
            }
            if (me.getSongTextType(ret.songtext) > 1) {
                $("#desktopsongtext").append("<pre style='font-size: 26px; line-height:30px;'>" + ret.songtext + "</pre>");
                $("#lyricsbox .lyrics").html("<pre style='font-size: 24px; line-height: 28px'>" + ret.songname + "\n\n" + ret.songtext + "</pre>");
            } else {
                $("#desktopsongtext").append("<pre style='font-size: 18px; line-height:20px;'>" + ret.songtext + "</pre>");
                $("#lyricsbox .lyrics").html("<pre style='font-size: 18px; line-height: 20px'>" + ret.songname + "\n\n" + ret.songtext + "</pre>");
            }

            $("#loading-overlay").addClass("hide");

        })
    }

    this.getsongtextfromid = function(sid) {

    }
    this.loadnext = function() {
        me.curindex = (me.curindex + 1) % me.songindex.length;
        var d = me.songindex[me.curindex];
        me.showsongtext(d[0], d[2], d[1])
    }
    this.loadprev = function() {
        if (me.curindex > 0) {
            me.curindex = this.curindex - 1;
            var d = me.songindex[me.curindex];
            me.showsongtext(d[0], d[2], d[1])
        }
    }
}

function setFontSize(s) {
    var lineHeight = s + 4;
    $("#lyricsbox pre").style("font-size", s);
    $("#lyricsbox pre").css('line-height', lineHeight + 'px');
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

function setcookie(title, value, exp) {
    var expdate = new Date();
    expdate.setDate(expdate.getDate() + exp);
    document.cookie = title+'='+value+';expires='+expdate.toGMTString()+';path=/SongApp/';
}