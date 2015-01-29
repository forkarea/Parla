function search() {
    var city = $('#city').val();
    var country = $('#country').val();
    var age_from = $('#age_from').val();
    var age_to = $('#age_to').val();
    var gender = $('#gender').val();
    var orientation = $('#orientation').val();

    console.log('minAge='+minAge);
    console.log('maxAge='+maxAge);
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
    console.log('query='+query);
    var url = 'app.php?action=ajax_query&query='+encodeURIComponent(query
            )+'&args='+encodeURIComponent(JSON.stringify({city: city, country: country, age_from: age_from, age_to: age_to, gender: gender, orientation: orientation}));
    $.get(url, function(data) {
        console.log('data='+JSON.stringify(data));
        display(data);
    });
    console.log('url='+url);
}

function display(data) {
    $('#results').html('');
    for(var i in data) {
        $('#results').append('<a href="app.php?action=profile&user='+data[i].mykey+
                '"><div class="search_single_result"><img width="200" src="app.php?action=profile_image&user='
                +data[i].mykey+'"/><br/>'+data[i].name+'<br/>'+data[i].mykey+'</div></a>');
    }
}
