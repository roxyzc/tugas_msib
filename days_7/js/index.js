const listAlarm = [];
let currentTime = null;
let alarmTimeout = null;

const setAlarm = (time) => {
  const inputTime = document.getElementById("alarmTime").value;
  const currentDateTime = new Date();
  const alarmDate = new Date(currentDateTime.toDateString() + " " + inputTime);

  if (inputTime) {
    if (alarmDate.getTime() < currentTime) {
      alert("Tolong masukkan alarm yang benar");
    } else {
      listAlarm.push(alarmDate.getTime());
    }
  } else {
    alert("Masukkan waktu yang benar");
  }
};

const convertToTime = (timestamp) => {
  const timeString = new Date(timestamp).toLocaleTimeString();
  return timeString;
};

const updateAlarm = () => {
  currentTime = new Date().getTime();
  const cTime = convertToTime(currentTime);
  document.getElementById("time").textContent = "Jam: " + cTime;
  for (const alarmTime of listAlarm) {
    if (currentTime >= alarmTime) {
      alert("alarm bunyi");
      const index = listAlarm.indexOf(alarmTime);
      if (index > -1) {
        listAlarm.splice(index, 1);
      }
    }
  }

  const list = listAlarm.map((alarm) => convertToTime(alarm)).join(", ");

  document.getElementById("list-alarm").textContent =
    "List Alarm: " + (list || "Belum ada alarm");
};

setInterval(updateAlarm, 1000);
