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
        title: "Would you really like to remove this user ?",
        text: "No rollback possible !",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it !",
        cancelButtonText: "No, cancel please !",
        closeOnConfirm: false,
        closeOnCancel: false
    },
    function(isConfirm){
        if (isConfirm) {
            AdminDeleteUser(id)
        } else {
            swal("Cancelled", "", "error");
        }
    });
}

function AdminDeleteUser(id) {
    swal({
        title: "You need to confirm your password !",
        text: "Enter your admin password",
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
                swal("Deleted!", "Your account has been deleted!", "success");
                document.location.reload(true);
            } else {
                swal.showInputError("Your password is wrong!");
            }
        })
        .error(function(data) {
            swal.showInputError("Your password is wrong!");
        });
    });
}
