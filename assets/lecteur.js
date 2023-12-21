/**
 * Fonction qui set le lecteur audio
 * 
 * @param {string} url L'url de la musique
 * @param {int} time Le temps de la musique
 * @param {int} volume Le volume de la musique
 * @param {boolean} play Si on veut jouer la musique
 */
function setLecteurAudio(url, time, volume = 100, play = true, data = null) {
    const audioplayer = $(document).find('.audioplayer');
    const audio = audioplayer.find('audio');
    const timetracker = audioplayer.find('.tracker #current-time');
    const tracker = audioplayer.find('.tracker input');
    const duration = audioplayer.find('.tracker #duration');
    audio.attr('src', url);
    audio[0].currentTime = time;
    audio[0].volume = volume / 100;
    timetracker.text(calculateTime(time));
    tracker.val(time);
  
    if (!data) return;
  
    audioplayer.find('.audiotitre').text(data.NOM);
    audioplayer.find('.info-topbar').text(data.AUTEURS);
    audioplayer.find('.topbar i').text(data.DATE);
  
    // si on veut jouer la musique
    if (play) {
      audio[0].play();
    }
}