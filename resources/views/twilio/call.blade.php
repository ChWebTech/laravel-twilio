<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twilio Voice Call</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--script src="https://sdk.twilio.com/js/client/v1.12/twilio.min.js"></!--script-->
    <script src="https://sdk.twilio.com/js/client/v1.14/twilio.js"></script>
</head>
<body class="p-5">
    <div class="container">
        <h1>Make a Call</h1>
        <form id="callForm">
            <div class="mb-3">
                <label for="to" class="form-label">Phone Number (E.164 format)</label>
                <input type="text" class="form-control" id="to" placeholder="+1234567890" required>
            </div>
            <button type="submit" class="btn btn-primary">Call</button>
        </form>

        <div id="status" class="mt-4"></div>
    </div>

    <script>
        let device;

        // Setup Twilio Device
        async function setupDevice() {
            const response = await fetch('/twilio-token'); // Fetch Access Token
            const { token } = await response.json();
            //console.log(token);
            device = new Twilio.Device(token, { debug: true });

            device.on('tokenExpired', async() => {
                console.log('Token expired.');
            });
            device.on('ready', () => {
                console.log('Twilio Device ready to make calls.');
            });

            device.on('error', (error) => {
                console.error('Twilio Device error:', error);
            });
        }

        async function makeCall(to) {
            const connection = device.connect({ To: to });
            connection.on('accept', () => {
                console.log('Call connected!');
                document.getElementById('status').innerHTML = '<div class="alert alert-success">Call connected!</div>';
            });

            connection.on('disconnect', () => {
                console.log('Call disconnected.');
                document.getElementById('status').innerHTML = '<div class="alert alert-info">Call ended.</div>';
            });

            connection.on('error', (error) => {
                console.error('Call error:', error);
                document.getElementById('status').innerHTML = '<div class="alert alert-danger">Error: ' + error.message + '</div>';
            });
        }

        document.getElementById('callForm').addEventListener('submit', (e) => {
            e.preventDefault();
            const to = document.getElementById('to').value;
            if (!to) {
                alert('Please enter a phone number.');
                return;
            }
            makeCall(to);
        });

        setupDevice();
    </script>
</body>
</html>
