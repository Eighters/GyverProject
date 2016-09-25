
/**
 * Handle input "global" change on project category form (activate|disable the select Company input)
 */

var globalInput = 'input[name="new_project_category[global]"]';
var selectInput = document.getElementById('new_project_category_company');

selectInput.setAttribute('disabled', 'disabled');

// Function
function handleGlobalInputChange() {
    var globalInputValue =  $(globalInput + ':checked').val();

    if (globalInputValue === 1) {
        selectInput.setAttribute('disabled', 'disabled');
    } else {
        selectInput.removeAttribute('disabled');
    }
}

// On Change
$(globalInput).change(handleGlobalInputChange);
