Kohana Facebook Class
===

This class will help you easily integrate Facebook php sdk into your kohana application. It is written for use with Facebook's JS API for actual login/logout.

This class only exists so that you can get Facebook user details for your users.

Javascript Setup
---

Here is some sample javascript to paste at the *bottom* of your html document you wish to use Facebook data on:

	<script>
		window.fbAsyncInit = function() {
			FB.init({
				appId   : '{{app_id}}',
				session : {{encoded_session}}, // don't refetch the session when PHP already has it
				status  : true, // check login status
				cookie  : true, // enable cookies to allow the server to access the session
				xfbml   : true // parse XFBML
		});

		// whenever the user logs in, we tell our login service
		FB.Event.subscribe('auth.login', function() {
		  window.location = "{{base}}users/fb_login"
		});
	  };

	  (function() {
		var e = document.createElement('script');
		e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
		e.async = true;
		document.getElementById('fb-root').appendChild(e);
	  }());
	</script>

You will need to pass {{app_id}}, and a json_encode()'d session variable to connect to Facebook. I use Mustache in this example, but you can use whatever you'd like.

The auth.login event will fire whenever someone logs into your site with a Facebook login button (<fb:login-button autologoutlink="true"></fb:login-button>) and will redirect to your Facebook specific login page.

Class Usage
---

 1. Kohana_Facebook::instance()->logged_in() - Tells you if the user is authenticated with facebook
 2. Kohana_Facebook::instance()->account()   - Gives you the raw user object provided by facebook_

This is a work in progress, so expect changes and feel free to contribute
---