import React, { useEffect, useState, useRef } from "react";
import {
  MapContainer,
  TileLayer,
  Marker,
  Popup,
  Polyline,
  useMap,
} from "react-leaflet";
import "leaflet/dist/leaflet.css";
import L from "leaflet";

// ================== TitleControl ==================
function TitleControl() {
  const map = useMap();

  useEffect(() => {
    const titleDiv = L.control({ position: "topright" });

    titleDiv.onAdd = () => {
      const div = L.DomUtil.create("div", "leaflet-bar");
      div.innerHTML = `
        <div style="
          background: rgba(255, 255, 255, 0.8);
          backdrop-filter: blur(6px);
          padding: 6px 14px;
          border-radius: 999px;
          font-weight: bold;
          font-size: 16px;
          color: #333;
          box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        ">
          🚗 ATLAS DIGITALIZE 
          <span style="color:#2563eb;">GPS Movement Tracking</span>
        </div>
      `;
      return div;
    };

    titleDiv.addTo(map);
    return () => {
      titleDiv.remove();
    };
  }, [map]);

  return null;
}

// ================== Custom Rotated Icon ==================
const getRotatedIcon = (angle) => {
  const offset = 0;
  return L.divIcon({
    html: `<img 
      src="/images/mobil4.png" 
      style="transform: rotate(${angle + offset}deg); 
      width:40px; height:40px; transform-origin: center center;" 
    />`,
    iconSize: [40, 40],
    iconAnchor: [20, 20],
    className: "",
  });
};

// ================== Key LocalStorage ==================
const getTodayKey = () => {
  const today = new Date().toISOString().split("T")[0];
  return `savedRoute_${today}`;
};

export default function MapComponent() {
  const [latestData, setLatestData] = useState(null);
  const [routeCoords, setRouteCoords] = useState([]);
  const [address, setAddress] = useState("");
  const [error, setError] = useState(""); // <=== state error
  const markerRef = useRef(null);

  // ================== Fetch GPS Data ==================
  const fetchData = async () => {
    try {
      const res = await fetch(import.meta.env.VITE_API_URL);
      if (!res.ok) throw new Error("Server tidak merespons");
  
      const result = await res.json();
      const gpsData = result.data; // ⬅️ ambil langsung array "data"
  
      if (gpsData && gpsData.length > 0) {
        setError("");
        const latest = gpsData[0]; // ambil titik terbaru
        setLatestData(latest);
  
        const newCoord = [
          parseFloat(latest.latitude),
          parseFloat(latest.longitude),
        ];
  
        setRouteCoords((prev) => {
          const updated = [...prev, newCoord];
          localStorage.setItem(getTodayKey(), JSON.stringify(updated));
          return updated;
        });
  
        fetchAddress(latest.latitude, latest.longitude);
      } else {
        setError("❌ Tidak ada data GPS ditemukan.");
      }
    } catch (err) {
      console.error("Gagal ambil data GPS:", err);
      setError("🚨 Tidak dapat terhubung ke server GPS.");
    }
  };

  // ================== Reverse Geocoding ==================
  const fetchAddress = async (lat, lon) => {
    try {
      const res = await fetch(
        `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json`
      );
      const data = await res.json();

      if (data.display_name) {
        setAddress(data.display_name);
      } else {
        setAddress("Alamat tidak ditemukan");
      }
    } catch (err) {
      console.error("Gagal ambil alamat:", err);
      setAddress("Gagal memuat alamat");
    }
  };

  // ================== Load Saved Route (Hari Ini) ==================
  useEffect(() => {
    const saved = localStorage.getItem(getTodayKey());
    if (saved) {
      setRouteCoords(JSON.parse(saved));
    }
  }, []);

  // ================== Auto Refresh Data ==================
  useEffect(() => {
    fetchData();
    const interval = setInterval(fetchData, 5000);
    return () => clearInterval(interval);
  }, []);

  // ================== Auto Open Popup ==================
  useEffect(() => {
    if (markerRef.current) {
      markerRef.current.openPopup();
    }
  }, [latestData]);

  return (
    <div style={{ position: "relative" }}>
      <MapContainer
        center={[-6.9919, 110.3674]}
        zoom={16}
        style={{ height: "100vh", width: "100%" }}
        attributionControl={false}
      >
        {/* Judul */}
        <TitleControl />

        {/* Peta */}
        <TileLayer url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png" />

        {/* Marker Terbaru */}
        {latestData && (
          <Marker
            ref={markerRef}
            position={[
              parseFloat(latestData.latitude),
              parseFloat(latestData.longitude),
            ]}
            icon={getRotatedIcon(latestData.course)}
          >
            <Popup>
              <div>
                <b>Device ID:</b> {latestData.device_id} <br />
                <b>LatLng:</b> {latestData.latitude}, {latestData.longitude}{" "}
                <br />
                <b>Arah:</b> {latestData.direction} ({latestData.course}°) <br />
                <b>Kecepatan:</b>{" "}
                {parseFloat(latestData.speed).toFixed(2)} km/h <br />
                <b>Waktu:</b>{" "}
                {new Date(latestData.devices_timestamp).toLocaleString()} <br />
                <b>Alamat:</b> {address}
              </div>
            </Popup>
          </Marker>
        )}

        {/* Polyline Rute */}
        {routeCoords.length > 1 && (
          <Polyline
            positions={routeCoords}
            pathOptions={{ color: "blue", weight: 4 }}
          />
        )}
      </MapContainer>

      {/* Overlay Error */}
      {error && (
        <div
          style={{
            position: "absolute",
            top: "20px",
            left: "50%",
            transform: "translateX(-50%)",
            background: "rgba(255, 0, 0, 0.85)",
            color: "white",
            padding: "10px 20px",
            borderRadius: "8px",
            fontWeight: "bold",
            boxShadow: "0 2px 6px rgba(0,0,0,0.3)",
            zIndex: 1000,
          }}
        >
          {error}
        </div>
      )}
    </div>
  );
}
