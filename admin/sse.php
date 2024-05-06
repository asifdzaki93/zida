<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>SSE Example test</title>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <img src="" alt="qr" id="qr" class="img-fluid" />
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="alert alert-info" role="alert">
                    Connection state:
                </div>
                <div class="alert alert-light" id="data" role="alert">
                    <!-- Data will be shown here -->
                </div>
            </div>
        </div>
        <!-- Form untuk mengisi nama sesi -->
        <div class="row mt-3">
            <div class="col-md-12">
                <form id="sessionForm">
                    <div class="mb-3">
                        <label for="sessionName" class="form-label">Nama Sesi:</label>
                        <input type="text" class="form-control" id="sessionName" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Mulai Sesi</button>
                </form>
            </div>
        </div>
        <!-- List sesi -->
        <div class="row mt-3">
            <div class="col-md-12">
                <h3>Daftar Sesi:</h3>
                <ul id="sessionList" class="list-group">
                    <!-- List items will be added here dynamically -->
                </ul>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        document.getElementById('sessionForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const sessionName = document.getElementById('sessionName').value;
            const eventSource = new EventSource(`http://localhost:3000/sessions/${sessionName}/add-sse?api_key=a6bc226axxxxxxxxxxxxxx`);
            eventSource.onerror = eventSource.close;
            eventSource.onmessage = (event) => {
                const data = JSON.parse(event.data);
                console.log(data);
                document.querySelector('#qr').src = data.qr || '';
                document.querySelector('#data').innerHTML = event.data;
            };
        });

        // Fetch sessions and display them
        fetch('http://localhost:3000/sessions', {
                headers: {
                    'x-api-key': 'a6bc226axxxxxxxxxxxxxx'
                }
            })
            .then(response => response.json())
            .then(sessions => {
                const sessionList = document.getElementById('sessionList');
                sessions.forEach(session => {
                    const listItem = document.createElement('li');
                    listItem.className = 'list-group-item';
                    listItem.textContent = `ID: ${session.id}, Status: ${session.status || 'Unknown'}`;

                    // Create a button to display QR code
                    const qrButton = document.createElement('button');
                    qrButton.textContent = 'Show QR';
                    qrButton.addEventListener('click', () => {
                        // Logic to display QR code for the selected session
                        const qrData = getQRDataForSession(session.id); // Implement this function to get QR data
                        // Display QR code using qrData
                    });

                    listItem.appendChild(qrButton);
                    sessionList.appendChild(listItem);
                });
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
    </script>
</body>

</html>