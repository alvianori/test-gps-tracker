// resources/js/app.jsx
import React from "react";
import ReactDOM from "react-dom/client";
import {
  BrowserRouter as Router,
  Routes,
  Route,
  useNavigate,
  useLocation,
} from "react-router-dom";
import MapComponent from "./MapComponent";
import HistoryComponent from "./HistoryComponent";

const AppLayout = () => {
  const navigate = useNavigate();
  const location = useLocation();

  return (
    // Kontainer utama sekarang menjadi 'relative' untuk acuan positioning
    <main style={{ position: 'relative', height: '100vh', width: '100vw' }}>
      
      {/* Tombol Navigasi yang "mengambang" di atas peta */}
      <nav
        style={{
          position: 'absolute',
          top: '80px',      // Jarak dari atas (di bawah tombol +/-)
          left: '10px',     // Jarak dari kiri
          zIndex: 1000,     // Pastikan tombol ini di atas layer peta
          display: 'flex',
          flexDirection: 'column', // Membuat tombol tersusun ke bawah
          gap: '8px'               // Memberi jarak antar tombol
        }}
      >
        <button
          onClick={() => navigate("/")}
          className={`px-4 py-2 rounded-lg shadow-lg transition ${
            location.pathname === "/"
              ? "bg-blue-700 text-white"
              : "bg-white text-black hover:bg-gray-100"
          }`}
        >
          Realtime
        </button>

        <button
          onClick={() => navigate("/history")}
          className={`px-4 py-2 rounded-lg shadow-lg transition ${
            location.pathname === "/history"
              ? "bg-green-700 text-white"
              : "bg-white text-black hover:bg-gray-100"
          }`}
        >
          History
        </button>
      </nav>

      {/* Konten Peta akan mengisi seluruh ruang di belakang navigasi */}
      <Routes>
        <Route path="/" element={<MapComponent />} />
        <Route path="/history" element={<HistoryComponent />} />
      </Routes>

    </main>
  );
};

ReactDOM.createRoot(document.getElementById("app")).render(
  <React.StrictMode>
    <Router>
    <AppLayout />
    </Router>
  </React.StrictMode>
);