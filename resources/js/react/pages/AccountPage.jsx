import React from "react";
import ProfileCard from "../components/ProfileCard";
import DevicePanel from "../components/DevicePanel";
import AudioUploads from "../components/AudioUploads";
import AppGrid from "../components/AppGrid";

export default function AccountPage() {
  return (
    <>
    <div id="app-content" className="container">
        <div className="row mb-4 ">
          <ProfileCard />
          <DevicePanel />
        </div>

        <div className="row">
          <AudioUploads />
          <AppGrid />
        </div>
      </div>
    </>
  );
}