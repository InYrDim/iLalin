import Navigator from "./script/Navigator.js";

async function loadDriverPostion() {
  const driverNavigator = new Navigator();

  const getDriverPos = await driverNavigator.getNavigatorPosition();

  const { latitude, longitude, accuracy } = getDriverPos.coords;

  console.log(latitude, longitude, accuracy);
}

export default loadDriverPostion;

// console.log(location.getNavigatorPosition);
