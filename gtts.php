<?php
$context = stream_context_create(array(
    "ssl" => array(
        "verify_peer" => false,
        "verify_peer_name" => false,
    ),
));
?>

<form method="post">
    <input id="txt" name="txt" type="textbox" />
    <select name="lang">
        <option value="en">English</option>
        <option value="fr">French</option>
        <option value="es">Spanish</option>
        <option value="de">German</option>
    </select>
    <input name="submit" type="submit" value="Convert to Speech" />
</form>

<?php
if (isset($_POST['txt'])) {
    $txt = $_POST['txt'];
    $txt = htmlspecialchars($txt);
    $txt = preg_replace('/\p{P}/', '', $txt);
    $words = explode(' ', $txt);
    $txtChunks = array();

    // Create chunks of text based on desired maximum length
    $maxChunkLength = 200;
    $currentChunk = '';
    foreach ($words as $word) {
        $wordLength = strlen($word);
        if (strlen($currentChunk) + $wordLength + 1 <= $maxChunkLength) {
            $currentChunk .= $word . ' ';
        } else {
            $txtChunks[] = trim($currentChunk);
            $currentChunk = $word . ' ';
        }
    }
    if (!empty($currentChunk)) {
        $txtChunks[] = trim($currentChunk);
    }
    //$txtChunks = str_split($txt, 200); // Split text into chunks of 5000 characters or less
    // foreach ($txtChunks as $txtChunk) {
    //     echo '<p>' . $txtChunk . '</p><br><br>';
    // }
    // Get the selected language code from the dropdown
    $langCode = $_POST['lang'];
    $fileChunks = array(); // Initialize an empty array to store audio chunks

    // Iterate through text chunks and convert each one to speech
    foreach ($txtChunks as $txtChunk) {
        $txtChunk = rawurlencode($txtChunk);
        $final = 'https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q=' . $txtChunk . '&tl=' . $langCode;

        // Send request to API for this chunk of text
        $ch = curl_init($final);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
            exit();
        }
        // Add this chunk of audio to the array of audio chunks
        $fileChunks[] = $response;

        curl_close($ch);
    }
    //print_r($fileChunks);

    // Generate unique filenames for each audio chunk
    $fileNames = array();
    foreach ($fileChunks as $key => $fileChunk) {
        $fileName = 'chunk' . $key . '.mp3';
        file_put_contents($fileName, $fileChunk);
        $fileNames[] = $fileName;
    }

    // Concatenate all audio chunks into a single audio file
    $fullAudio = '';
    foreach ($fileNames as $fileName) {
        $fullAudio .= file_get_contents($fileName);
        unlink($fileName); // Delete the audio chunk file after it's concatenated
    }

    // Save audio file
    $filename = 'output.mp3';
    file_put_contents($filename, $fullAudio);
}

if (isset($filename)) {
    echo '<audio controls>
         <source src="' . $filename . '" type="audio/mpeg">
         Your browser does not support the audio element.
       </audio>';
}
?>