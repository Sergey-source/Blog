$(document).ready(function() {
    $('.blocked').on('click', function() {
        alert('Это действие может сделать только авторизированный пользователь');
    });
});