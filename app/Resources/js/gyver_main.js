/**
 * gyver_main.js
 *
 * Here is the main file to write JavaScript for Application.
 * He is included in base template so you can access from everywhere
 */

/**
 * Menu
 */
$(document).ready(function(){

    /**
     * Initialize the sidebar nav
     */
    $('.button-collapse').sideNav({
        menuWidth: 270
    });

    /**
     * Initialize user dropdown in sidebar nav
     */
    $('.user-infos').dropdown({
            inDuration: 300,
            outDuration: 225,
            constrain_width: true,
            hover: false,
            gutter: 0,
            belowOrigin: true,
            alignment: 'right'
        }
    );
});
