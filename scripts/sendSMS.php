<?php
// Load the Twilio PHP library
require_once 'path/to/twilio-php-master/src/Twilio/autoload.php'; // Adjust the path to your Twilio library
use Twilio\Rest\Client;

// Twilio account credentials
$account_sid = 'your_account_sid';    // Your Account SID from Twilio Console
$auth_token = 'your_auth_token';      // Your Auth Token from Twilio Console
$twilio_number = 'your_twilio_number';// Your Twilio phone number (e.g., +1234567890)

// Function to send SMS
function sendRegistrationSMS($phoneNumber, $name) {
    // Create a Twilio Client
    $client = new Client($GLOBALS['account_sid'], $GLOBALS['auth_token']);

    // SMS message content
    $messageBody = "Hello, $name! Your evacuation registration has been successfully completed.";

    try {
        // Send SMS via Twilio
        $message = $client->messages->create(
            $phoneNumber, // To phone number (e.g., '+1234567890')
            [
                'from' => $GLOBALS['twilio_number'], // From Twilio number
                'body' => $messageBody               // Message content
            ]
        );

        // Return success response
        return "Message sent to $phoneNumber";
    } catch (Exception $e) {
        // Return error response
        return "Error: " . $e->getMessage();
    }
}

// Example usage of the function
$evacueePhoneNumber = '+1234567890'; // Replace with evacuee's phone number
$evacueeName = 'John Doe';           // Replace with evacuee's name

// Call the function to send SMS
$result = sendRegistrationSMS($evacueePhoneNumber, $evacueeName);
echo $result; // Display result (success or error message)

?>
