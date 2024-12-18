
const items_menu = document.querySelectorAll('.selection>li');

items_menu.forEach(item => {
    item.addEventListener('click', function(event) {
        event.preventDefault();

        const link = this.querySelector('a');

        if (link) {
            window.location.href = link.href; 
        }
    });
});

function submitForm(folderId) {
    document.getElementById('form-folder-' + folderId).submit();
}