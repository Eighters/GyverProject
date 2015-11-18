// Here is the main file to write JavaScript for Application.
// He is included in base template so you can access from everywhere

console.log('fichier gyver main chargé');

function addInputField(name){

    switch(name) {
        case "mail":
            $("#add_mail").before("<input type='text' name='mail[]' />");
            break;
        case "phone":
            $("#add_phone").before("<input type='text' name='phone[]' />");
            break;
    }
}
