<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    <link rel="stylesheet" href="style4.css">
    <link rel="stylesheet" href="style1.css">



</head>

<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "grubhub";
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if (isset($_POST['submit'])) {
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
        // $langCode = "en";
        $fileChunks = array(); // Initialize an empty array to store audio chunks
        $langcode = $_POST['lang'];
        // Iterate through text chunks and convert each one to speech
        foreach ($txtChunks as $txtChunk) {
            $txtChunk = rawurlencode($txtChunk);
            $final = 'https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q=' . $txtChunk . '&tl=' . $langcode;

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

        $query = "Select * from recipe where instruction='$txt'";
        $query_run = mysqli_query($conn, $query);
        if (mysqli_num_rows($query_run) > 0) {
            while ($row = mysqli_fetch_array($query_run)) {

    ?>

                <section class="display">
                    <img src="./uploads/<?php echo $row['image']; ?>" height=100px width=100px>
                    <div class="name"><?php echo $row['name']; ?></div>
                    <div class="ingredient-con">
                        <h4>Required Ingredients are:</h2>
                            <ul>
                                <?php
                                $ing = $row['ingredients'];
                                $ingredients = preg_split("/\,/", $ing);
                                $arrlength = count($ingredients);
                                for ($x = 0; $x < $arrlength; $x++) { ?>
                                    <li><?php echo $ingredients[$x]; ?></li>
                                <?php
                                } ?>
                            </ul>
                    </div>
                    <div class="instruct"><?php echo $row['instruction']; ?></div>
                </section>



    <?php
            }
        }

        // echo $txt;
        echo '<center><audio controls style="margin-top:20%;">
         <source src="' . $filename . '" type="audio/mpeg">
         Your browser does not support the audio element.
       </audio></center>';
    }
    ?>
</body>