export default function DeviceItem({ name, image, online }) {
  return (
    <div className="col-4">
      <div className={`device-item ${online ? "active" : ""}`}>
        <img
          src={image}
          alt={name}
          style={{ width: 48, height: 48, objectFit: "contain" }}
          className="mb-2"
        />

        <h6 className="font-weight-bold mb-0" style={{ fontSize: 13 }}>
          {name}
        </h6>

        <small className={`status-dot ${online ? "text-success" : "text-muted"}`}>
          ● {online ? "Online" : "Offline"}
        </small>
      </div>
    </div>
  );
}