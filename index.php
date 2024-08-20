<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directory Listing</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #e0e0e0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #1e1e1e;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #e0e0e0;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin: 10px 0;
            padding: 10px;
            background: #2e2e2e;
            border: 1px solid #444;
            border-radius: 4px;
            transition: background 0.3s;
        }

        li:hover {
            background: #3e3e3e;
        }

        a {
            text-decoration: none;
            color: #82aaff;
        }

        a:hover {
            text-decoration: underline;
        }

        .fa-folder, .fa-file, .fa-html5, .fa-php, .fa-file-alt, .fa-js-square {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Index of /dump_code</h1>
        <ul id="file-list">
            <?php
                // Function to get the directory list
                function getDirectoryList($dir) {
                    $result = [];
                    $cdir = scandir($dir);
                    foreach ($cdir as $key => $value) {
                        if (!in_array($value, [".", ".."])) {
                            if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                                $result[] = [
                                    'name' => $value . '/',
                                    'type' => 'directory',
                                    'url' => $value . '/'
                                ];
                            } else {
                                $result[] = [
                                    'name' => $value,
                                    'type' => 'file',
                                    'url' => $value
                                ];
                            }
                        }
                    }
                    return $result;
                }

                // Get the directory list of the current folder
                $directoryList = getDirectoryList(__DIR__);

                // Icons for folders and specific file types using FontAwesome
                $icons = [
                    'directory' => 'fas fa-folder',           // Folder icon
                    'file' => 'fas fa-file',                  // Default file icon
                    'html' => 'fab fa-html5',                 // HTML file icon
                    'php' => 'fab fa-php',                    // PHP file icon
                    'md' => 'fas fa-file-alt',                // Markdown file icon
                    'js' => 'fab fa-js-square',               // JavaScript file icon
                ];

                // Render the directory list
                foreach ($directoryList as $item) {
                    $iconClass = $icons['file'];  // Default to file icon
                    
                    if ($item['type'] === 'directory') {
                        $iconClass = $icons['directory'];
                    } else {
                        $ext = pathinfo($item['name'], PATHINFO_EXTENSION);
                        if (array_key_exists($ext, $icons)) {
                            $iconClass = $icons[$ext];
                        }
                    }
                    
                    echo '<li>';
                    echo '<a href="' . $item['url'] . '">';
                    echo '<i class="' . $iconClass . '"></i> ';  // FontAwesome icon
                    echo $item['name'];
                    echo '</a>';
                    echo '</li>';
                }
            ?>
        </ul>
    </div>
</body>
</html>
