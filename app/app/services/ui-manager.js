app.service('ui_manager', function() {

  this.menubars = function(page) {

    let main_content = document.getElementById('main-content');
    let header_top = document.getElementById('header-top');
    let app_sidebar = document.getElementById('app-sidebar');
    let right_sidebar = document.getElementById('right-sidebar');
    let chat_panel = document.getElementById('chat-panel');

    if(page == 'auth') {

        main_content.style.margin = 0;
        main_content.style.padding = 0;
        header_top.style.display = 'none';
        app_sidebar.style.display = 'none';
        right_sidebar.style.display = 'none';
        chat_panel.style.display = 'none';

    }

    if(page == 'dashboard') {

        document.getElementById('header-top').style.display = 'block';
        app_sidebar.style.display = 'block';
        right_sidebar.style.display = 'block';
        chat_panel.style.display = 'block';
        
    }

    return true;

  }

});