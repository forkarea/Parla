/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/

var pageNr = 0;
var pageMax = 5;
var onOnePage = 5;
var searchData = [];

function search() {
    var city = $('#city').val();
    var country = $('#country').val();
    var age_from = $('#age_from').val();
    var age_to = $('#age_to').val();
    var gender = $('#gender').val();
    var orientation = $('#orientation').val();

    if(age_from=='over') age_from = maxAge+1;
    if(age_to=='under') age_to = minAge-1;

    var query = 
            'SELECT name, mykey FROM users WHERE ';
    if(city!='') query += 'city=":city" AND ';
    if(country!='') query += 'country=":country" AND ';
    if(age_from!='under') query += 'TIMESTAMPDIFF(YEAR, birth, now())>=:age_from AND ';
    if(age_to!='over') query += 'TIMESTAMPDIFF(YEAR, birth, now())<=:age_to AND ';
    if(gender!='') query += 'gender=":gender" AND ';
    if(orientation!='') query += 'orientation=":orientation" AND ';
    query += '1 ORDER BY mykey';
    var url = 'app.php?action=ajax_query&query='+encodeURIComponent(query
            )+'&args='+encodeURIComponent(JSON.stringify({city: city, country: country, age_from: age_from, age_to: age_to, gender: gender, orientation: orientation}));
    $.get(url, function(data) {
        searchData = data;
        display();
    });
}

function display() {
    pageMax = Math.floor(searchData.length/onOnePage)+1;
    $('#totalPages').html('/'+pageMax);
    pageNr = 0;
    displayPage();
}

function displayPage(data) {
    $('#paginator').val(pageNr+1);
    $('#results').html('');
    for(var i=onOnePage*pageNr; i<onOnePage*(pageNr+1); i++) {
        if(i>=searchData.length) break;
        $('#results').append('<a href="app.php?action=profile&user='+searchData[i].mykey+
                '"><div class="search_single_result"><img width="200" src="app.php?action=profile_image&user='
                +searchData[i].mykey+'"/><br/>'+searchData[i].name+'<br/>'+searchData[i].mykey+'</div></a>');
    }
}

function page(nr) {
    var go = true;
    if(nr!=undefined) pageNr = nr;
    if(pageNr<0) {
        pageNr = 0;
        go = false;
    }
    if(pageNr>=pageMax) {
        pageNr = pageMax-1;
        go = false;
    }
    $('#paginator').val(pageNr+1);
    displayPage();
}

function prev() {
    pageNr--;
    page();
}

function next() {
    pageNr++;
    page();
}

$(document).ready( function() {
    $('#paginator').keypress(function(e) {
        if(e.which == 13) page($(this).val()-1);
    });
    $('#onOnePage').change(function(e) {
        onOnePage = $(this).val()*1;
        display();
    });
});
