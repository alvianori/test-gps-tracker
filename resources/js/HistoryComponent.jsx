import React, { useState, useEffect } from "react";
import {
  MapContainer,
  TileLayer,
  Polyline,
  Marker,
  Popup,
  useMap,
} from "react-leaflet";
import "leaflet/dist/leaflet.css";
import L from "leaflet";

// ================== TitleControl ==================
function TitleControl({ selectedDate }) {
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
          🚗 ATLAS DIGITALIZE <span style="color:#2563eb;">GPS Tracking</span>
          <br/>
          <span style="font-size:13px; color:#555;">${selectedDate}</span>
        </div>
      `;
      return div;
    };
    titleDiv.addTo(map);
    return () => {
      titleDiv.remove();
    };
  }, [map, selectedDate]);

  return null;
}

// ================== TimelineControl ==================
function TimelineControl({ dates, selectedDate, onSelectDate }) {
  const map = useMap();

  useEffect(() => {
    const timelineDiv = L.control({ position: "bottomleft" });
    timelineDiv.onAdd = () => {
      const div = L.DomUtil.create("div", "leaflet-bar");
      div.style.overflowX = "auto";
      div.style.whiteSpace = "nowrap";
      div.style.background = "rgba(255,255,255,0.9)";
      div.style.padding = "6px 10px";
      div.style.borderRadius = "8px";

      dates.forEach((date) => {
        const btn = L.DomUtil.create("button", "", div);
        btn.innerText = date;
        btn.style.margin = "2px";
        btn.style.padding = "4px 8px";
        btn.style.borderRadius = "6px";
        btn.style.border = "none";
        btn.style.cursor = "pointer";
        btn.style.color = "white";
        btn.style.background =
          date === selectedDate ? "#2563eb" : "#6b7280";

        btn.onclick = () => {
          onSelectDate(date);
        };
      });

      return div;
    };
    timelineDiv.addTo(map);
    return () => {
      timelineDiv.remove();
    };
  }, [map, dates, selectedDate, onSelectDate]);

  return null;
}

// ================== Custom Icon ==================
const customIcon = new L.Icon({
  iconUrl: "/images/mobil5.png",
  iconSize: [32, 32],
  iconAnchor: [16, 32],
});

// ================== HistoryComponent ==================
export default function HistoryComponent() {
  const [historyData, setHistoryData] = useState([]);
  const [selectedDate, setSelectedDate] = useState("");
  const [availableDates, setAvailableDates] = useState([]);

  // Fetch dari API
  useEffect(() => {
    fetch("https://test-gps.atlasdigitalize.com/api/gps-data/device/ESP006")
      .then((res) => res.json())
      .then((data) => {
        const dates = [
          ...new Set(
            data.map((d) =>
              new Date(d.created_at).toISOString().split("T")[0]
            )
          ),
        ].sort((a, b) => new Date(b) - new Date(a));

        // ambil hanya 5 hari terakhir
        const last5 = dates.slice(0, 5);

        setAvailableDates(last5);

        if (last5.length > 0) {
          setSelectedDate(last5[0]); // default pakai hari terbaru
          filterByDate(last5[0], data);
        }
      });
  }, []);

  const filterByDate = (date, allData) => {
    const filtered = allData.filter(
      (d) => new Date(d.created_at).toISOString().split("T")[0] === date
    );
    setHistoryData(filtered);
  };

  return (
    <MapContainer
      center={[-6.9952, 110.4301]}
      zoom={15}
      style={{ height: "100vh", width: "100%" }}
      attributionControl={false}
    >
      <TileLayer url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png" />

      {/* Judul */}
      <TitleControl selectedDate={selectedDate} />

      {/* Timeline */}
      <TimelineControl
        dates={availableDates}
        selectedDate={selectedDate}
        onSelectDate={(date) => {
          setSelectedDate(date);
          fetch(
            "https://test-gps.atlasdigitalize.com/api/gps-data/device/ESP006"
          )
            .then((res) => res.json())
            .then((data) => filterByDate(date, data));
        }}
      />

      {/* Polyline */}
      {historyData.length > 0 && (
        <Polyline
          positions={historyData.map((d) => [d.latitude, d.longitude])}
          pathOptions={{ color: "blue", weight: 4 }}
        />
      )}

      {/* Marker titik awal & akhir */}
      {historyData.length > 0 && (
        <>
          {/* Titik Awal */}
          <Marker
            position={[historyData[0].latitude, historyData[0].longitude]}
            icon={customIcon}
          >
            <Popup>
              <div>
                <b>🚦 Titik Awal</b> <br />
                LatLng: {historyData[0].latitude}, {historyData[0].longitude}{" "}
                <br />
                Waktu: {new Date(historyData[0].created_at).toLocaleString()}{" "}
                <br />
                Kecepatan: {historyData[0].speed} km/h
              </div>
            </Popup>
          </Marker>

          {/* Titik Akhir */}
          <Marker
            position={[
              historyData[historyData.length - 1].latitude,
              historyData[historyData.length - 1].longitude,
            ]}
            icon={customIcon}
          >
            <Popup>
              <div>
                <b>🏁 Titik Akhir</b> <br />
                LatLng: {historyData[historyData.length - 1].latitude},{" "}
                {historyData[historyData.length - 1].longitude} <br />
                Waktu:{" "}
                {new Date(
                  historyData[historyData.length - 1].created_at
                ).toLocaleString()}{" "}
                <br />
                Kecepatan: {historyData[historyData.length - 1].speed} km/h
              </div>
            </Popup>
          </Marker>
        </>
      )}
    </MapContainer>
  );
}
