<?php
// Load JSON data
$data = json_decode(file_get_contents('info.json'), true);

// Function to match the user query
function getChatbotResponse($query, $data) {
    $query = strtolower($query);
    $response = "";

    if (strpos($query, 'id') !== false) {
        $info = $data['services']['id_application'];
        $response .= "<strong>🆔 ID Application</strong><br>";
    } elseif (strpos($query, 'birth') !== false) {
        $info = $data['services']['birth_certificate'];
        $response .= "<strong>👶 Birth Certificate</strong><br>";
    } elseif (strpos($query, 'marriage') !== false) {
        $info = $data['services']['marriage_certificate'];
        $response .= "<strong>💍 Marriage Certificate</strong><br>";
    } elseif (strpos($query, 'death') !== false) {
        $info = $data['services']['death_certificate'];
        $response .= "<strong>⚰️ Death Certificate</strong><br>";
    } else {
        return "❓ Sorry, I couldn't understand your question. Try asking about an ID, birth certificate, marriage, or death certificate.";
    }

    $response .= "<strong>Requirements:</strong><br>- " . implode("<br>- ", $info['requirements']) . "<br><br>";
    $response .= "<strong>Process:</strong><br>- " . implode("<br>- ", $info['process']) . "<br><br>";
    $response .= "<strong>Duration:</strong> " . $info['duration'] . "<br><br>";
    $response .= "<strong>Online Services:</strong> " . $info['online_services'];

    return $response;
}

// Handle user input
$userInput = "";
$botResponse = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userInput = $_POST['message'];
    $botResponse = getChatbotResponse($userInput, $data);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Homabot</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f8ff;
            padding: 20px;
        }
        .chat-box {
            background: white;
            max-width: 600px;
            padding: 20px;
            border-radius: 10px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input[type="text"] {
            width: 80%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            padding: 10px 15px;
            border: none;
            background: #0077cc;
            color: white;
            border-radius: 5px;
        }
        .response {
            margin-top: 20px;
            background: #e6f2ff;
            padding: 15px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="chat-box">
        <h2>Homabot</h2>
        <form method="post">
            <input type="text" name="message" placeholder="Ask me about Home Affairs services..." required>
            <input type="submit" value="Ask">
        </form>
        
        <?php if ($botResponse): ?>
        <div class="response">
            <strong>You:</strong> <?php echo htmlspecialchars($userInput); ?><br><br>
            <strong>Bot:</strong><br> <?php echo $botResponse; ?>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
