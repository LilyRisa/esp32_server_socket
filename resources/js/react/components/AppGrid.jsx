import AppItem from "./AppItem";

export default function AppGrid() {
  return (
    <div className="col-lg-4 col-md-12">
      <div className="card glass-card p-4">
        <h5 className="font-weight-bold mb-4">Ứng dụng</h5>

        <div className="app-grid">
          <AppItem
            icon="fa-waveform-lines"
            name="Mail"
            bg="linear-gradient(#5AC8FB, #007AFF)"
          />

          <AppItem
            icon="fa-address-book"
            name="Danh bạ"
            bg="linear-gradient(#A2A2A2, #7D7D7D)"
          />

          <AppItem
            icon="fa-calendar-days"
            name="Lịch"
            bg="white"
            color="#FF3B30"
          />

          <AppItem
            icon="fa-image"
            name="Ảnh"
            bg="white"
            color="#FFCC00"
          />

          <AppItem
            icon="fa-cloud"
            name="Drive"
            bg="linear-gradient(#5AC8FB, #007AFF)"
          />

          <AppItem
            icon="fa-note-sticky"
            name="Ghi chú"
            bg="#FFCC00"
          />

          <AppItem
            icon="fa-list-ul"
            name="Lời nhắc"
            bg="white"
            color="#5AC8FB"
          />

          <AppItem
            icon="fa-envelope-open-text"
            name="Lời mời"
            bg="#FF9500"
          />

          <AppItem
            icon="fa-pen-nib"
            name="Pages"
            bg="#FF9500"
          />

          <AppItem
            icon="fa-chart-bar"
            name="Numbers"
            bg="#34C759"
          />

          <AppItem
            icon="fa-desktop"
            name="Keynote"
            bg="#5AC8FB"
          />

          <AppItem
            icon="fa-location-crosshairs"
            name="Tìm"
            bg="#34C759"
          />
        </div>
      </div>
    </div>
  );
}