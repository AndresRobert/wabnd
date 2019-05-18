// Listen to message
self.addEventListener('message', e => {
    // Execute action for specific message
    if(e.data === 'update_self') {
        console.log('service worker updating');
        self.skipWaiting();
    }

    // Get clients (browser tabs)
    /*self.clients.matchAll().then(clients => {
        clients.forEach(client => {
            // Respond to all clients
            client.postMessage('hello from SW');
            // Respond to specific client
            if (e.source.id === client.id) {
                client.postMessage('I can see you ' + client.id);
            }
        });
    });*/

});

// Listen to push
self.addEventListener('push', () => {
    console.log('Push received');
});
