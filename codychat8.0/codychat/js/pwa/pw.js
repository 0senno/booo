let deferredPrompt;
$(window).on('beforeinstallprompt', function(event) {
  event.preventDefault();
  deferredPrompt = event.originalEvent;
  
  $('#app_install').on('click', function() {
    deferredPrompt.prompt();
    deferredPrompt.userChoice.then(function(choiceResult) {
      if (choiceResult.outcome === 'accepted') {
        console.log('acccepted');
      } 
	  else {
        console.log('declined');
      }
      deferredPrompt = null;
    });
  });
});