$(document).ready(function () {
    $('.imgAlbum').click(function (e) {
        e.preventDefault();

    });
});
tinymce.init({
    selector: '#formation_content',
    height: 400,
    toolbar_mode: 'floating',
    language: 'fr_FR',
    toolbar: 'forecolor backcolor undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent'

})
