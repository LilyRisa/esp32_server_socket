import { useEffect, useState } from "react";
import DeviceItem from "./DeviceItem";
import api from "../services/api";
import Loader from "./Loading";

export default function DevicePanel() {
  const [devices, setDevices] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    api.get("/device/list")
      .then(res => setDevices(res.data))
      .finally(() => setLoading(false));
  }, []);

  return (
    <div className="col-lg-8  col-md-12 my-2">
      <div className="card glass-card">
        <div className="card-body">
          <div className="d-flex justify-content-between align-items-center mb-4">
            <h5 className="font-weight-bold m-0">
              <i className="fa-solid fa-laptop-mobile text-primary mr-2"></i>
              Thiết bị
            </h5>
            <button className="btn btn-glass-secondary btn-sm">
              <i className="fa-solid fa-gear"></i> Quản lý
            </button>
          </div>

          <div className="row">
            {loading ? <Loader /> : devices.map(device => (
              <DeviceItem
                key={device.id}
                name={device.version_device}
                image={device.image}
                online={device.online}
              />
            ))}
          </div>
        </div>
      </div>
    </div>
  );
}