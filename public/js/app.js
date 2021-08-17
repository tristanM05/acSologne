/********************imgAlbum******************************/
let deleteImg = document.querySelectorAll('a.deleteImg');
for (let img of deleteImg) {
    img.addEventListener('click', function (e) {
        e.preventDefault();
        let yesNon = confirm('Confirmer la suppression');

        if (yesNon == true) {

            var albumId = this.getAttribute('data-album');
            var photoId = this.getAttribute('data-photo');
            var photo = this.previousElementSibling;
            var link = this;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    var data = JSON.parse(this.responseText);
                    if (data.done) {
                        photo.remove();
                        link.remove();
                    }

                }
            }
            xhttp.open('GET', `/admin/deleteImg/${albumId}/${photoId}`, true);
            xhttp.send();
        }
    })
}
/********************imgAlbum******************************/

/********************imgFormation******************************/
let deleteImgForm = document.querySelectorAll('a.deleteImgForm');
for (let img of deleteImgForm) {
    img.addEventListener('click', function (e) {
        e.preventDefault();
        let yesNon = confirm('Confirmer la suppression');

        if (yesNon == true) {

            var formationId = this.getAttribute('data-formation');
            var photoId = this.getAttribute('data-photo');
            var photo = this.previousElementSibling;
            var link = this;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    var data = JSON.parse(this.responseText);
                    if (data.done) {
                        photo.remove();
                        link.remove();
                    }

                }
            }
            xhttp.open('GET', `/admin/deleteImgForm/${formationId}/${photoId}`, true);
            xhttp.send();
        }
    })
}
/********************imgFormation******************************/

/********************imgactu******************************/
let deleteImgActu = document.querySelectorAll('a.deleteImgActu');
for (let img of deleteImgActu) {
    img.addEventListener('click', function (e) {
        e.preventDefault();
        let yesNon = confirm('Confirmer la suppression');

        if (yesNon == true) {

            var actuId = this.getAttribute('data-actu');
            var photoId = this.getAttribute('data-photo');
            var photo = this.previousElementSibling;
            var link = this;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    var data = JSON.parse(this.responseText);
                    if (data.done) {
                        photo.remove();
                        link.remove();
                    }

                }
            }
            xhttp.open('GET', `/admin/deleteImgActu/${actuId}/${photoId}`, true);
            xhttp.send();
        }
    })
}
/********************imgactu******************************/

/********************imgMachine******************************/
let deleteImgMachine = document.querySelectorAll('a.deleteImgMachine');
for (let img of deleteImgMachine) {
    img.addEventListener('click', function (e) {
        e.preventDefault();
        let yesNon = confirm('Confirmer la suppression');

        if (yesNon == true) {

            var machineId = this.getAttribute('data-machine');
            var photoId = this.getAttribute('data-photo');
            var photo = this.previousElementSibling;
            var link = this;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    var data = JSON.parse(this.responseText);
                    if (data.done) {
                        photo.remove();
                        link.remove();
                    }

                }
            }
            xhttp.open('GET', `/admin/deleteImgMachine/${machineId}/${photoId}`, true);
            xhttp.send();
        }
    })
}
/********************imgMachine******************************/

let deleteImgUser = document.querySelectorAll('a.deleteImgUser');
for (let img of deleteImgUser) {
    img.addEventListener('click', function (e) {
        e.preventDefault();
        let yesNon = confirm('Confirmer la suppression');

        if (yesNon == true) {

            var annonceId = this.getAttribute('data-annonce');
            var photoId = this.getAttribute('data-photo');
            var photo = this.previousElementSibling;
            var link = this;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    var data = JSON.parse(this.responseText);
                    if (data.done) {
                        photo.remove();
                        link.remove();
                    }

                }
            }
            xhttp.open('GET', `/admin/deleteImgUser/${annonceId}/${photoId}`, true);
            xhttp.send();
        }
    })


}

$(document).ready(function () {
    $('#user_vol_dates_0_date').datepicker({
        format: 'dd/mm/yyyy'
    });
});
// $('#user_vol_dates').html($('#user_vol_dates').attr('data-prototype'));
// console.log($('#user_vol_dates').attr('data-prorotype'));