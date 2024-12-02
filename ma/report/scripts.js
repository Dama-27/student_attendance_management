document.getElementById('load').addEventListener('click', function() {
    const tbody = document.getElementById('report-table-body');
    tbody.innerHTML = ''; 

    const data = [
        { regNo: '001', name: 'John Doe', present: '10', total: '15', percentage: '66%' },
        { regNo: '002', name: 'Jane Smith', present: '12', total: '15', percentage: '80%' },
    ];

    data.forEach(row => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${row.regNo}</td>
            <td>${row.name}</td>
            <td>${row.present}</td>
            <td>${row.total}</td>
            <td>${row.percentage}</td>
        `;
        tbody.appendChild(tr);
    });
});
