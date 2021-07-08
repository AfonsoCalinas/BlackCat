function changeSignup() {
    console.log('aqui');
    var registar = document.getElementById('registar');
    var signup = document.getElementById('signup');
    var index_page = document.getElementById('index_page');
    var home = document.getElementById('home');
    var e = event.target;

    if (e == registar) {
        signup.hidden = false;
                console.log('registar');
    }
    if(e == home) {
        signup.hidden = true;
        index_page.hidden = false;
        console.log('index page');
    }


}