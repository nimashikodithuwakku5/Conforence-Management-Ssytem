// Initialize arrays to hold track data and participant counts
let tracks = [];
let participants = {};

// Maximum number of participants per track
const MAX_PARTICIPANTS = 500;

// Event listener for track form submission
document.getElementById('track-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const trackName = document.getElementById('track-name').value.trim();

    if (trackName && !tracks.includes(trackName)) {
        tracks.push(trackName);
        participants[trackName] = 0; // Initialize participant count for this track

        // Update the track list and the track selection dropdown
        updateTrackList();
        updateTrackSelect();
        document.getElementById('track-name').value = ''; // Clear the input
    } else {
        alert('Track name is either empty or already exists.');
    }
});

// Function to update the track list
function updateTrackList() {
    const trackList = document.getElementById('track-list');
    trackList.innerHTML = ''; // Clear the current list

    tracks.forEach(track => {
        const li = document.createElement('li');
        li.textContent = track;
        trackList.appendChild(li);
    });
}

// Function to update the track selection dropdown
function updateTrackSelect() {
    const trackSelect = document.getElementById('track-select');
    trackSelect.innerHTML = '<option value="">-- Select Track --</option>'; // Reset options

    tracks.forEach(track => {
        const option = document.createElement('option');
        option.value = track;
        option.textContent = track;
        trackSelect.appendChild(option);
    });
}

// Event listener for track selection change
document.getElementById('track-select').addEventListener('change', function() {
    const selectedTrack = this.value;
    const addParticipantBtn = document.getElementById('add-participant-btn');
    const participantsCountElement = document.getElementById('participants-count');

    if (selectedTrack) {
        // Enable Add Participant button and update the participant count
        addParticipantBtn.disabled = false;
        updateParticipantsCount(selectedTrack);
    } else {
        // Disable Add Participant button if no track is selected
        addParticipantBtn.disabled = true;
        participantsCountElement.textContent = '0 participants';
    }
});

// Function to update the participant count for a track
function updateParticipantsCount(track) {
    const participantsCountElement = document.getElementById('participants-count');
    participantsCountElement.textContent = `${participants[track]} participants`;
}

// Event listener for Add Participant button
document.getElementById('add-participant-btn').addEventListener('click', function() {
    const selectedTrack = document.getElementById('track-select').value;

    if (selectedTrack && participants[selectedTrack] < MAX_PARTICIPANTS) {
        participants[selectedTrack] += 1;
        updateParticipantsCount(selectedTrack);
    } else {
        alert(`Cannot add more participants to ${selectedTrack}. Maximum limit reached.`);
    }
});
