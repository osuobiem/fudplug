// Register event listener for the 'push' event.
self.addEventListener('push', function(e) {

  data = JSON.parse(e.data.text());

  e.waitUntil(
    self.registration.showNotification('Fudplug', {
      body: data.content,
      icon: data.icon,
      vibrate: [100, 50, 100],
      data: {
        url: data.url
      }
    })
  );
});

self.addEventListener('notificationclick', function(e) {
  var notification = e.notification;
  var url = notification.data.url;

  clients.openWindow(url);
  notification.close();
});