export default function AppItem({
  icon,
  name,
  bg,
  color = "white",
}) {
  return (
    <a href="#" className="app-item">
      <div
        className="app-icon"
        style={{
          background: bg,
          color: color,
        }}
      >
        <i className={`fa-solid ${icon}`}></i>
      </div>
      <span className="app-name">{name}</span>
    </a>
  );
}