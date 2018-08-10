<!DOCTYPE html>
<html class="no-js">
<head>
	<script></script>
	<meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Instagram widget</title>
    <style>
        html, body {
            margin: 0; padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif;
        }
        #instafeed {
            display: flex;
            flex-wrap: wrap;
        }
        figure {
            display: flex;
            box-sizing: content-box;
            flex: 0 1 50%;
            text-align: center;
            margin: 0;
            background: #eee;
        }
        @media screen and (min-width: 48rem){
            figure {
                flex-basis: 25%;
            }
        }
        figure img {
            max-width: 100%;
            height: auto;
        }
        figure a {
            position: relative;
            display: block;
            background: rgba(128,255,0,.1);
            padding: 1rem;
            border: 1px solid #fff;
            transition: border-color 150ms ease-in;
        }
        figure a:hover {
            border: 1px solid #090;
        }
        figure a:visited {
            background: inherit;
        }
        figcaption {
            font-size: .75rem;
        }
    </style>
</head>
<body>

<div id="instafeed"></div>

<script>
(function() {
    
    var localData = function() {
                if ('localStorage' in window) {
                    var data = window.localStorage.getItem('apiTestData');
                    if (data) {
                        return JSON.parse(data);
                    }
                }
                return false;
            }

    var loadScript = function(url, callback) {

        var script = document.createElement("script")
        script.type = "text/javascript";

        if (script.readyState) { //IE
            script.onreadystatechange = function() {
                if (script.readyState == "loaded" || script.readyState == "complete") {
                    script.onreadystatechange = null;
                    callback();
                }
            };
        } else { //Others
            script.onload = callback;
        }

        script.src = url;
        document.getElementsByTagName("head")[0].appendChild(script);
    }

    loadScript("https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js", function() {
        $.ajax({
            type: 'GET',
            url: '/IG/json.php',
            error: function (response) {
                console.log(response);
            },
            success: function (response) {
                if(response && response.medias){
                    $.each(response.medias, function(){
                        console.log(this);
                        if(this.displaySrc){
                            $('#instafeed').append('<figure><a href="' +this.link+ '"><img src="' +this.thumbnails[0].src+ '" srcset="' +this.thumbnails[1].src+ ' ' +this.thumbnails[1].config_width+ 'w, ' +this.thumbnails[2].src+ ' ' +this.thumbnails[2].config_width+ 'w, ' +this.thumbnails[3].src+ ' ' +this.thumbnails[3].config_width+ 'w" />' +(this.caption ? '<figcaption>' +this.caption+ '</figcaption>' : '')+ '</a></figure>');
                        }
                    });
                }
            }
        });
    });
})();
</script>

</body>
</html>