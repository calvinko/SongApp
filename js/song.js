
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

    var booklist = null;
    var booktbl = {};
    var books = {};
    var me = this;
    this.loadBookList = function() {
        let pm = new Promise(function(resolve, reject) {
            $.get("/song/api/books", function(retdata) {
                booklist = $.parseJSON(retdata);
                $.each(booklist, function(index, val) {
                    booktbl[val.bookid] = val;
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

    this.getBookTbl = function() {
        return booktbl;
    }

    this.getbooks = function() {
        let pm = new Promise(function(resolve, reject) {
            if (booklist == null) {
                $.get("/song/api/books", function(retdata) {
                    booklist = $.parseJSON(retdata);
                    $.each(ret, function(index, val) {
                        booktbl[val.bookid] = new SongBook(val.id, val)
                    });
                    resolve(booklist);
                }).fail(function() {
                    reject();
                });
            } else {
                resolve(booklist);
            }
        });
        return pm;
    }

    this.loadSongBook = function(bookid) {
        let p = new Promise(function (resolve, reject) {
            $.get("/song/api/book/" + bookid, function(retdata) {
                var ret = $.parseJSON(retdata);
                books[bookid] = new SongBook(bookid, booklist[bookid]);
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

function SongBook(id, val) {

    let songs = {};
    var myid = id;
    var value = val;
    this.id = id;
    this.name = val.name;
    this.attribute = val.attribute;

    this.getContent = function() {

    };

    this.loadData = function(ret) {
        $.each(ret, function(index, val) {
            songs[val.songnum] = val;
        });
    };

    this.getSongData = function(songnum) {
        return songs[songnum];
    };

    this.getData = function() {
        return songs;
    }

}