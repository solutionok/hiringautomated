'use strict';

/* globals MediaRecorder */

const mediaSource = new MediaSource();
mediaSource.addEventListener('sourceopen', handleSourceOpen, false);
let mediaRecorder;
let recordedBlobs;
let sourceBuffer;

function handleSourceOpen(event) {
    console.log('MediaSource opened');
    sourceBuffer = mediaSource.addSourceBuffer('video/webm; codecs="vp8"');
    console.log('Source buffer: ', sourceBuffer);
}

function handleDataAvailable(event) {
    if (event.data && event.data.size > 0) {
        recordedBlobs.push(event.data);
    }
}

function stopRecording() {
    mediaRecorder.stop();
    console.log('Recorded Blobs: ', recordedBlobs);
}

function handleSuccess(stream) {
    console.log('getUserMedia() got stream:', stream);
    window.stream = stream;

    const gumVideo = document.querySelector('video#record-cam');
    gumVideo.srcObject = stream;
}

async function startRecord() {
    try{
        $('#record-trigger').hide();
        timeCount();
        clearInterval(preInterval);
    }catch(e){}
    
    const constraints = {
        audio:true, video:true
//        audio: {
//            echoCancellation: {exact: true}
//        },
//        video: {
//            //width: 1280, height: 720
//        }
    };

    try {
        const stream = await navigator.mediaDevices.getUserMedia(constraints);
        handleSuccess(stream);
    } catch (e) {
        console.log(e.toString())
        alert(e.toString());
    }

    recordedBlobs = [];
    let options = {mimeType: 'video/webm;codecs=vp9'};
    if (!MediaRecorder.isTypeSupported(options.mimeType)) {
        console.error(`${options.mimeType} is not Supported`);
        options = {mimeType: 'video/webm;codecs=vp8'};
        if (!MediaRecorder.isTypeSupported(options.mimeType)) {
            console.error(`${options.mimeType} is not Supported`);
            options = {mimeType: 'video/webm'};
            if (!MediaRecorder.isTypeSupported(options.mimeType)) {
                console.error(`${options.mimeType} is not Supported`);
                options = {mimeType: ''};
            }
        }
    }

    try {
        mediaRecorder = new MediaRecorder(window.stream, options);
    } catch (e) {
        console.error('Exception while creating MediaRecorder:', e);
        return;
    }

    console.log('Created MediaRecorder', mediaRecorder, 'with options', options);
    mediaRecorder.onstop = (event) => {
        console.log('Recorder stopped: ', event);
    };
    mediaRecorder.ondataavailable = handleDataAvailable;
    mediaRecorder.start(10); // collect 10ms of data

    console.log('MediaRecorder started', mediaRecorder);

}

function goNext() {
    showOveray("Video Saving in Process");
    stopAll();
    
    const blob = new Blob(recordedBlobs, {type: 'video/webm'});

    var formData = new FormData();
    formData.append('recordFile', blob);
    formData.append('_token', $('input[name="_token"').val());
    
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            hideOveray('Video saved');
            setTimeout(function () {
              location.reload();
            }, 2000);
        }
    };
    request.open('POST', '/home/runsave');
    request.send(formData);
}

function timeCount() {
    $('.prepare-time').hide();
    $('.rasp-time').show();

    var timeInterval = setInterval(function () {
        if (timeLimit <= 0) {
            goNext();
            clearInterval(timeInterval);
            return;
        }
        timeLimit--;

        $('.rasp-time input').val(tf(timeLimit));
    }, 1000)
}

function stopAll(){
    try{
        if(typeof(preInterval))clearInterval(preInterval);
        if(typeof(timeInterval))clearInterval(timeInterval);
        stopRecording();
        
        $('#record-trigger,#go-next,.timer').hide();
        
    }catch(e){}
}

$('#go-next').click(function () {
    goNext();
})

$('#record-trigger').click(function(){
    startRecord();
});

if (preparationTime > 0) {
    $('.prepare-time').show();
    $('.rasp-time').hide();
    var preInterval = setInterval(function () {
        if (preparationTime <= 0) {
            startRecord();
            return;
        }
        preparationTime--;

        $('.prepare-time input').val(tf(preparationTime));
    }, 1000)
}

//check webcam
navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
if (navigator.getUserMedia) {
    navigator.getUserMedia({video: true, audio: true}, function () {
        // Success
        // check if mic is provided
        navigator.mediaDevices.enumerateDevices().then(function (devices) {
            devices.forEach(function (device) {
                //if mic is plugged in
                if (((device.kind === 'audioinput') && (device.kind === 'videoinput')) || device.kind === 'audioinput') {
                    //check if mic has permission
                    //works only in Chrome
                    if ((device.label).length > 0) {
                        //go to chat room
                    }
                }
            });
        }).catch(function (err) {
            stopAll();
            alert(err.name + ": " + error.message);
        });
    },
    function () {
        // Failure
        stopAll();
        alert('Your camera or microphone not available!');
    });
}
;
