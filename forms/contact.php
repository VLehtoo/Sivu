<?php
error_reporting(E_ALL);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Otetaan lomakkeen tiedot
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // Tarkistetaan, että kaikki kentät on täytetty
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        http_response_code(400);
        echo "Kaikki kentät ovat pakollisia.";
        exit;
    }

    // Rakennetaan sähköpostiviesti
    $to = "Vililehto41@gmail.com";
    $headers = "From: $name <$email>";
    $body = "Aihe: $subject\n\nViesti:\n$message";

    // Lähetetään sähköposti MailHogin avulla
    $mailhogAddress = "127.0.0.1"; // Oletusosoite
    $mailhogPort = 1025; // Oletusportti
    $result = mail($to, $subject, $body, $headers, "-f$email -r$mailhogAddress:$mailhogPort");

    // Tarkistetaan, onnistuiko sähköpostin lähettäminen
    if ($result) {
        http_response_code(200);
        echo "Viesti lähetetty!";
    } else {
        http_response_code(500);
        echo "Viestin lähettäminen epäonnistui.";
    }
} else {
    http_response_code(403);
    echo "Jotain meni pieleen. Yritä uudelleen myöhemmin.";
}
header("location:../index.html")
?>
