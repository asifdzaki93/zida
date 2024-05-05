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
    </div>
    <script type="text/javascript">
        const eventSource = new EventSource('http://localhost:3000/sessions/tes/add-sse?api_key=a6bc226axxxxxxxxxxxxxxxxxxxxx');
        eventSource.onerror = eventSource.close;
        eventSource.onmessage = (event) => {
            const data = JSON.parse(event.data);
            console.log(data);
            document.querySelector('#qr').src = data.qr || '';
            document.querySelector('#data').innerHTML = event.data;
        };
    </script>
</body>

</html>