<x-filament-panels::page>
    <div>
        <div id="calendar"></div>

        {{-- FullCalendar CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    events: '/armada-events', // ambil dari route
                    selectable: true, // agar bisa pilih tanggal
                    select: function(info) {
                        let title = prompt("Masukkan nama event:");
                        if (title) {
                            fetch("/armada-events", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                },
                                body: JSON.stringify({
                                    title: title,
                                    start: info.startStr,
                                    end: info.endStr
                                })
                            })
                            .then(res => res.json())
                            .then(event => {
                                calendar.addEvent(event); // langsung tampilkan event baru
                            })
                            .catch(err => console.error(err));
                        }
                        calendar.unselect();
                    },
                    editable: true,
                    eventDrop: function(info) {
                        // update saat drag & drop
                        fetch(`/armada-events/${info.event.id}`, {
                            method: "PUT",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                start: info.event.start.toISOString(),
                                end: info.event.end ? info.event.end.toISOString() : null
                            })
                        });
                    },
                    eventClick: function(info) {
                        if (confirm("Hapus event ini?")) {
                            fetch(`/armada-events/${info.event.id}`, {
                                method: "DELETE",
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                }
                            })
                            .then(() => {
                                info.event.remove();
                            });
                        }
                    }
                });

                calendar.render();
            });
        </script>

        <style>
            #calendar {
                max-width: 1000px;
                margin: 0 auto;
                background: white;
                padding: 1rem;
                border-radius: 1rem;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }
        </style>
    </div>
</x-filament-panels::page>
