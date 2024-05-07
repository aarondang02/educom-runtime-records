document.getElementById('menu-icon').addEventListener('click', function() {
    var dropdownContent = document.getElementById('dropdown');
    var body = document.querySelector('body');
    dropdownContent.classList.toggle('open');
    body.classList.toggle('no-scroll');
});