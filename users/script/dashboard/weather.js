async function ilalin_weather(position) {
  const lat = position.coords.latitude;
  const lng = position.coords.longitude;

  const weatherapi_key = "7c6e227393564cd995315456242809";
  const weatherapi_url = `http://api.weatherapi.com/v1/current.json?key=${weatherapi_key}&q=${lat},${lng}`;
  console.log(weatherapi_url);

  const getWeatherData = await fetch(weatherapi_url);
  const response = await getWeatherData.json();

  console.log(response);

  const weather_temp = response.current.temp_c;
  const weather_code = response.current.condition.code;
  const weather_icon = response.current.condition.icon;
  const weather_name = response.current.condition.text;
  const weather_location_name = response.location.name;
  const is_daylight = response.current.is_day;
}
