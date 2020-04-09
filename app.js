var songbooks;

$(document).ready(function () {
    $("#menu-mobile-control").click(function () {
        $(".main-box").toggleClass('open')
        $(".toolbar").toggle()
    });

    $("#column-control").click(function () {
        $(this).toggleClass('active')
        $(".main-box").toggleClass("column")
    })

    $("#menu-control").click(function () {
        $(this).toggleClass('active')
        $(".side-panel").toggle()
        $(".main-box").toggleClass('full-screen')
    })

    $("#add-control").click(function () {
        if ($(".main-box").hasClass("column") == false) {
            $(".main-box").addClass("column")
        }
        $(".right .content .text").html($(".left .content .text").html())
        $(".right .title .text").text($(".left .title .text").text())
        $(".right .skeleton").hide()
    })

    $("#zoom-in-control").click(function () {
        let font_size = $(".content").css("font-size");
        font_size = Number(font_size.replace(/px/, '')) + 4;
        $(".content").css("font-size", `${font_size}px`)
    })

    $("#zoom-out-control").click(function () {
        let font_size = $(".content").css("font-size");
        font_size = Number(font_size.replace(/px/, '')) - 4;
        $(".content").css("font-size", `${font_size}px`)
    })

    $("#rel-control").click(function () {
        if ($(this).hasClass("active") == false) {
            $(this).addClass("active")
            $(".right .skeleton").show()
            $('.right .text').empty();
            if ($("#column-control").hasClass('active') == false) {
                $("#column-control").addClass('active')
            }
            if ($(".main-box").hasClass('column') == false) {
                $(".main-box").addClass('column')
            }
            let rel_id = $(this).attr('data-rel')
            $.getJSON("get_song_text.php", {"songid": rel_id}, function (response) {
                $(".right .skeleton").hide()
                $('.right .title .text').append(response.songname);
                let text = response.songtext.replace(/\n/gm, "<br>");
                $('.right .content .text').append(text);
            })
        } else {
            $(this).removeClass("active")
            $("#column-control").removeClass('active')
            $(".main-box").removeClass("column")
            $('.right .text').empty();
        }
    })

    $('#prev-control').click(function () {
        let prev = $('.sub-menu li.active').prev('.item').children('a')
        let prev_id = $(prev).attr('data-id')
        window.console.log(prev, prev_id)
        if (prev_id != undefined) {
            updateContent(prev, prev_id)
        }
    })

    $('#next-control').click(function () {
        let next = $('.sub-menu li.active').next('.item').children('a')
        let next_id = $(next).attr('data-id')
        window.console.log(next, next_id)
        if (next_id != undefined) {
            updateContent(next, next_id)
        }
    })

    window.onhashchange = function() {
        var c = window.location.hash.substr(1).split("-");
        var fbid = 11;
        var fsid = 0;
        //console.log("on hash change ", c);
        if (c != "") {
            fbid = parseInt(c[0]);
            if (c[1] != undefined) {
                fsid = parseInt(c[1]);
                updateList(fbid).showSongTextDesktop(fsid);
            }
        }
    }

});

//get initial data
$.ajax({
    url: "get_book.php",
    context: document.body,
    data: {
        "church": "Oakland"
    },
    method: "GET",
    success: function (response) {
        let res = JSON.parse(response)
        window.console.log(res)
        $('.dropdown-toggle .text').text(res[18].name)
        $('.dropdown-menu .dropdown-item:first-child').remove()
        $.each(res, function (index, val) {
            // window.console.log(index, val)
            let item = `<a class="dropdown-item" data-id="${val.bookid}" href="javascript:;" onclick="updateList(this, ${val.bookid})">${val.name}</a>`
            $('.dropdown-menu').append(item)
        })
    }
})


var c = window.location.hash.substr(1).split("-");
var fbid = 31;
var fsid = 3101;
if (c != "") {
    fbid = parseInt(c[0]);
    if (c[1] != undefined) {
        fsid = parseInt(c[1]);
    }
}

$.ajax({
    url: "get_song_index.php",
    context: document.body,
    data: {
        "bookid": fbid
    },
    method: "GET",
    success: function (response) {
        let res = JSON.parse(response)
        window.console.log(res)
        $('.sub-menu .item-skeleton').hide()
        $.each(res.data, function (index, val) {
            let item = `<li class="item"><a data-id="${val.songid}" href="javascript:;" onclick="updateContent(this, ${val.songid})">${val.page}. ${val.songname}</a></li>`
            $('.sub-menu').append(item)
        })
        $('.sub-menu li.item:first').addClass('active')
    }
})

