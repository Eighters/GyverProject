
/**
 * Handle Access Role input "type" change on create access role form
 */

var accessRoleTypeInput = 'input[name="create_access_role[type]"]';
var companyBlock = $('#company_choice');
var projectBlock = $('#project_choice');

// Function
function handleAccessRoleTypeInputChange() {
    var accessRoleTypeValue =  $(accessRoleTypeInput + ':checked').val();
    var companyInputValue = $('#create_access_role_company').find(':selected');
    var projectInputValue = $('#create_access_role_project').find(':selected');

    if (accessRoleTypeValue === 'company') {
        companyBlock.removeClass('hide');
        projectBlock.addClass('hide');

        projectInputValue.text('Selectionner un projet');
    } else if (accessRoleTypeValue === 'project') {
        companyBlock.addClass('hide');
        projectBlock.removeClass('hide');

        companyInputValue.text('Selectionner une entreprise');
    }
}

// on Load
handleAccessRoleTypeInputChange();

// On Change
$(accessRoleTypeInput).change(handleAccessRoleTypeInputChange);
