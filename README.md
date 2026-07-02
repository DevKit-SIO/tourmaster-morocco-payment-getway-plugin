![CMI Payment Gateway for TourMaster (WordPress)](https://raw.githubusercontent.com/DevKit-SIO/tourmaster-morocco-payment-getway-plugin/main/cmi.png)

# CMI Payment Gateway for TourMaster (WordPress)

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D7.4-blue.svg)](https://www.php.net/)
[![WordPress](https://img.shields.io/badge/WordPress-%3E%3D5.0-blue.svg)](https://wordpress.org/)
[![TourMaster](https://img.shields.io/badge/TourMaster-required-orange.svg)](https://goodlayers.com/)

**CMI Payment Gateway for TourMaster** is a WordPress add-on that plugs CMI (Centre Monétique Interbancaire) hosted 3D-Secure payments into the [TourMaster](https://goodlayers.com/) tour booking plugin, so customers can pay for bookings by card through CMI directly from the TourMaster payment flow.

It hooks into TourMaster's existing payment-gateway system (the same one used for PayPal, Stripe, and bank transfer) rather than replacing it, so it shows up as just another credit-card gateway option in the TourMaster admin settings.

## Features

- Adds **CMI** as a selectable credit-card gateway inside TourMaster's Payment settings
- Hosted 3D-Secure payment page (`3D_PAY_HOSTING`) — card data never touches your server
- Automatic **hash generation** (`ver3`) and **callback hash validation** for every transaction
- Server-to-server **IPN callback** confirms payment and updates the booking order status, independent of whether the customer's browser makes it back to your site
- Built-in **currency conversion to MAD** (ISO 4217: 504) using TourMaster's cached exchange rates, since CMI settles in Moroccan Dirham regardless of the tour's display currency
- Duplicate-transaction protection on the callback (safe against retried IPN calls)
- Localized checkout language (`ar` / `fr` / `en`) based on the site's active locale
- Works with TourMaster's deposit and full-payment pricing modes

## Requirements

- PHP 7.4 or higher
- WordPress 5.0 or higher
- [TourMaster](https://goodlayers.com/) plugin (active tour booking theme/plugin)
- A CMI Merchant account (Client ID + Store/Hash Key)

## Installation

1. Copy the plugin folder into your WordPress installation (e.g. `wp-content/plugins/tourmaster-cmi-gateway`), or into TourMaster's own extensions directory if that's how your setup is structured.
2. Activate the plugin from **Plugins** in the WordPress admin, or make sure it's included wherever `TOURMASTER_CMI_LOCAL` is defined and loaded.
3. Go to **TourMaster → Settings → Payment** and set the **Credit Card Payment Gateway** to `CMI`.

### Configuration

Once `CMI` is selected as the credit-card gateway, a new **CMI** section appears under **TourMaster → Settings → Payment** with the following fields:

| Setting | Description |
|---|---|
| **CMI Live Mode** | Checkbox to switch between CMI's test and production endpoints |
| **CMI Test Gatway Url** | Your CMI test endpoint |
| **CMI Live Gatway Url** | Your CMI production endpoint |
| **CMI Client ID** | Your CMI merchant Client ID |
| **CMI Store Key** | Your CMI Store/Hash Key, used to sign and verify requests |

No `.env` file or config array is needed — everything is stored through TourMaster's own options screen (`goodlayers_payment_get_option` filter), the same way PayPal and Stripe credentials are handled.

## How It Works

1. When a customer reaches the **Payment** step and chooses the credit-card method, TourMaster calls the `goodlayers_cmi_payment_form` filter, which builds a hidden auto-submitting form and POSTs the customer to CMI's hosted payment page (`3D_PAY_HOSTING`), including a signed hash of the order details.
2. The customer completes 3D-Secure authentication on CMI's page.
3. **In parallel**, CMI sends a server-to-server callback to a registered REST route:

   ```
   /wp-json/cmi/v1/payment/{tid}/callback
   ```

   This callback validates the hash, checks `ProcReturnCode`, and — on success — fires `do_action('goodlayers_set_payment_complete', $tid, $payment_info)`, which TourMaster uses to mark the booking as paid, send confirmation emails, and generate the invoice.
4. The customer's browser is then redirected to your site's `okUrl` or `failUrl` (the payment page, with a status flag), where a success or failure message is shown.

Because the order status update happens through the callback rather than the browser redirect, payments are recorded correctly even if the customer closes the tab before being redirected back.

## Currency Handling

CMI processes transactions in **MAD only**. If a tour is priced in another currency, the plugin:

1. Converts the price into your site's main TourMaster currency (if different from the tour's display currency).
2. Converts from the main currency into MAD, using TourMaster's cached exchange rate data.
3. Sends the MAD amount to CMI, and on callback, converts the confirmed paid amount back into the order's original currency so invoices and dashboards display consistently.

If exchange rate data for a currency is missing, the plugin logs a warning and falls back to the original, unconverted price rather than failing the transaction.

## Testing

Use CMI's **test gateway** (`https://test-attijari.cmi.co.ma/fim/est3Dgate`) with your sandbox Client ID and Store Key, and leave **CMI Live Mode** unchecked. Refer to CMI's own test card documentation for sandbox card numbers, since (unlike some gateways) CMI does not publish a fixed universal test-card set — your sandbox merchant account credentials determine which test cards are accepted.

## Security

If you discover a security issue with this integration, please report it privately rather than opening a public issue.

## License

This plugin is open-sourced software licensed under the [MIT license](LICENSE).
