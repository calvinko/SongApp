
function SongStore() {

    var booklist = {};
    var booktbl = {};
    var me = this;
    this.loadBookList = function() {
        var pm = new Promise(function(resolve, reject) {
            $.get("api/books", function(retdata) {
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

    this.loadBookData =

    this.loadSongData = function(bookid, songnum, cb) {
        var p = new Promise(function (resolve, reject) {
            $
        });
    };

    this.getSongData = function(bookid, songnum) {

    }


}