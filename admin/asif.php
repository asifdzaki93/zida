<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>WhatsApp Session Manager</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>WhatsApp Session Manager</h1>
    <table>
        <thead>
            <tr>
                <th>Session ID</th>
                <th>Status</th>
                <th>Show QR</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody id="sessionsTableBody"></tbody>
    </table>
    <h2>Create New Session</h2>
    <form id="createSession">
        <input type="text" id="sessionId" placeholder="Enter Session ID" required>
        <button type="submit">Create Session</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchSessions();

            document.getElementById('createSession').addEventListener('submit', function(e) {
                e.preventDefault();
                const sessionId = document.getElementById('sessionId').value;
                createSession(sessionId);
            });
        });

        function fetchSessions() {
            fetch('http://localhost:3000/sessions', {
                    headers: {
                        'x-api-key': 'a6bc226axxxxxxxxxxxxxx'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch sessions: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(sessions => {
                    const table = document.getElementById('sessionsTableBody');
                    table.innerHTML = '';
                    sessions.forEach(session => {
                        const row = table.insertRow();
                        row.insertCell(0).innerText = session.id;
                        row.insertCell(1).innerText = session.status;
                        const qrBtn = row.insertCell(2).appendChild(document.createElement('button'));
                        qrBtn.innerText = 'Show QR';
                        qrBtn.onclick = () => showQR(session.id);
                        const delBtn = row.insertCell(3).appendChild(document.createElement('button'));
                        delBtn.innerText = 'Delete';
                        delBtn.onclick = () => deleteSession(session.id);
                    });
                })
                .catch(error => console.error(error.message));
        }

        function showQR(sessionId) {
            fetch(`http://localhost:3000/sessions/${sessionId}/qr`, {
                    headers: {
                        'x-api-key': 'a6bc226axxxxxxxxxxxxxx'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch QR code: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.qr) {
                        alert('QR Code: ' + data.qr);
                    } else {
                        alert('QR Code not available.');
                    }
                })
                .catch(error => console.error(error.message));
        }


        function deleteSession(sessionId) {
            fetch(`http://localhost:3000/sessions/${sessionId}`, {
                    method: 'DELETE',
                    headers: {
                        'x-api-key': 'a6bc226axxxxxxxxxxxxxx'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    console.log('Session deleted');
                    fetchSessions(); // Refresh the list
                })
                .catch(error => console.error('Error deleting session:', error));
        }

        function createSession(sessionId) {
            fetch('http://localhost:3000/sessions/add', {
                    method: 'POST',
                    headers: {
                        'x-api-key': 'a6bc226axxxxxxxxxxxxxx',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        sessionId: sessionId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Session created', data);
                    fetchSessions(); // Refresh the list
                })
                .catch(error => console.error('Error creating session:', error));
        }
    </script>
</body>

</html>