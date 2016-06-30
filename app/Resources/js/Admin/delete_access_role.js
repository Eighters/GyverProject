
/**
 * Modal to confirm action when administrator want to delete a Access Role
 * @param id (ID of the Access Role admin want to delete)
 */
function confirmAdminDeleteAccessRole(id) {
    swal({
            title: "Voulez vous vraiment supprimer ce Rôle ?",
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
                AdminDeleteAccessRole(id)
            } else {
                swal("Suppression annulée", "", "error");
            }
        }
    )
}

/**
 * Modal to confirm administrator password to complete delete Access Role action
 * @param id (ID of the Access Role admin want to delete)
 */
function AdminDeleteAccessRole(id) {
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
                        url: "/secure/admin/role/" + id,
                        type: "DELETE"
                    });
                    swal("Supprimer !", "Le rôle a été supprimé avec succès", "success");
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

/**
 * Modal to confirm action when administrator want to remove an Access Role for a user
 * @param accessRoleId
 * @param userId
 */
function confirmRemoveAccessRoleForUSer(accessRoleId, userId) {
    swal({
            title: "Voulez vous vraiment supprimer ce Rôle ?",
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
                RemoveAccessRoleForUSer(accessRoleId, userId)
            } else {
                swal("Suppression annulée", "", "error");
            }
        }
    )
}

/**
 * Modal to confirm administrator password to complete remove Access Role for user action
 * @param accessRoleId
 * @param userId
 */
function RemoveAccessRoleForUSer(accessRoleId, userId) {
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
                            url: "/secure/admin/role/" + accessRoleId + "/user/" + userId,
                            type: "DELETE"
                        });
                        swal("Supprimer !", "Le rôle a été retiré à l'utilisateur avec succès", "success");
                        document.location.reload(true);
                    } else {
                        swal.showInputError("Mot de passe incorrect");
                    }
                },
                error: function() {
                    swal.showInputError("Mot de passe incorrect");
                }
            })
        }
    )
}