$.ajax({
    url: "get_song_text.php",
    context: document.body,
    data: {
        "songid": fsid
    },
    method: "GET",
    success: function (response) {
        let res = JSON.parse(response)
        // window.console.log(res)
        if (res.relsongid > 0) {
            $('#rel-control').attr('data-rel', res.relsongid)
        }
        $('.left .skeleton').hide()
        $('.left .title .text').append(res.songname)
        let text = res.songtext.replace(/\n/gm, "<br>")
        $('.left .content .text').append(text)
        $(".main-box").toggleClass('open')
        $(".toolbar").toggleClass('open')
	if ($(window).width() < 992) $(".toolbar").hide()
    }
})

function loadBookIndex(book_id) {
    if (!songBooks[book_id]) {
        $.getJSON("get_song_index.php", {"bookid": book_id}, function (response) {
            songBooks[book_id] = {};
            $.each(response.data, function (index, val) {
                songBooks[book_id][index] = {songnum: val.songnum, pagenum: val.pagenum, songid: val.songid};
            });
        })
    }

}

//functions
function updateList(_this, book_id) {
    $('.item-skeleton').show()
    $('.sub-menu li.item').remove()
    $.getJSON("get_song_index.php", {"bookid": book_id}, function (response) {
        $('.item-skeleton').hide()
        $('.dropdown-toggle .text').text($(_this).text())
        $.each(response.data, function (index, val) {
	        page_num = '';
	        if (book_id == 31 || book_id == 32 || book_id == 33 || book_id == 34 || book_id == 120){
	            page_num = val.page;
                if(page_num == "0")
                    page_num = val.songnum;
                page_num += "."
	        }
            let item = `<li class="item"><a data-id="${val.songid}" href="javascript:;" onclick="updateContent(this, ${val.songid})">${page_num} ${val.songname}</a></li>`
            $('.sub-menu').append(item)
        })
    })
}

function updateContentBN(_this, book_id, songindex) {
    $('.item-skeleton').show()
    $('.sub-menu li.item').remove()
    if (songBooks[book_id]) {
        $('.item-skeleton').hide()
        $('.dropdown-toggle .text').text($(_this).text())
        $.each(songBooks[book_id], function(index, val) {
            let item = `<li class="item"><a data-id="${val.songid}" href="javascript:;" onclick="updateContent(this, ${val.songid})">${val.pagenum} ${val.songname}</a></li>`
            $('.sub-menu').append(item);
            if (index == songindex) {
                updateContent(item.first().get(0), val.songid);
            }
        })
        updateContent(_this, songBooks[book_id][songindex].songid);
    } else {
        $.getJSON("get_song_index.php", {"bookid": book_id}, function (response) {
            songBooks[book_id] = {};
            $.each(response.data, function (index, val) {
                var page_num = '';
                if (book_id == 31 || book_id == 32 || book_id == 33 || book_id == 34 || book_id == 120){
                    page_num = val.page;
                    if(page_num == "0")
                        page_num = val.songnum;
                    page_num += "."
                }
                songBooks[book_id][index] = {songnum: val.songnum, pagenum: page_num, songid: val.songid, songname: val.songname};
                let item = `<li class="item"><a data-id="${val.songid}" href="javascript:;" onclick="updateContent(this, ${val.songid})">${page_num} ${val.songname}</a></li>`
                $('.sub-menu').append(item);
                if (index == songindex) {
                    updateContent(item.first().get(0), val.songid);
                }
            });
        })
    }
}

function updateContent(_this, song_id) {
    if ($('#rel-control').hasClass('active') == true) {
        $('#rel-control').removeClass('active')
        $('.main-box').removeClass('column')
    }
    $('.left .text').empty()
    // $('.right .text').empty()
    $('.left .skeleton').show()
    $(_this).parent().addClass('active')
    $(_this).parent().siblings().removeClass('active')
    $.getJSON("get_song_text.php", {"songid": song_id}, function (response) {
        // window.console.log(response.relsongid)
        $('.left .skeleton').hide()
        response.relsongid > 0 && $(window).width() > 992 ? $("#rel-control").show() : $("#rel-control").hide()
        $("#rel-control").attr('data-rel', response.relsongid)
        if (response.audio_path != ""){
            $("#audio_link").html(`<audio controls="controls">
                                <source src="${response.audio_path}">
                                </audio>`)
	   $("#audio_link").show()
        }  
        else {
          $("#audio_link").hide() 
        } 
	
	 $('.left .title .text').append(response.songname)
        let text = response.songtext.replace(/\n/gm, "<br>")
        $('.left .content .text').append(text)

        $(".main-box").toggleClass('open')
        $(".toolbar").show()
    })
}
