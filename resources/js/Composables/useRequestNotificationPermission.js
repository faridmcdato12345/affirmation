export function useRequestNotificationPermission(){
  const __requestPermission = () => {
    Notification.requestPermission().then((permission) => {
      if(permission == 'granted'){
        navigator.serviceWorker.ready.then((sw) => {
          sw.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: 'BNOxz8GQhgwx6sAJHnCeJa5XzlQjS3df2dmm33fyxfYqLg3DNkxi5q1Df1nHGOf2hG0vmaf-tzOdpg9S5kxprZg'
          }).then((subscription) => {
            fetch('/api/push-subscribe', {
              method: 'post',
              body: {
                data: JSON.stringify(subscription),
                user_id: localStorage.getItem('userId'),
                notifiable: 1
              }
            }).then(console.log('enabled permission'))
          })
        })
      }
    })
  }
  
  return { __requestPermission }

}