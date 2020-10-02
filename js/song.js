
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
    var currBookId = 10;
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
                books[bookid] = new SongBook(bookid, booktbl[bookid]);
                books[bookid].loadData(ret);
                currBookId = bookid;
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

    this.getCurrentBook = function() {
        return this.getSongBook(currBookId);
    }
}

function SongBook(id, val) {

    let songs = {};
    let sdata = null;
    var myid = id;
    var value = val;
    var maxIndex = 1;
    var currentIndex = 1;
    this.id = id;
    this.name = val.name;
    this.attribute = val.attribute;

    this.getContent = function() {

    };

    this.loadData = function(ret) {
        sdata = ret;
        $.each(ret, function(index, val) {
            val.index = index;
            songs[val.songnum] = val;
            maxIndex = index;
        });
    };

    this.getNextSong = function() {
        if (currentIndex < maxIndex) {
            currentIndex = currentIndex + 1;
        }
        return sdata[currentIndex];
    }

    this.getPrevSong = function() {
        if (currentIndex > 0) {
            currentIndex = currentIndex - 1;
        }
        return sdata[currentIndex];
    }

    this.getSongData = function(songnum) {
        currentIndex = songs[songnum].index;
        return songs[songnum];
    };

    this.getData = function() {
        return songs;
    }


}