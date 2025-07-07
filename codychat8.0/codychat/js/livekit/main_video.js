var liveRoom = null;
var localTracks = [];

closeCall = function(e) {
    liveRoom.disconnect();
    liveRoom = null;
    localTracks.forEach(function (track) {
        track.stop();
    });
    localTracks = [];
    $('#vcall_streams').html('');
	if(e == 99){
		 closeIframe();
	}
    window.location.href = 'call_end.php?end=' + e;
}

handleUserJoined = function(participant, track) {
    if (track.kind === 'video' || track.kind === 'audio') {
        let player = $(`#video-wrapper-${participant.identity}`);
        
        if (!player.length) {
            player = joinPlayer(participant.identity);
            $('#vcall_streams').append(player);
            handleUserName(participant.identity);
        }
        const mediaElement = track.attach();
        if (!$(`#stream-${participant.identity} ${mediaElement.tagName.toLowerCase()}`).length) {
            $(`#stream-${participant.identity}`).append(mediaElement);
        }
    }
}

switchCam = async function() {
    const currentVideoTrack = liveRoom.localParticipant.videoTracks[0].track;
    if (currentVideoTrack) {
        currentVideoTrack.stop();
        liveRoom.localParticipant.unpublishTrack(currentVideoTrack);
    }
    const isUsingFrontCamera = currentVideoTrack.mediaStreamTrack.getSettings().facingMode === "user";
    const newFacingMode = isUsingFrontCamera ? "environment" : "user";
    const newVideoTrack = await LivekitClient.createLocalVideoTrack({
        resolution: { width: 640, height: 480 },
        facingMode: newFacingMode
    });
    liveRoom.localParticipant.publishTrack(newVideoTrack);
    const localVideoElement = newVideoTrack.attach();
    $(`#stream-${appuser}`).empty().append(localVideoElement);
}

let joinStreams = async function() {
    try {
        let response = await $.post("system/action/action_call.php", { open_call: appcall });
        let result = JSON.parse(response);
        if (result.code !== 1 || !result.data) {
            console.error("Invalid response from server:", result);
            return;
        }

        let { appid, approom, apptoken, appurl } = result.data;

        const grantCam = await camPermission();
        const grantMic = await micPermission();

        liveRoom = new LivekitClient.Room({
            adaptiveStream: true,
            autoSubscribe: true,
        });

        await liveRoom.prepareConnection(appurl, apptoken);
        await liveRoom.connect(appurl, apptoken);

        liveRoom.remoteParticipants.forEach(participant => {
            participant.trackPublications.forEach(publication => {
                if (publication.track) {
                    handleUserJoined(participant, publication.track);
                }
            });

            participant.on(LivekitClient.ParticipantEvent.IsSpeakingChanged, (speaking) => {
                let volumeIcon = speaking ? 'volume-on.svg' : 'volume-off.svg';
                $(`#volume-${participant.identity}`).attr('src', `default_images/call/${volumeIcon}`);
            });
        });

        liveRoom.on(LivekitClient.RoomEvent.TrackSubscribed, (track, publication, participant) => {
            handleUserJoined(participant, track);
        });

        const tracks = await LivekitClient.createLocalTracks({
            audio: grantMic,
            video: grantCam ? {
				facingMode: "user"
            } : false
        });

        localTracks = tracks;
        let player = selfPlayer(appuser);
        $('#vcall_self').append(player).removeClass('vcallhide');

        if (grantCam) {
            const localVideoElement = tracks.find(track => track.kind === 'video').attach();
            $(`#stream-${appuser}`).append(localVideoElement);
        }

        if (!grantCam) {
            liveRoom.localParticipant.setMicrophoneEnabled(true);
            liveRoom.localParticipant.setCameraEnabled(false);
        } else {
            liveRoom.localParticipant.enableCameraAndMicrophone();
        }

        liveRoom.on(LivekitClient.RoomEvent.ActiveSpeakersChanged, (speakers) => {
            liveRoom.remoteParticipants.forEach(participant => {
                const isActiveSpeaker = speakers.some(speaker => speaker.identity === participant.identity);
                let volumeIcon = isActiveSpeaker ? 'volume-on.svg' : 'volume-off.svg';
                $(`#volume-${participant.identity}`).attr('src', `default_images/call/${volumeIcon}`);
            });
        });

        liveRoom.on('participantDisconnected', disconnectedParticipant => {
            handleUserLeft(disconnectedParticipant.identity);
        });

    } catch (error) {
        console.error('Error:', error);
        //closeCall(1);
    }
};

