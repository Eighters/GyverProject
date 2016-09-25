
/**
 * Modal to confirm administrator password to complete delete project action
 * @param id (ID of the project admin want to delete)
 */
function AdminDeleteProject(id) {
    swal({
        title: 'Vous devez confirmer votre mot de passe',
        type: 'input',
        inputType: 'password',
        showCancelButton: true,
        closeOnConfirm: false,
        animation: 'slide-from-top',
        inputPlaceholder: 'Mot de passe',
        cancelButtonText: 'Annuler'
    },
    function(inputValue){
        $.ajax({
            url: '/secure/password/check',
            data: { password: inputValue },
            type: 'POST',
            cache: false,
            success: function(data) {
                if(data === 'true') {
                    $.ajax({
                        url: '/secure/admin/project/' + id,
                        type: 'DELETE'
                    });
                    swal('Supprimer !', 'Le projet a bien été supprimé', 'success');
                    document.location.reload(true);
                } else {
                    swal.showInputError('Mot de passe incorrect');
                }
            },
            error: function() {
                swal.showInputError('Mot de passe incorrect');
            }
        });
    });
}


/**
 * Modal to confirm action when administrator want to delete a project from the application
 * @param id (ID of the project admin want to delete)
 */
function confirmAdminDeleteProject(id) {
    swal({
        title: 'Voulez vous vraiment supprimer ce Projet ?',
        text: 'Aucun retour en arrière possible !',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Supprimer',
        cancelButtonText: 'Annuler',
        closeOnConfirm: false,
        closeOnCancel: false
    },
    function(isConfirm){
        if (isConfirm) {
            new AdminDeleteProject(id);
        } else {
            swal('Suppression annulée', '', 'error');
        }
    });
}
