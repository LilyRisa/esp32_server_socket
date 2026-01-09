import AudioItem from "./AudioItem";

export default function AudioUploads() {
  return (
    <div className="col-lg-8 col-md-12 mb-3 mb-md-0">
      <div className="card glass-card">
        <div className="card-body">
          <div className="d-flex justify-content-between align-items-center mb-3">
            <h5 className="font-weight-bold m-0">
              <i className="fa-solid fa-music text-danger mr-2"></i>
              Audio Uploads
            </h5>

            <div>
              <button className="btn btn-glass-primary btn-sm mr-1">
                <i className="fa-solid fa-cloud-arrow-up"></i> Upload
              </button>
              <button className="btn btn-glass-secondary btn-sm">
                <i className="fa-solid fa-list-check"></i> QL File
              </button>
            </div>
          </div>

          <div className="list-group list-group-flush">
            <AudioItem
              icon="fa-music"
              iconBg="#ff5f57"
              title="Mua_Thang_Sau.mp3"
              meta="4.5 MB • 20/12/2023"
            />

            <AudioItem
              icon="fa-microphone-lines"
              iconBg="#5856d6"
              title="Meeting_Record.wav"
              meta="12 MB • Hôm nay"
            />

            <AudioItem
              icon="fa-spotify"
              iconBg="#34c759"
              title="Chill_Playlist_Online"
              meta="Stream • Live"
            />
          </div>
        </div>
      </div>
    </div>
  );
}