# GPS Tracker API Documentation

## Overview
API ini menyediakan endpoint untuk IoT device agar dapat mengirim data GPS tracking ke sistem tanpa middleware. Endpoint ini terintegrasi dengan sistem GPS Device dan menyimpan data ke tabel `gps_tracks`.

## Base URL
```
http://localhost:8000/api
```

## Device Code yang Tersedia untuk Testing
- `ATL001` - Atalanta
- `TEST001` - Test Device

## GPS Tracks API (Untuk IoT tanpa middleware)

### 1. Store Single GPS Track Data

**Endpoint:** `POST /api/gps-tracks`

**Description:** Menyimpan satu data GPS track dari IoT device

**Request Body:**

```json
{
    "device_code": "ATL001",
    "latitude": "3.5952",
    "longitude": "98.6722",
    "speed": 60,
    "course": 180,
    "direction": "S",
    "devices_timestamp": "2024-06-28 14:30:00"
}
```

**Response Success (201):**

```json
{
    "success": true,
    "message": "Data GPS track berhasil disimpan",
    "data": {
        "id": 21,
        "device_code": "ATL001",
        "latitude": "3.5952",
        "longitude": "98.6722",
        "speed": 60,
        "course": 180,
        "direction": 180,
        "devices_timestamp": "2024-06-28 14:30:00",
        "created_at": "2024-06-28T14:30:15.000000Z"
    }
}
```

**Response Error (404):**

```json
{
    "success": false,
    "message": "GPS device dengan kode tersebut tidak ditemukan.",
    "errors": {
        "device_code": ["GPS device dengan kode tersebut tidak ditemukan."]
    }
}
```

**Response Error (422):**

```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "latitude": ["The latitude field is required."]
    }
}
```

### 2. Store Bulk GPS Track Data

**Endpoint:** `POST /api/gps-tracks/bulk`

**Description:** Menyimpan multiple data GPS track sekaligus (maksimal 100 data per request)

**Request Body:**

```json
{
    "device_code": "ATL001",
    "data": [
        {
            "latitude": -6.2,
            "longitude": 106.816666,
            "speed": 45.5,
            "course": 180.0,
            "direction": "S",
            "devices_timestamp": "2024-01-15 10:30:00"
        },
        {
            "latitude": -6.201,
            "longitude": 106.817666,
            "speed": 50.0,
            "course": 185.0,
            "direction": "S",
            "devices_timestamp": "2024-01-15 10:31:00"
        }
    ]
}
```

**Response Success (201):**

```json
{
    "success": true,
    "message": "Data GPS track bulk berhasil disimpan",
    "data": {
        "device_code": "GPS001",
        "inserted_count": 2,
        "timestamp": "2024-01-15T10:30:15.000000Z"
    }
}
```

### 3. Get GPS Tracks by Device Code

**Endpoint:** `GET /api/gps-tracks/device/{deviceCode}`

**Description:** Mengambil data GPS track berdasarkan kode device (100 data terbaru)

**Response Success (200):**

```json
{
    "success": true,
    "data": [
        {
            "id": 16,
            "gps_device_id": 1,
            "latitude": "-6.1751100",
            "longitude": "106.8650360",
            "speed": 79,
            "course": 73,
            "direction": 29,
            "devices_timestamp": "2025-08-29 14:20:57",
            "created_at": "2025-08-29T14:25:57.000000Z",
            "updated_at": "2025-08-29T14:25:57.000000Z"
        },
        {
            "id": 17,
            "gps_device_id": 1,
            "latitude": "-6.1761100",
            "longitude": "106.8660360",
            "speed": 31,
            "course": 200,
            "direction": 356,
            "devices_timestamp": "2025-08-29 14:15:57",
            "created_at": "2025-08-29T14:25:57.000000Z",
            "updated_at": "2025-08-29T14:25:57.000000Z"
        }
    ],
    "device_info": {
        "code": "ATL001",
        "name": "Atalanta",
        "provider": "+6281234567890"
    }
}
```

**Example Request:**

```
GET /api/gps-tracks/filter?device_code=ATL001&type=custom&start_date=2025-08-29 00:00:00&end_date=2025-08-30 23:59:59
```

```
GET /api/gps-tracks/filter?device_code=ATL001&type=all
```

**Response Success (200):**

```json
{
    "success": true,
    "data": [
        {
            "id": 123,
            "gps_device_id": 1,
            "latitude": -6.2,
            "longitude": 106.816666,
            "speed": 45.5,
            "course": 180.0,
            "direction": "S",
            "devices_timestamp": "2024-01-15T10:30:00.000000Z",
            "created_at": "2024-01-15T10:30:15.000000Z",
            "updated_at": "2024-01-15T10:30:15.000000Z"
        }
    ],
    "device_info": {
        "code": "ATL001",
        "name": "Atalanta",
        "provider": "+628123456789"
    }
}
```

### 4. Get Latest GPS Track Data

**Endpoint:** `GET /api/gps-tracks/latest`

**Description:** Mengambil data GPS track terbaru, bisa difilter berdasarkan device code

**Description:** Mengambil data GPS track terbaru dari semua device

**Response Success (200):**

```json
{
    "success": true,
    "data": {
        "id": 123,
        "latitude": -6.2,
        "longitude": 106.816666,
        "speed": 45.5,
        "course": 180.0,
        "direction": "S",
        "devices_timestamp": "2024-01-15T10:30:00.000000Z",
        "device_info": {
            "code": "ATL001",
            "name": "Atalanta",
            "provider": "+628123456789"
        }
    }
}
```

