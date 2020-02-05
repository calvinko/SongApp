

var currentSongNum = 1;
var currentSongId = 1;
var currentSongName = "Song";

function SongApp() {
    var me = this;
    var booklist = {}
    var bookData = {}

    this.init = function(showListFunc) {
        me.loadBookList("all", showListFunc)
    }

    this.loadBookList = function(chname, showList) {
        $.post("getSongBook.php", {church: chname}, function(retdata) {
            var ret = $.parseJSON(retdata);
            $("#nav-songbook").empty();
            $.each(ret, function(index, val) {
                booklist[val.bookid] = [val.bookid, val.name];
            });
            showList(me);
        })
    }

    this.getBookList = function() {
        // bookid -> [id, bookname]
        return booklist;
    }

    this.getSongBook = function(bookid) {
        if (bookData[bookid] == undefined) {
            if (booklist[bookid]) {
                bookData[bookid] = SongBook(bookid, booklist[bookid][1])
                return bookData[bookid];
            } else {
                return null;
            }
        } else {
            return bookData[bookid];
        }
    }
}

function SongBook(bookid, bookname)
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
    var thisobj = this;


    this.loadindex = function() {
        $.post("getSongIndex.php", {bookid: this.bookid}, function(retdata) {
            var ret = $.parseJSON(retdata);
            me.songindex = [];
            me.songdata = ret.data;
            //$.each(me.songdata, function(index, val) {
            //    me.songindex.push([val.songnum, val.songid, val.songname]);
            //}
            $("#songindex").html("<h3>" + me.bookname + "</h3>");
            me.createSongIndex();
        });
    };

    this.createSongIndex = function() {
        $.each(me.songdata, function(index, val) {
            me.songindex[val.songnum] = [val.songid, val.songname];
            var elm = $("<a href='#'>" + val.songnum + ". " + val.songname + "</a>");
            thisobj.songindex.push([val.songid, val.songname]);
            elm.attr("songid", val.songid);

            elm.click(function() {
                $("#lyricsbox .lyrics").html("<div class='cimage'><img src='/images/uploading-big.gif'/></div>");
                me.loadsongtext(val.songid, val.songnum, val.songname);
                currentSongId = val.songid;
                $(".contentbox").hide();
                $("#lyricsbox").show();
            });
            $("#songindex").append($("<div class='boxentry'></div>").append(elm));
        });
    };

    this.showIndexMobile = function() {
        $.each(ret.data, function(index, val) {
            var elm = $("<a href='#'>" + val.songnum + ". " + val.songname + "</a>");
            me.songindex.push([val.songid, val.songname]);
            elm.attr("songid", val.songid);
            elm.click(function() {
                $("#lyricsbox .lyrics").html("<div class='cimage'><img src='/images/uploading-big.gif'/></div>");
                me.loadsongtext(val.songid, val.songnum, val.songname);
                currentSongId = val.songid;
                $(".contentbox").hide();
                $("#lyricsbox").show();
            });
            $("#songindex").append($("<div class='boxentry'></div>").append(elm));
        });
    };

    this.showIndex = function() {
        $.each(ret.data, function(index, val) {
            var elm = $("<a href='#'>" + val.songnum + ". " + val.songname + "</a>");
            me.songindex.push([val.songid, val.songname]);
            elm.attr("songid", val.songid);

            elm.click(function() {
                $("#lyricsbox .lyrics").html("<div class='cimage'><img src='/images/uploading-big.gif'/></div>");
                me.loadsongtext(val.songid, val.songnum, val.songname);
                currentSongId = val.songid;
                $(".contentbox").hide();
                $("#lyricsbox").show();
            });
            $("#songindex").append($("<div class='boxentry'></div>").append(elm));
        });
    };
    this.showsongtext = function(sid, songnum, songname) {
        $.post("getSongText.php", {songid: sid}, function(retdata) {
            var ret = $.parseJSON(retdata);
            $("#lyricsbox .bname").html(thisobj.bookname);
            $("#lyricsbox").attr("songid", sid);
            $("#lyricsbox .lyrics").html("<pre style='font-size: 24px'>" + songname + "\n\n" + ret.songtext + "</pre>");
            $("#lyricsbox pre").css('line-height', '28px');
        });
    }
    this.getsongtextfromid = function(sid) {

    }
    this.loadnext = function() {
        this.curindex = (this.curindex + 1) % this.songindex.length;
        var d = this.songindex[this.curindex];
        this.loadsongtext(d[0], 10, d[1])
    }
    this.loadprev = function() {
        if (this.curindex > 0) {
            this.curindex = this.curindex - 1;
            var d = this.songindex[this.curindex];
            this.loadsongtext(d[0], 10, d[1])
        }
    }
}

function setFontSize(s) {
    var lineHeight = s + 4;
    $("#lyricsbox pre").style("font-size", s);
    $("#lyricsbox pre").css('line-height', lineHeight + 'px');
}

function mloadsongbook() {
    $.post("getSongBook.php", {church: "Oakland"}, function(retdata) {
        var ret = $.parseJSON(retdata);
        $("#m-nav-songbook").empty();
        $.each(ret, function(index, val) {
            var elm = $("<a href='#'>" + val.name + "</a>");
            var bid = val.bookid;
            var attr = val.attribute;
            elm.attr("bookid", val.bookid);
            elm.click(function() {
                var bookid = $(this).attr("bookid");
                sbook = new SongBook(bookid, $(this).html());
                $("#songindex").html("<div class='cimage'><img src='/images/uploading-big.gif'/></div>");
                sbook.loadindex();
                $(".contentbox").hide();
                $("#songindex").show();
            });
            $("#m-nav-songbook").append($("<li class='boxentry'></li>").append(elm));
        });
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

function setcookie(title, value, exp) {
    var expdate = new Date();
    expdate.setDate(expdate.getDate() + exp);
    document.cookie = title+'='+value+';expires='+expdate.toGMTString()+';path=/SongApp/';
}