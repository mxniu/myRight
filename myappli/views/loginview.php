<body>
	<div id="fb-root"></div>
      <script>
        // Load the SDK Asynchronously
      (function(d){
         var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement('script'); js.id = id; js.async = true;
         js.src = "//connect.facebook.net/en_US/all.js";
         ref.parentNode.insertBefore(js, ref);
       }(document));

      // Init the SDK upon load
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '265179353583781', // App ID
          channelUrl : '//'+window.location.hostname+'/channel', // Path to your Channel File
          status     : true, // check login status
          cookie     : true, // enable cookies to allow the server to access the session
          xfbml      : true  // parse XFBML
        });

        // listen for and handle auth.statusChange events
        FB.Event.subscribe('auth.statusChange', function(response) {
          if (response.authResponse) {
            // user has auth'd your app and is logged into Facebook
            FB.api('/me', function(me){
              if (me.name) {
                document.getElementById('auth-displayname').innerHTML = me.name;
				
              }
            })
            document.getElementById('auth-loggedout').style.display = 'none';
            document.getElementById('auth-loggedin').style.display = 'block';
          } else {
            // user has not auth'd your app, or is not logged into Facebook
            document.getElementById('auth-loggedout').style.display = 'block';
            document.getElementById('auth-loggedin').style.display = 'none';
          }
        });

        // respond to clicks on the login and logout links
        document.getElementById('auth-loginlink').addEventListener('click', function(){
          FB.login();
        });
        document.getElementById('auth-logoutlink').addEventListener('click', function(){
          FB.logout();
        }); 
      } 
      </script>
    <div id="auth-status" style="margin: 80px auto; text-align: center;">
        <div id="auth-loggedout">
          <a href="#" id="auth-loginlink">Login</a>
        </div>
        <div id="auth-loggedin" style="display:none">
          Hi, <span id="auth-displayname"></span>. You are already logged in.  
        (<a href="#" id="auth-logoutlink">Logout</a>)
		<div><a href="http://www.myright.me">Go Back to Main Site</a></div>
		</div>
	</div>
	  <!--<div 
        class="fb-registration" 
        data-fields="[{'name':'name'}, {'name':'email'},
          {'name':'favorite_car','description':'What is your favorite car?',
            'type':'text'}]" 
        data-redirect-uri="http://myright.me"
      </div>-->
</body>