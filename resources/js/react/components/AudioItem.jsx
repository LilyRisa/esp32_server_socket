export default function AudioItem({
  icon = "fa-music",
  iconBg = "#ff5f57",
  title,
  meta,
}) {
  return (
    <div className="list-group-item-glass p-2">
      <div className="d-flex align-items-center w-100">
        {/* Icon */}
        <div
          className="icon-audio"
          style={{ backgroundColor: iconBg }}
        >
          <i className={`fa-solid ${icon}`}></i>
        </div>

        {/* Info */}
        <div className="flex-grow-1">
          <h6
            className="mb-0 font-weight-bold"
            style={{ fontSize: 14 }}
          >
            {title}
          </h6>
          <small className="text-muted">{meta}</small>
        </div>

        {/* Actions */}
        <button className="btn btn-sm text-primary">
          <i className="fa-solid fa-play"></i>
        </button>

        <button
          className="btn btn-sm text-danger ml-1"
          title="Xóa"
        >
          <i className="fa-solid fa-trash"></i>
        </button>
      </div>
    </div>
  );
}