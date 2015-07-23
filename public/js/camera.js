var localMediaStream = null;
var vgaConstraints = {
    video: {
        mandatory: {
            minWidth: 640,
            minHeight: 360
        }
    }
};

function errorCallback(e) {
    console.error(e);
}

function snapshot() {
    if (localMediaStream) {
        canvas.height = video.videoHeight;
        canvas.width = video.videoWidth;
        video.pause();
    }
}

function printPhoto() {
    ctx.drawImage(video, 0, 0);
    video.play();
    return dataURLToBlob(canvas.toDataURL("image/png"));
}

function startCam() {
    video = document.querySelector('video');
    canvas = document.createElement('canvas');
    ctx = canvas.getContext('2d');
    video.src = window.URL.createObjectURL(localMediaStream);
}

navigator.webkitGetUserMedia(vgaConstraints, function(stream) {
    localMediaStream = stream;
}, errorCallback);
