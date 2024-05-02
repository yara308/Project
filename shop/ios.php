<?php
// Function to send notification
function sendNotification($topic, $title, $body) {
    $apiKey = 'AAAAHolJDtk:APA91bGzemlEmY2q6LNA0Ltzrf4rqwQz0PdEdjVWMCPFlvdGlyPW7cKY6qLYN3gLKF3Dx8ISeqpDxurrwUFLzpFn6Z9EKr13vhcdIZiSCniv5IY5Ix-X9o42yuk7kgjQ-ZabDVFWeg2U';
$notification = [
        'to' => '/topics/' . $topic,
        'notification' => [
            'title' => $title,
            'body' => $body
        ],
        'android' => [
            'notification' => [
                'image' => $image_url
            ]
        ],
        'webpush' => [
            'notification' => [
                'icon' => $image_url
            ]
        ]
    ];

    $headers = [
        'Authorization: key=' . $apiKey,
        'Content-Type: application/json'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notification));

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $topic = $_POST['topic'];
    $title = $_POST['title'];
    $body = $_POST['body'];

    $response = sendNotification($topic, $title, $body);
    echo $response;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Notification</title>
</head>
<body>

<form action="" method="post">
    <label for="topic">Topic:</label><br>
    <input type="text" id="topic" name="topic" value=""><br>
    <label for="title">Title:</label><br>
    <input type="text" id="title" name="title" value=""><br>
    <label for="body">Body:</label><br>
    <input type="text" id="body" name="body" value=""><br><br>
 <label for="image_url">Image URL:</label><br>
    <input type="text" id="image_url" name="image_url" value=""><br><br>  <!-- حقل جديد لرابط الصورة -->
    
    <input type="submit" value="Submit">
</form>

</body>
</html>
