<!DOCTYPE html>
<html>
<head>
    <title>Confirmare Rezervare</title>
</head>
<body>
    <h1>Salut {{ $reservation->coreUser->username }},</h1>
    <p>Mulțumim pentru rezervarea ta. Iată detaliile:</p>
    <ul>
        <li><strong>Doctor:</strong> {{ $reservation->doctor->name }}</li>
        <li><strong>Specializare:</strong> {{ $reservation->specialization->specialization_name }}</li>
        <li><strong>Ora:</strong> {{ $reservation->reservationSlot->time }}</li>
        <li><strong>Status:</strong> {{ $reservation->status }}</li>
    </ul>
    <p>Te așteptăm cu drag!</p>
</body>
</html>
