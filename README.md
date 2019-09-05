# vatsim-atis-gen

Unfortunately, from time to time the VATSIM METAR server goes down. This project bridges the gap, so that when the VATSIM METAR service goes down, it doesn't affect your ATIS capability.

## Usage

Simply replace the standard ATIS generator URL:
`
http://uniatis.net/atis.php?arr=$arrrwy($atisairport)&dep=$deprwy($atisairport)&apptype=ILS&info=$atiscode&metar=$metar($atisairport)
`

With the following (changes in bold):
**http://path-to-src.com/?icao=\$atisairport&**`
arr=$arrrwy($atisairport)&dep=$deprwy($atisairport)&apptype=ILS&info=$atiscode
`
Ensure you remove the `&metar=$metar($atisairport)` section.

You can still use all the fancy bells and whistles of uniatis, just add them as normal!

## Deployment
Using Composer:
`composer install`

Make sure the URL resolves to the `public` folder.
