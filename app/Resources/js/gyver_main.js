// Here is the main file to write JavaScript for Application.
// He is included in base template so you can access from everywhere

console.log('fichier gyver main chargé');

function addInputField(name) {

    switch(name) {
        case "mail":
            $("#add_mail").before("<input type='text' name='mail[]' />");
            break;
        case "phone":
            $("#add_phone").before("<input type='text' name='phone[]' />");
            break;
    }
}

function confirmAdminDeleteUser(id) {
    swal({
        title: "Voulez vous vraiment supprimer cet utilisateur ?",
        text: "Aucun retour en arrière possible !",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Oui, supprimer!",
        cancelButtonText: "Non, annuler !",
        closeOnConfirm: false,
        closeOnCancel: false
    },
    function(isConfirm){
        if (isConfirm) {
            AdminDeleteUser(id)
        } else {
            swal("Action annulée", "", "error");
        }
    });
}

function AdminDeleteUser(id) {
    swal({
        title: "Vous devez confirmer votre mot de passe !",
        text: "Entrer le mot de passe administrateur",
        type: "input",
        inputType: "password",
        showCancelButton: true,
        closeOnConfirm: false,
        animation: "slide-from-top",
        inputPlaceholder: "P@ssword"
    },
    function(inputValue){
        $.ajax({
            url: "/secure/user/admin/password/check",
            data: { password: inputValue },
            type: "POST"
        })
        .success(function(data) {
            if(data == 'true') {
                $.ajax({
                    url: "/secure/user/" + id + "/delete",
                    type: "DELETE"
                });
                swal("Supprimer !", "L'utilisateur a bien été supprimé !", "success");
                document.location.reload(true);
            } else {
                swal.showInputError("Votre mot de passe est incorrect !");
            }
        })
        .error(function(data) {
            swal.showInputError("Votre mot de passe est incorrect !");
        });
    });
}
