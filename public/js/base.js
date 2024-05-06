document.getElementById('menu-icon').addEventListener('click', function() {
    var dropdownContent = document.getElementById('dropdown');
    var htmlBody = document.querySelector('html');
    var body = document.querySelector('body');
    dropdownContent.classList.toggle('open');
    htmlBody.classList.toggle('no-scroll');
    body.classList.toggle('no-scroll');
});