let selfPlayer = (id) => {
    return `<div class="vcall_container" id="video-wrapper-${id}">
                <div class="vcall_player player" id="stream-${id}">
				</div>
            </div>`;
}
let joinPlayer = (id) => {
	return `<div class="vcall_container" id="video-wrapper-${id}">
				<p class="vcall_user"><img class="vcall_vol" id="volume-${id}" src="default_images/call/volume-off.svg" /><span id="vcall_u${id}"></span></p>
				<div  class="vcall_player videosize player vcall_player_join" id="stream-${id}">
				</div>
			</div>`;
}


let startStream = async () => {
    await joinStreams();
}

let closeIframe = () => {
	window.parent.postMessage("endCall", window.location.origin);
}

let handleUserName = (id) => {
	$.post('system/action/action_call.php', {
		call_user: id,
		}, function(response) {
			if(response != 0){
				$('#vcall_u'+id).text(response);
			}
	});	
}

let handleUserLeft = (user) => {
    $(`#video-wrapper-${user}`).replaceWith("");
	closeCall(99);
}

let upgradeCall = () => {
	$.post('system/action/action_call.php', { 
			upgrade_call: appcall,
		}, function(response) {
			if(response != 0){
				closeCall(response);
			}
	});
}

$('#vcall_self').on('click', function() {
    if ($(this).hasClass('vcall_self')) {
        $(this).removeClass('vcall_self');
    } else {
        $(this).addClass('vcall_self');
    }
});

$('#vcall_mic').on('click', async () => {
    localTracks.forEach(function (track) {
        if (track.kind === 'audio') {
            if (track.isMuted) {
                track.unmute();
				liveRoom.localParticipant.setMicrophoneEnabled(true);
				$('#vcall_mic').removeClass('vcall_off');
            } 
			else {
                track.mute();
				liveRoom.localParticipant.setMicrophoneEnabled(false);
				$('#vcall_mic').addClass('vcall_off');
            }
        }
    });
})

$('#vcall_cam').on('click', async () => {
    localTracks.forEach(function (track) {
        if (track.kind === 'video') {
            if (track.isMuted) {
                track.unmute();
				liveRoom.localParticipant.setCameraEnabled(true);
				$('#vcall_cam').removeClass('vcall_off');
            } 
			else {
                track.mute();
				liveRoom.localParticipant.setCameraEnabled(false);
				$('#vcall_cam').addClass('vcall_off');
            }
        }
    });
})

$('#vcall_leave').on('click', async () => {
    await closeCall(99);
})

const camPermission = async () => {
    try {
		const devices = await navigator.mediaDevices.enumerateDevices();
		if (!devices.some(device => device.kind === 'videoinput')) return false;

		const stream = await navigator.mediaDevices.getUserMedia({ video: true });
		stream.getTracks().forEach(track => track.stop());
		return true;
    } 
	catch {
        return false;
    }
};
const micPermission = async () => {
    try {
        const devices = await navigator.mediaDevices.enumerateDevices();
        if (!devices.some(device => device.kind === 'audioinput')) return false;

        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
        stream.getTracks().forEach(track => track.stop());
        return true;
    } 
	catch {
        return false;
    }
};


$(document).ready(function(){
	
	$.ajaxSetup({
		data: { token: utk, cp: curPage }
	});
	
	startStream();
	callUpgrade = setInterval(upgradeCall, 10000);
	upgradeCall();
});