/**
 * project_category.js
 *
 * Here is the main file to write JavaScript for Application.
 * He is included in base template so you can access from everywhere
 */


/**
 * Handle input "global" change on project category form (activate|disable the select Company input)
 */

var globalInput = 'input[name="new_project_category[global]"]';
var selectInput = document.getElementById('new_project_category_company');

selectInput.setAttribute("disabled", "disabled");

// On Change
$(globalInput).change(handleGlobalInputChange);

// Function
function handleGlobalInputChange() {
    var globalInputValue =  $(globalInput + ':checked').val();

    if (globalInputValue == 1) {
        selectInput.setAttribute("disabled", "disabled");
    } else {
        selectInput.removeAttribute("disabled");
    }
}
