# jQuery CountdownGampang
#### inspired and implemented the [jQuery ClassyCountdown](https://github.com/arsensokolov/jquery.classycountdown)

[![N|jQuery](https://yaniarprayogo.files.wordpress.com/2014/06/jquery_logo.png)](https://jquery.com)

[![Build Status](https://travis-ci.com/fadhilah1992/jquery-countdowngampang.svg?branch=main)](https://travis-ci.com/fadhilah1992/jquery-countdowngampang)

Thanks to [@arsenkolov](https://github.com/arsensokolov/) for creating a jQuery plugin, [jQuery ClassyCountdown](https://github.com/arsensokolov/jquery.classycountdown). I made this plugin almost all of my JS code just rewrote from ClassyCountdown and did very few changes :) so the main credits keep going back to the original creator of the ClassyCountdown script.

## Features

- Countdown the time from the preset time.
- The timing is made with the `Date` class 
- Custom theme from the original jQuery ClassyCountdown :)
- Custom style it's also a built-in jQuery ClassyCountdown feature :)

jQuery Countdown Gampang is a jQuery plugin that makes use of Html5 canvas to render a slick, circular, themeable countdown timer on your web page.
As [@arsensokolov](https://github.com/arsensokolov/) writes on the [ ClassyCountdown README](https://github.com/arsensokolov/jquery.classycountdown).

## Dependencies:

- [jQuery](https://jquery.com) - because this is a jQuery plugin.
- [jQuery ClassyCountdown](https://github.com/arsensokolov/jquery.classycountdown) - CSS (Original Script) Files for styling.
- [jQuery throttle](https://github.com/cowboy/jquery-throttle-debounce) - Allows you to rate-limit your functions in multiple useful ways.
- [jQuery knob](https://github.com/aterrien/jQuery-Knob) - Nice, downward compatible, touchable, jQuery dial.


## How to use it:
##### CSS:
#
```html
<!-- jQuery Classy Countdown CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery.classycountdown@1.0.1/css/jquery.classycountdown.min.css">
```
##### Javascript:
#
```html
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<!-- jQuery knob-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Knob/1.2.13/jquery.knob.min.js" integrity="sha512-NhRZzPdzMOMf005Xmd4JonwPftz4Pe99mRVcFeRDcdCtfjv46zPIi/7ZKScbpHD/V0HB1Eb+ZWigMqw94VUVaw==" crossorigin="anonymous"></script>
<!-- jQuery throttle-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js" integrity="sha512-JZSo0h5TONFYmyLMqp8k4oPhuo6yNk9mHM+FY50aBjpypfofqtEWsAgRDQm94ImLCzSaHeqNvYuD9382CEn2zw==" crossorigin="anonymous"></script>
<!-- jQuery Countdown Gampang-->
<script src="/path/to/js/jquery.countdowngampang.min.js"></script>
```
## Countdown it:
`example file /path/to/js/script.js`:
```js
$(document).ready(function(){
   var element = $('#countdown-gampang'); // element with id countdown-gampag
   var finish_d = new Date("Mar 1, 2021 00:00:00"); // or other format
   element.CountdownGampang({
      rampung: finish_d,
      theme: "default"
   }, function(){
       // callback that is fired when the countdown reaches 0.
       alert("Finish Bro :)");
   });
});
```
## Starter:
```html
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>jQuery Countdown Gampang</title>
    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" integrity="sha512-P5MgMn1jBN01asBgU0z60Qk4QxiXo86+wlFahKrsQf37c9cro517WzVSPPV1tDKzhku2iJ2FVgL67wG03SGnNA==" crossorigin="anonymous" />
    <!-- jQuery Classy Countdown CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery.classycountdown@1.0.1/css/jquery.classycountdown.min.css">
</head>
<body>
    <div class="container">
        <div style="margin: 80px auto;">
            <div style="width:100%;">
                <div id="countdown-gampang"></div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <!-- jQuery knob-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Knob/1.2.13/jquery.knob.min.js" integrity="sha512-NhRZzPdzMOMf005Xmd4JonwPftz4Pe99mRVcFeRDcdCtfjv46zPIi/7ZKScbpHD/V0HB1Eb+ZWigMqw94VUVaw==" crossorigin="anonymous"></script>
    <!-- jQuery throttle-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js" integrity="sha512-JZSo0h5TONFYmyLMqp8k4oPhuo6yNk9mHM+FY50aBjpypfofqtEWsAgRDQm94ImLCzSaHeqNvYuD9382CEn2zw==" crossorigin="anonymous"></script>
    <!-- jQuery Countdown Gampang-->
    <script src="https://raw.githubusercontent.com/fadhilah1992/jquery-countdowngampang/main/dist/jquery-countdowngampang.min.js"></script>
    <script>
        $(document).ready(function(){
            var element = $('#countdown-gampang'); // element with id countdown-gampag
            var finish_d = new Date("Mar 1, 2021 00:00:00"); // or other format
            element.CountdownGampang({
                rampung: finish_d,
                theme: "default"
            }, function(){
                // callback that is fired when the countdown reaches 0.
                alert("Wes Wayahe Bro :)");
            });
        });
    </script>
</body>
</html>
```
## jQuery Countdown Gampang Parameters:
-------------------
```js
$.fn.CountdownGampang = function(options, callback){
    /*************************************************************
     * options: object
     * {
     *   theme: "default",
     *   rampung: undefined,
     * }
     * callback: callable (function) {
     *     //callback that is fired when the countdown reaches 0.
     * }
     *************************************************************/
}

//....... to be continued
```

## Credits:
- [@arsensokolov](https://github.com/arsensokolov/) [jQuery ClassyCountdown](https://github.com/arsensokolov/jquery.classycountdown)
```
Copyright (c) 2018 Arsen Bespalov
Copyrigth (c) 2021 Mas Fadhilah
```