### 5. Filter GPS Track Data by Date

**Endpoint:** `GET /api/gps-tracks/filter?device_code={deviceCode}&type={type}&start_date={startDate}&end_date={endDate}`

**Description:** Mengambil data GPS track berdasarkan filter tanggal

**Query Parameters:**

-   `device_code` (required): Kode device untuk filter
-   `type` (required): Tipe filter (daily, weekly, monthly, yearly, custom, all)
-   `start_date` (required for custom type): Tanggal awal untuk filter custom (format: YYYY-MM-DD HH:MM:SS)
-   `end_date` (required for custom type): Tanggal akhir untuk filter custom (format: YYYY-MM-DD HH:MM:SS)

**Response Success (200):**

```json
{
    "success": true,
    "data": [
        {
            "id": 123,
            "gps_device_id": 1,
            "latitude": -6.2,
            "longitude": 106.816666,
            "speed": 45.5,
            "course": 180.0,
            "direction": "S",
            "devices_timestamp": "2024-01-15T10:30:00.000000Z",
            "created_at": "2024-01-15T10:30:15.000000Z",
            "updated_at": "2024-01-15T10:30:15.000000Z"
        }
    ],
    "device_info": {
        "code": "ATL001",
        "name": "Atalanta",
        "provider": "+628123456789"
    }
}
```

## Field Validation Rules

-   `device_code`: Required, string (harus ada di database GPS devices)
-   `latitude`: Required, numeric, between -90 and 90
-   `longitude`: Required, numeric, between -180 and 180
-   `speed`: Optional, numeric, minimum 0
-   `course`: Optional, numeric, between 0 and 360
-   `direction`: Optional, string (arah mata angin seperti 'N', 'S', 'E', 'W', 'NE', 'SE', 'SW', 'NW') atau numeric (derajat 0-360)
-   `devices_timestamp`: Required, format Y-m-d H:i:s

## Error Codes

-   `200`: Success
-   `201`: Created successfully
-   `400`: Bad request (format tanggal tidak valid, parameter tidak lengkap)
-   `404`: Resource not found (device tidak ditemukan, data tidak ditemukan)
-   `422`: Validation error
-   `500`: Internal server error

## Notes for IoT Implementation

1. **Recommended Endpoint**: Gunakan `/api/gps-tracks` untuk implementasi IoT tanpa middleware.

2. **Device Registration**: Pastikan GPS device sudah terdaftar di sistem dengan `code` yang unik sebelum mengirim data.

3. **Bulk vs Single**: Gunakan bulk endpoint untuk efisiensi jika IoT device mengumpulkan multiple data points sebelum mengirim.

4. **Error Handling**: Implementasikan retry mechanism untuk handle error 500, dan logging untuk error 404/422.

5. **Rate Limiting**: Bulk endpoint dibatasi maksimal 100 data per request untuk menjaga performa.

6. **Direction Format**: Field `direction` dapat dikirim dalam format arah mata angin (N, S, E, W, NE, SE, SW, NW) atau dalam format derajat (0-360). Sistem akan otomatis mengkonversi arah mata angin ke derajat saat menyimpan data.

7. **Timestamp Format**: Gunakan format MySQL datetime format (YYYY-MM-DD HH:MM:SS) untuk field `devices_timestamp`.

## Example IoT Implementation (Python)

```python
import requests
import json
from datetime import datetime

def send_gps_data(device_code, latitude, longitude, speed=None, course=None, direction=None):
    url = "http://your-domain.com/api/gps-tracks"

    data = {
        "device_code": device_code,
        "latitude": latitude,
        "longitude": longitude,
        "speed": speed,
        "course": course,
        "direction": direction,
        "devices_timestamp": datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    }

    try:
        response = requests.post(url, json=data, timeout=30)

        if response.status_code == 201:
            print("Data sent successfully")
            return response.json()
        elif response.status_code == 404:
            print(f"Device not found: {device_code}")
        elif response.status_code == 422:
            print(f"Validation error: {response.json()}")
        else:
            print(f"Error: {response.status_code}")

    except requests.exceptions.RequestException as e:
        print(f"Request failed: {e}")
        # Implement retry logic here

# Usage
send_gps_data("GPS001", -6.200000, 106.816666, 45.5, 180.0, "S")
```

## Bulk Data Example (Python)

```python
import requests
import json
from datetime import datetime, timedelta

def send_bulk_gps_data(device_code, data_points):
    url = "http://your-domain.com/api/gps-tracks/bulk"

    data = {
        "device_code": device_code,
        "data": data_points
    }

    try:
        response = requests.post(url, json=data, timeout=30)

        if response.status_code == 201:
            print("Bulk data sent successfully")
            return response.json()
        elif response.status_code == 404:
            print(f"Device not found: {device_code}")
        elif response.status_code == 422:
            print(f"Validation error: {response.json()}")
        else:
            print(f"Error: {response.status_code}")

    except requests.exceptions.RequestException as e:
        print(f"Request failed: {e}")
        # Implement retry logic here

# Generate sample data points (10 points, 1 minute apart)
data_points = []
now = datetime.now()

for i in range(10):
    timestamp = now - timedelta(minutes=i)
    data_points.append({
        "latitude": -6.200000 + (i * 0.001),
        "longitude": 106.816666 + (i * 0.001),
        "speed": 45.5 + i,
        "course": 180.0 + i,
        "direction": "S",
        "devices_timestamp": timestamp.strftime("%Y-%m-%d %H:%M:%S")
    })

# Usage
send_bulk_gps_data("GPS001", data_points)
```
