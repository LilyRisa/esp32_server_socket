import React from 'react';

const Loader = ({ message = "Đang tải...", showText = true }) => {
  return (
    <div className="esp_loader_overlay">
      <div className="esp_spinner_wrapper">
        {[...Array(12)].map((_, i) => (
          <div 
            key={i} 
            className="esp_spinner_dot" 
            style={{ '--i': i }}
          ></div>
        ))}
      </div>
      <p className="esp_loader_label">{message}</p>
    </div>
  );
};

export default Loader;