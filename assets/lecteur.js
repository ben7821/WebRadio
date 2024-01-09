const paths = {
  play: "data/general/pause.png",
  pause: "data/general/play.png",
  mute: "data/general/mute.png",
  unmute: "data/general/unmute.png",
};

/**
 * Fonction pour convertir des secondes en minutes:secondes.
 *
 * @param {int} sec Le nombre de secondes à convertir.
 * @return {string} Le temps converti en format mm:ss
 */
const calculateTime = (sec) => {
  const minutes = Math.floor(sec / 60);
  const seconds = Math.floor(sec % 60);
  const returnedSeconds = seconds < 10 ? `0${seconds}` : `${seconds}`;
  return `${minutes}:${returnedSeconds}`;
};

/**
 * Fonction qui set le lecteur audio
 *
 * @param {string} url L'url de la musique
 * @param {int} time Le temps de la musique
 * @param {int} volume Le volume de la musique
 * @param {boolean} play Si on veut jouer la musique
 */
function setLecteurAudio(
  root,
  url,
  time,
  volume = 100,
  play = true,
  data = null
) {
  const audioplayer = root;
  const audio = audioplayer.find("audio");
  console.log(audio);
  const timetracker = audioplayer.find(".tracker #current-time");
  const tracker = audioplayer.find(".tracker input");
  const duration = audioplayer.find(".tracker #duration");
  audio.attr("src", url);
  audio[0].currentTime = time;
  audio[0].volume = volume / 100;
  timetracker.text(calculateTime(time));
  tracker.val(time);

  if (!data) return;

  audioplayer.find(".audiotitre").text(data.NOM);
  audioplayer.find(".info-topbar").text(data.AUTEURS);
  audioplayer.find(".topbar i").text(data.DATE);

  // si on veut jouer la musique
  if (play) {
    audio[0].play();
  }
}
setLecteurAudio(
  $(document).find(".audioplayer"),
  "data/audio/H2P/H2P Ep 1.wav",
  0,
  100,
  false,
  {
    NOM: "H2P Ep 1",
    AUTEURS: "H2P",
    DATE: "2019",
  }
);

//    const audioPlayer = $(".audioplayer")[0];

//   // function pour set le lecteur audio avec les infos du localstorage
//   window.onload = function () {
//     const WRGCLecteurResponse = JSON.parse(localStorage.getItem("WRGCLecteurInfo"));

//     // check si le localstorage existe
//     if (WRGCLecteurResponse && WRGCLecteurResponse.audioName != null && WRGCLecteurResponse.audioTime != null && WRGCLecteurResponse.audioPlaying != null) {
//         // set le lecteur audio avec les infos du localstorage
//         setLecteurAudio(WRGCLecteurResponse.audioName, WRGCLecteurResponse.audioTime, WRGCLecteurResponse.audioPlaying);

//         localStorage.removeItem("WRGCLecteurInfo");
//     }
// }

// // function pour get les infos du lecteur audio et les set dans le localstorage
// window.onbeforeunload = function () {
//     // var WRGCLecteurInfo = {
//     //     audioName: audioPlayer.src,
//     //     audioTime: audioPlayer.currentTime,
//     //     audioPlaying: !audioPlayer.paused
//     // }
//     // localStorage.setItem("WRGCLecteurInfo", JSON.stringify(WRGCLecteurInfo));
// }

// // function en cas de click sur un bouton
function setAudio(data) {
  setLecteurAudio(data.AUDIO, 0, 100, true, data);
  setButtonSrc("play");
  setButtonSrc("mute");
}

// Pour display le temps en cours
const displayDuration = (el, duration) => {
  $(el).closest(".topbar").find(".duration").text(calculateTime(duration));
};

$("audio").on("loadedmetadata", function () {
  // display la durée du son
  displayDuration(this, this.duration);
});

// Quand le son est en cours
$("audio").on("timeupdate", () => {
  const progressRatio = this.currentTime / this.duration;
  const progressPercent = Math.round(progressRatio * 100);
  // mettre a jour le slider en fonction du temps du son
  $(this).closest(".tracker").find(".progress-track").val(progressPercent);
  // display le temps en cours du son
  $(this)
    .closest(".tracker")
    .find(".current-time")
    .text(calculateTime(this.currentTime));
});

// Quand on change le temps avec le slider
$(".progress-track").on("input", (e) => {
  const progressRatio = e.target.value / 100;
  // set le temps sur le son en cours
  $(this).closest(".audioplayer").find(".audio-src")[0].currentTime =
    progressRatio *
    $(this).closest(".audioplayer").find(".audio-src")[0].duration;
});

// Quand on change le volume avec le slider
$(".volume-track").on("input", (e) => {
  const volumeRatio = e.target.value / 100;
  const volumeBtn = $(this).parent().find("#button-mute");
  // set le volume sur le son en cours
  $(this).closest(".audioplayer").find(".audio-src").volume = volumeRatio;
  // volume = e.target.value;
  // changer l'image du bouton si le volume est a 0
  if (volumeRatio === 0) {
    setButtonSrc(volumeBtn, "unmute");
  } else {
    setButtonSrc(volumeBtn, "mute");
  }
});

// function pour changer les images des boutons play et mute

function setButtonSrc(el, type) {
  switch (type) {
    case "play":
      el.children().attr("src", paths.play);
      break;
    case "pause":
      el.children().attr("src", paths.pause);
      break;
    case "mute":
      el.children().attr("src", paths.mute);
      break;
    case "unmute":
      el.children().attr("src", paths.unmute);
      break;
  }
}

// ----------------------
// audio est pas reconnu
// Uncaught TypeError: Cannot read properties of undefined (reading 'paused')
// at PlayEvent (H2P:522:21)
// at HTMLButtonElement.<anonymous> (H2P:511:9)
// at HTMLButtonElement.dispatch (jquery.min.js:2:43184)
// at y.handle (jquery.min.js:2:41168)
// ----------------------

$(".controls .play").on("click", function () {
  var audio = $(this).parent().parent().find(".audio-src")[0];
  PlayEvent(audio, $(this));
});

$("#button-mute").on("click", function () {
  var audio = $(this).parent().parent().find(".audio-src")[0];
  MuteEvent(audio, $(this));
});

// Quand on appui sur le bouton play
function PlayEvent(element, btn) {
  // check si le son est en pause
  if (element.paused) {
    // check si le son est deja chargé
    if (element.readyState > 0) {
      // play le son et change l'image du bouton
      element.play();
      setButtonSrc(btn, "play");
    } else {
      // sinon erreur et fait rien
      setButtonSrc(btn, "pause");
    }
  } else {
    // pause le son et change l'image du bouton
    element.pause();
    setButtonSrc(btn, "pause");
  }
}

// Quand on appui sur le bouton mute
function MuteEvent(element, btn) {
  var audio = $(element).parent().parent().find(".audio-src")[0];
  var volumeInput = $(element).parent().find(".volume-track");

  
  if (audio.volume === 0) {
    audio.volume = volumeInput.val() / 100;
    // changer l'image du bouton
    setButtonSrc(btn, "mute");
  } else {
    volumeInput.val(0);
    audio.volume = 0;
    // changer l'image du bouton
    setButtonSrc(btn, "unmute");
  }
}
