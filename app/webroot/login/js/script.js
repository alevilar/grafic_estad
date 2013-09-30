


jQuery(function(){
    
        $('#camera_wrap_1').camera({
                thumbnails: false
        });
        
        
        $('#cancel-login').on('click', function() {
            $('#user-login-box').hide('fade');
            return false;
        });
        $('#link-login').on('click', function() {
            $('#user-login-box').show('fade');
            return false;
        });
        
        $('#logincontain').load(URL_LOGINFORM);
 });