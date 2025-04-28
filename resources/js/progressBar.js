document.addEventListener('DOMContentLoaded', function() {
    const progressBar = document.querySelector('.progress-bar');
    let progressInterval;

    function updateProgress(progress) {
        progressBar.style.width = `${progress}%`;
    }

    function startProgress() {
        updateProgress(0);
        let progress = 0;
        progressInterval = setInterval(() => {
            progress += Math.random() * 30;
            if (progress > 90) {
                clearInterval(progressInterval);
                return;
            }
            updateProgress(progress);
        }, 500);
    }

    function completeProgress() {
        updateProgress(100);
        setTimeout(() => {
            updateProgress(0);
            if (progressInterval) clearInterval(progressInterval);
        }, 300);
    }

    document.addEventListener('turbo:before-visit', startProgress);
    document.addEventListener('turbo:load', completeProgress);

    // Pour les requêtes AJAX
    document.addEventListener('ajax:send', startProgress);
    document.addEventListener('ajax:complete', completeProgress);
});
