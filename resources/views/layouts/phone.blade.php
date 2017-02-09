<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no,minimal-ui"/>
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-fullscreen" content="true">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="full-screen" content="yes">
    <title>{{$title??""}}</title>
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]);?>
        ;window.qs={!! isset($qs)?json_encode($qs):'{}' !!}
    </script>

    <style>
        html {
            font-size: 14px;
            -webkit-user-select: none;
        }

        a, a:visited {
            color: #5d7895;
            text-decoration: none;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            color: #555;
            font-family:'microsoft yahei', arial, simsun;
        }

        .cf:before,
        .cf:after {
            content: "";
            display: table;
        }

        .cf:after {
            clear: both;
        }

        .page {
            min-width: 320px;
            max-width: 900px;
            border: #eee 1px solid;
            margin: 0 auto;
            box-sizing: border-box;
        }

        button,
        input,
        optgroup,
        select,
        textarea {
            color: inherit; /* 1 */
            font: inherit; /* 2 */
            margin: 0; /* 3 */

        }

        input, button {
            display: block;
            width: 90%;
            padding: 10px;
            outline: none;
            border-radius: 3px;
        }

        input {
            border: 1px #64C0F0 solid;
            color: #777;
            margin: 30px auto;

        }

        button {
            border: none;
            background: #64C0F0;
            /*box-shadow: #777 3px 3px 5px;*/
            color: white;
            padding: 12px;
            margin: 0 auto;
        }

        button:active {
            background: #2189bf;
            box-shadow: #555 3px 3px 10px;

        }

        button:disabled {
            background: #bbb;
            color: #eee;
        }

    </style>

    @yield('head')

</head>
<body>
@yield('content')
<script src="//cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>
@yield('footer')
</body>
</html>
