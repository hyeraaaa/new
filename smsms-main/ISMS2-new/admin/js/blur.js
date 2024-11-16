function applyBlurBackground() {
    const imageContainers = document.querySelectorAll('.image-container');

    imageContainers.forEach(container => {
        const img = container.querySelector('img');
        const blurBackground = container.querySelector('.blur-background');
        if (img && blurBackground) {
            blurBackground.style.backgroundImage = `url(${img.src})`;
        }
    });
}

document.addEventListener("DOMContentLoaded", applyBlurBackground);