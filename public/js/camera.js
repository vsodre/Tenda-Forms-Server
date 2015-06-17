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

function dataURLToBlob(dataURL) {
    var BASE64_MARKER = ';base64,';
    if (dataURL.indexOf(BASE64_MARKER) == -1) {
        var parts = dataURL.split(',');
        var contentType = parts[0].split(':')[1];
        var raw = decodeURIComponent(parts[1]);

        return new Blob([raw], {type: contentType});
    }

    var parts = dataURL.split(BASE64_MARKER);
    var contentType = parts[0].split(':')[1];
    var raw = window.atob(parts[1]);
    var rawLength = raw.length;

    var uInt8Array = new Uint8Array(rawLength);

    for (var i = 0; i < rawLength; ++i) {
        uInt8Array[i] = raw.charCodeAt(i);
    }

    return new Blob([uInt8Array], {type: contentType});
}

function printPhoto() {
    ctx.drawImage(video, 0, 0);
    video.play();
    return dataURLToBlob(canvas.toDataURL("image/png"));
}

function startCam(){
    video = document.querySelector('video');
    canvas = document.createElement('canvas');
    ctx = canvas.getContext('2d');
    video.src = window.URL.createObjectURL(localMediaStream);
}

navigator.webkitGetUserMedia(vgaConstraints, function(stream) {
    localMediaStream = stream;
}
, errorCallback);
