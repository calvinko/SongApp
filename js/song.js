
function getSongTextType(stext) {
    var i;
    for (i=0; i<10; i++) {
        if (stext.charCodeAt(i) > 128) {
            return 10;
        }
    }
    return 1;
}

function SongStore() {

    var booklist = {};
    var books = {};
    var me = this;
    this.loadBookList = function() {
        let pm = new Promise(function(resolve, reject) {
            $.get("/song/api/books", function(retdata) {
                var ret = $.parseJSON(retdata);
                $.each(ret, function(index, val) {
                    booklist[val.bookid] = val;
                });
                resolve(me);
            }).fail(function() {
                reject(me);
            });
        });
        return pm;
    };
    this.getBookList = function() {
        return booklist;
    }

    this.loadSongBook = function(bookid) {
        let p = new Promise(function (resolve, reject) {
            $.get("/song/api/book/" + bookid, function(retdata) {
                var ret = $.parseJSON(retdata);
                books[bookid] = new SongBook(bookid, booklist[bookid].name);
                books[bookid].loadData(ret);
                resolve(books[bookid]);
            }).fail(function() {
                reject(me);
            });
        });
        return p;
    };

    this.getSongBook = function(bookid) {
        return books[bookid];
    }
}

function SongBook(id, name) {

    let songs = {};
    var myid = id;
    this.id = id;
    this.name = name;

    this.loadData = function(ret) {
        $.each(ret, function(index, val) {
            songs[val.songnum] = val;
        });
    }

    this.getSongData = function(songnum) {
        return songs[songnum];
    }

    this.getData = function() {
        return songs;
    }

}