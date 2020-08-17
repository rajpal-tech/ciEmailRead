<!DOCTYPE html>

<html>

<head>
<title>Hello!</title>
<script>
function notify(){

if (Notification.permission !== "granted") {
Notification.requestPermission();
}
 else{
var notification = new Notification('hello', {
  body: "Hey there!",
});
notification.onclick = function () {
  window.open("http://google.com");
};
}
}
</script>
</head>

<body>
<button onclick="notify()">Notify</button>
</body>