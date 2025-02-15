# AnonymZ.io

Welcome to AnonymZ.io, a service dedicated to anonymizing links for various platforms. Our goal is to enhance privacy and security by masking the source of web traffic and acting as a referrer—ensuring a safer online environment for users.

## Overview

AnonymZ.io provides a crucial layer of security in today's digital landscape. By anonymizing links and functioning as a referrer, we protect users' privacy and prevent tracking of web traffic sources. This service is essential for maintaining the confidentiality of online activities, especially for services handling sensitive information.

## How It Works

AnonymZ.io processes input URLs via a PHP-based redirector. The tool:
- **Strips out tracking and affiliate parameters:** Removes unnecessary query parameters for a cleaner URL.
- **Simplifies Google search URLs:** Retains only the essential search query.
- **Handles URL normalization:** Ensures that input URLs include a valid scheme (defaulting to `http://` if missing).

Additionally, our server is configured with a custom `.htaccess` file that:
- Prevents directory listings.
- Forces HTTPS for all incoming requests.
- Redirects traffic directly to `redirect.php` while preserving the original query.
- Automatically prefixes non-schemed inputs with `http://`.

These features work together to ensure all traffic is securely processed and anonymized before reaching its destination.

## How to Use

There are two primary methods to use AnonymZ.io:

1. **Link Anonymization:**  
   Visit [AnonymZ.io](https://anonymz.io/) and enter the URL you wish to anonymize. The service will generate a new, obscured link that can be shared.  
   **Example:**
   ```
   https://anonymz.io/?https://google.ca
   ```
   
2. **Using as a Referrer:**  
Append your target URL to `https://anonymz.io/?` in your application or website. This method anonymizes the traffic source, ensuring that the destination site does not receive your original referrer information.

## Setup and Deployment

If you want to self-host or contribute to AnonymZ.io, follow these steps:

1. **Clone the Repository:**
```bash
git clone https://github.com/Finch-Studio/AnonymZ.git
```

2. **Server Configuration:**

 - Use the provided .htaccess file for handling URL redirection, HTTPS enforcement, and security settings.
 - The .htaccess file ensures:
  - Directory listings are prevented.
  - All incoming traffic is forced to use HTTPS.
  - URLs passed via the query string are correctly normalized and redirected to redirect.php.

3. **Customize the PHP Code (if needed):**

 - Modify redirect.php for additional sanitization or to adjust delay logic according to your requirements.

## Contributing

We welcome contributions from the community! If you have suggestions for improvements or new features, feel free to fork this repository and submit a pull request with your changes.

### Adding Changes

1. Fork the repository.
2. Create a new branch:
   ```bash
   git checkout -b feature-branch
   ```
  
3. Make your changes and commit them:
   ```bash
   git commit -am 'Add some feature'
   ```
4. Push to the branch:
   ```bash
   git push origin feature-branch
   ```
5. Create a new Pull Request.

### Adding Comments or Suggestions

If you have feedback or ideas for enhancements, please open an issue on GitHub or add comments directly in the code.

## License

You are welcome to use this site as you see fit. If you're using the live version of AnonymZ.io, feel free to utilize it without restrictions. However, self-hosting requires a different approach—if you deploy your own instance, please review and modify the code to suit your specific needs. You may remove the "View on GitHub" button and instead integrate the provided code within the body for a cleaner implementation. If you modify or rebuild the site, or use parts of it, you must also ensure the source code location remains visible.
```html
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
  .github-link {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
    text-decoration: none;
  }

  .github-button {
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.7;
    transition: opacity 0.3s;
  }

  .github-button i {
    font-size: 50px;
    color: #ffffff;
  }

  .github-link:hover .github-button {
    opacity: 1;
  }

  .tooltip {
    position: absolute;
    bottom: 60px;
    right: 10px;
    background-color: rgba(0, 0, 0, 0.8);
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 12px;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s, visibility 0.3s;
  }

  .github-link:hover .tooltip {
    opacity: 1;
    visibility: visible;
  }
</style>

<a href="https://github.com/Finch-Studio/AnonymZ" target="_blank" class="github-link">
  <div class="github-button">
    <i class="fa-brands fa-github"></i>
  </div>
  <span class="tooltip">View Source</span>
</a>
```

Thank you for supporting AnonymZ.io!

# donate

Thank you ❤️ for considering to donate to me. Here are several ways you may do so:

[![PayPal](https://srv-cdn.himpfen.io/badges/paypal/paypal-flat.svg)](https://paypal.me/FinchStudio) 

**Bitcoin (BTC):** `bc1qfnpg8lvw65349utkezqx8j484ng0dlgv4x0cns` <br />
**Ethereum (ETH):** `0x3F3AAc69d3Eb2A397670651d04355650d39e5d0f` <br />
**Solana (SOL):** `9J3TdWRXF5EJALtDZcaikqF5vhEihT8AMxnjm3VGkzVL`
