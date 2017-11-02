# WooCommerce Variation Structured Data - Option 3

Changes the structured data output by WooCommerce as part of investigations into [WooCommerce issue #17471](https://github.com/woocommerce/woocommerce/issues/17471).

If the query string contains the variation attributes to identify a specific variation of the product, then a variation specific Offer will be added **alongside** the original AggregateOffer. E.g.

### http://www.example.com/product/variable-widget - AggregateOffer with Min/Max price
```json
{
    "@type": "Product",
    "@id": "http:\/\/www.example.com\/product\/variable-widget\/",
    "name": "Variable widget",
    "image": "http:\/\/www.example.com\/wp-content\/uploads\/2017\/10\/widget-grey.jpg",
    "description": "Lorem ipsum dolor sit amet, consectetur adipisicing elit.",
    "sku": "VARIABLEWIDGETSKU",
    "offers": [
        {
            "@type": "AggregateOffer",
            "lowPrice": "21.99",
            "highPrice": "27.99",
            "priceCurrency": "GBP",
            "availability": "https:\/\/schema.org\/InStock",
            "url": "http:\/\/www.example.com\/product\/variable-widget\/",
            "seller": {
                "@type": "Organization",
                "name": "WC Devbox",
                "url": "http:\/\/www.example.com"
            }
        }
    ]
}
```

### http://www.example.com/my-variable-widget?attribute_pa_color=red - Offer with price of red widget
```json
{
    "@type": "Product",
    "@id": "http:\/\/www.example.com\/product\/variable-widget\/",
    "name": "Variable widget",
    "image": "http:\/\/www.example.com\/wp-content\/uploads\/2017\/10\/widget-grey.jpg",
    "description": "Lorem ipsum dolor sit amet, consectetur adipisicing elit.",
    "sku": "VARIABLEWIDGETSKU",
    "offers": [
        {
            "@type": "Offer",
            "price": "23.99",
            "priceCurrency": "GBP",
            "availability": "https:\/\/schema.org\/InStock",
            "url": "http:\/\/www.example.com\/product\/variable-widget\/?attribute_pa_color=red",
            "seller": {
                "@type": "Organization",
                "name": "WC Devbox",
                "url": "http:\/\/www.example.com"
            }
        },
        {
            "@type": "AggregateOffer",
            "lowPrice": "21.99",
            "highPrice": "27.99",
            "priceCurrency": "GBP",
            "availability": "https:\/\/schema.org\/InStock",
            "url": "http:\/\/www.example.com\/product\/variable-widget\/",
            "seller": {
                "@type": "Organization",
                "name": "WC Devbox",
                "url": "http:\/\/www.example.com"
            }
        }
    ]
}
```
**Note:** This is not intended as a final solution, or a long-term production plugin. Use it only if you are assisting with the investigation into [WooCommerce issue #17471](https://github.com/woocommerce/woocommerce/issues/17471).
