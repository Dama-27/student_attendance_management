document.getElementById('allPresent').addEventListener('change', function(event) {
    const checkboxes = document.querySelectorAll('input[name="present"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = event.target.checked;
    });
});

document.getElementById('attendanceForm').addEventListener('submit', function(event) {
    event.preventDefault();
    // Handle form submission, e.g., send data to the server or display a message
    alert('Attendance saved!');
});
