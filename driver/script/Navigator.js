export default class Navigator {
  getNavigatorPosition() {
    return new Promise((resolve, reject) => {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          resolve(position); // Resolve the promise with the position data
        },
        (err) => {
          console.error(err); // Log the error
          reject(err); // Reject the promise with the error
        },
        { enableHighAccuracy: true }
      );
    });
  }
  getWatchedPosition(success, error) {
    let id;
    let options;

    options = {
      enableHighAccuracy: false,
      timeout: 300000, //5minutes
    };

    id = navigator.geolocation.watchPosition(success, error, options);

    return id;
  }
  clearWatchedPosition(watchId) {
    return () => {
      navigator.geolocation.clearWatch(watchId);
    };
  }
}
