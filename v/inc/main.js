// Register SW
if (navigator.serviceWorker) {
    // Register
    navigator.serviceWorker.register('/sw.js').then(registration => {
        // Listen for updates
        /*registration.onupdatefound = () => {
            let newSW = registration.installing;
            if (confirm('We have a new version! Do you want to update now? ')) {
                // Send message to SW
                newSW.postMessage('update_self');
            }
        };*/

        // Send message to SW when active
        if (registration.active) {
            registration.active.postMessage('respond to this');
        }
    }).catch(console.log);

    // Receive message from SW
    navigator.serviceWorker.addEventListener('message', e => {
        console.log(e.data);
    })

}

// Notifications
if (window.notification) {

    showNotification = () => {
        let notificationOptions = {
            body: 'Information',
            icon: '/v/inc/img/app.png'
        };
        new Notification('Title', );
    };

    if (Notification.permission === 'granted') {
        showNotification();
    } else if (Notification.permission !== 'denied') {
        Notification.requestPermission(permission => {
            if (permission === 'granted') {
                showNotification();
            }
        });
    }
}