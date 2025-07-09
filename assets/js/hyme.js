 // Éléments DOM
        const audio = document.getElementById('audioPlayer');
        const playPauseBtn = document.getElementById('playPauseBtn');
        const playIcon = document.getElementById('playIcon');
        const pauseIcon = document.getElementById('pauseIcon');
        const progressBar = document.getElementById('progressBar');
        const currentTimeEl = document.getElementById('currentTime');
        const durationEl = document.getElementById('duration');
        const volumeControl = document.getElementById('volumeControl');

        // Lecture/Pause
        playPauseBtn.addEventListener('click', () => {
            if (audio.paused) {
                audio.play();
                playIcon.classList.add('hidden');
                pauseIcon.classList.remove('hidden');
            } else {
                audio.pause();
                pauseIcon.classList.add('hidden');
                playIcon.classList.remove('hidden');
            }
        });

        // Barre de progression
        audio.addEventListener('timeupdate', () => {
            const progress = (audio.currentTime / audio.duration) * 100;
            progressBar.value = progress;
            currentTimeEl.textContent = formatTime(audio.currentTime);
        });

        progressBar.addEventListener('input', () => {
            const time = (progressBar.value * audio.duration) / 100;
            audio.currentTime = time;
        });

        // Volume
        volumeControl.addEventListener('input', () => {
            audio.volume = volumeControl.value / 100;
        });

        // Formatage du temps
        function formatTime(seconds) {
            const min = Math.floor(seconds / 60);
            const sec = Math.floor(seconds % 60);
            return `${min}:${sec < 10 ? '0' : ''}${sec}`;
        }

        // Initialisation de la durée
        audio.addEventListener('loadedmetadata', () => {
            durationEl.textContent = formatTime(audio.duration);
        });

        // Boutons suivants/précédents (exemple)
        // document.getElementById('nextBtn').addEventListener('click', () => {
        //     alert('Fonctionnalité suivante');
        // });

        // document.getElementById('prevBtn').addEventListener('click', () => {
        //     alert('Fonctionnalité précédente');
        // });