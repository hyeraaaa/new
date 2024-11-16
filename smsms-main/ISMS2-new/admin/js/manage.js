document.addEventListener('DOMContentLoaded', function () {
    var deleteBtn = document.getElementById('confirm-delete-btn');
    var modal = document.getElementById('deletePost');

    modal.addEventListener('show.bs.modal', function (event) {
        var link = event.relatedTarget;
        var announcementId = link.getAttribute('data-announcement-id');
        
        deleteBtn.onclick = function () {
            window.location.href = 'manage_announcement.php?id=' + announcementId;
        };
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('deleted')) {
        var myModal = new bootstrap.Modal(document.getElementById('postDelete'));
        myModal.show();

        setTimeout(function() {
            myModal.hide(); 

            const newUrl = window.location.pathname;
            window.history.replaceState(null, '', newUrl);
        }, 2000);
    }
});