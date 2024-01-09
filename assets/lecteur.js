document.addEventListener("DOMContentLoaded", function () {
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
    console.log(audioplayer);
    const audio = audioplayer.find("audio");
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
      audio.play();
    }
  }
  setLecteurAudio(
    $(document).find(".audioplayer"),
    "data/audio/H2P/H2P Ep 1.wav",
    0,
    100,
    true,
    {
      NOM: "H2P Ep 1",
      AUTEURS: "H2P",
      DATE: "2019",
    }
  );
});
