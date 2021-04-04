icon = 'http://127.0.0.1:8000/assets/img/fav.png';

// Register event listener for the 'push' event.
self.addEventListener('push', function(event) {
    const body = event.data ? event.data.text() : false;
    
    if(body !== false) {
      event.waitUntil(
        self.registration.showNotification('Fudplug', {body, icon})
      );
    }
  });