# fontawesome-to-iron-iconset
Converts the Fontawesome SVG Font to an Polymer iron-iconset-svg
# HowTo
You need the php7.0-xml or php-xml package installed (```sudo apt install php7.0-xml```)

To build simply run: ```php build.php```

The script will download font-awesome from https://www.bootstrapcdn.com/fontawesome/ and create the output icon-set in ```fa.html```

The icons will be available as ```fa:*``` (without ```fa-``` prefix)

# Example
```
<link rel="import" href="/path/to/fa.html">
<iron-icon icon="fa:shield"></iron-icon>
```
