import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";

// Initialize flatpickr on the event date range input
flatpickr("#event-datetime-range", {
    enableTime: true,
    mode: "range",
    dateFormat: "Y-m-d H:i",
    time_24hr: true,
});