
/**
 * Modal to confirm action when administrator want to delete a user from the application
 * @param id (ID of the user admin want to delete)
 */
function confirmAdminDeleteUser(id) {
    swal({
            title: "Voulez vous vraiment supprimer cet utilisateur ?",
            text: "Aucun retour en arrière possible !",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Supprimer",
            cancelButtonText: "Annuler",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm){
            if (isConfirm) {
                AdminDeleteUser(id)
            } else {
                swal("Suppression annulée", "", "error");
            }
        }
    )
}

/**
 * Modal to confirm administrator password to complete delete user action
 * @param id (ID of the user admin want to delete)
 */
function AdminDeleteUser(id) {
    swal({
        title: "Vous devez confirmer votre mot de passe",
        type: "input",
        inputType: "password",
        showCancelButton: true,
        closeOnConfirm: false,
        animation: "slide-from-top",
        inputPlaceholder: "Mot de passe",
        cancelButtonText: "Annuler"
    },
    function(inputValue){
        $.ajax({
            url: "/secure/password/check",
            data: { password: inputValue },
            type: "POST",
            cache: false,
            success: function(data) {
                if(data == 'true') {
                    $.ajax({
                        url: "/secure/admin/user/" + id + "/delete",
                        type: "DELETE"
                    });
                    swal("Supprimer !", "L'utilisateur a bien été supprimé", "success");
                    document.location.reload(true);
                } else {
                    swal.showInputError("Mot de passe incorrect");
                }
            },
            error: function() {
                swal.showInputError("Mot de passe incorrect");
            }
        })
    })
}
