<?php
// List of known affiliate query parameters
$affiliateParams = ['ref', 'ref_', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'aff'];

/**
 * Ensure the URL has a scheme. If missing, prepend 'http://'.
 * (Optionally, you can add logic to enforce 'www.' if needed.)
 */
function ensureHttp($url) {
    if (!preg_match('/^https?:\/\//i', $url)) {
        $url = 'http://' . $url;
    }
    return $url;
}

/**
 * Decide whether to delay the redirect based on query complexity.
 * Returns true if there are more than 3 parameters or the query string is long.
 */
function shouldDelayRedirect($queryParams) {
    return count($queryParams) > 3 || strlen(http_build_query($queryParams)) > 100;
}

// Retrieve and normalize the URL parameter
$inputUrl = $_GET['url'] ?? '';
$inputUrl = trim($inputUrl);
$inputUrl = ensureHttp($inputUrl);

// Validate the normalized URL
if (!filter_var($inputUrl, FILTER_VALIDATE_URL)) {
    $error = "Invalid URL. Please provide a valid URL including the correct scheme.";
    $finalUrl = ''; // nothing to redirect to
} else {
    // Parse URL components
    $parsedUrl = parse_url($inputUrl);
    
    // Optionally remove "www." from host if you want to further anonymize (uncomment if desired)
    if (isset($parsedUrl['host']) && strpos($parsedUrl['host'], 'www.') === 0) {
        $parsedUrl['host'] = substr($parsedUrl['host'], 4);
    }
    
    // Parse query parameters if present
    $queryParams = [];
    if (isset($parsedUrl['query'])) {
        parse_str($parsedUrl['query'], $queryParams);
    }
    
    // Special handling for Google search URLs: keep only the 'q' parameter.
    if (isset($parsedUrl['host']) && strpos($parsedUrl['host'], 'google.') !== false) {
        $queryParams = array_intersect_key($queryParams, array_flip(['q']));
    }
    
    // Remove affiliate parameters
    foreach ($affiliateParams as $param) {
        unset($queryParams[$param]);
    }
    
    // Rebuild the URL using available components
    $finalUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
    
    // Include port if present
    if (isset($parsedUrl['port'])) {
        $finalUrl .= ':' . $parsedUrl['port'];
    }
    
    // Append path if available
    if (isset($parsedUrl['path'])) {
        $finalUrl .= $parsedUrl['path'];
    }
    
    // Append cleaned query string if parameters exist
    if (!empty($queryParams)) {
        $finalUrl .= '?' . http_build_query($queryParams);
    }
    
    // Append fragment if it exists
    if (isset($parsedUrl['fragment'])) {
        $finalUrl .= '#' . $parsedUrl['fragment'];
    }
}

// Set the Referrer-Policy header to help prevent sending referrer information.
header('Referrer-Policy: no-referrer');

// If we have a valid final URL, perform the redirect.
if (!empty($finalUrl)) {
    $delay = shouldDelayRedirect($queryParams) ? 1 : 0;
    
    if ($delay > 0) {
        // When delaying, use the Refresh header and provide a meta fallback.
        header("Refresh: $delay; url=$finalUrl");
    } else {
        // Immediate redirect without delay.
        header("Location: $finalUrl", true, 302);
    }
    exit;
}
?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo (!empty($finalUrl)) ? 'Redirecting...' : 'Error'; ?></title>
    <?php if (!empty($finalUrl) && shouldDelayRedirect($queryParams)): ?>
        <!-- Meta refresh fallback for delayed redirection -->
        <meta http-equiv="refresh" content="1; url=<?php echo htmlspecialchars($finalUrl, ENT_QUOTES, 'UTF-8'); ?>" />
    <?php endif; ?>
    <link rel="icon" type="image/png" href="/favicon.png" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #23272A;
            color: #FFFFFF;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }
        .container {
            background-color: #2C2F33;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            margin: auto;
        }
        .powered {
            color: #FFFFFF;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!empty($finalUrl)): ?>
            <h1>Please Wait...</h1>
            <p>You are being redirected.</p>
            <p><a href="<?php echo htmlspecialchars($finalUrl, ENT_QUOTES, 'UTF-8'); ?>" style="color: #7289DA;">Click here if you are not redirected automatically.</a></p>
        <?php else: ?>
            <h1>Error</h1>
            <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><a href="/" style="color: #7289DA;">Return Home</a></p>
        <?php endif; ?>
        <p class="powered">Powered by <a href="https://anonymz.io/" style="color: #FFFFFF;">Anonymz</a></p>
    </div>
</body>
</html>
