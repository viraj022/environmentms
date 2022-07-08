<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />

    <style id="webmakerstyle">
        body {
            font-family: "Helvetica", "Arial", "Calibri", "Verdana", "Georgia",
                "Times New Roman", "Courier";
            font-size: 16px;
        }

        #wrapper {
            width: 800px;
            margin: 25px auto;
            text-align: center;
        }

        #wrapper .header {
            margin: 35px;
        }

        #wrapper .header .logo-image {
            height: 100px;
        }

        #wrapper .content {
            width: 600px;
            margin: auto;
            line-height: 1.5em;
        }

        #wrapper .content .payment-link {
            text-decoration: none;
            padding: 1em 3em;
            background-color: #e9a019;
            color: #ffffff;
            font-weight: 800;
        }

        #wrapper .payment-info {
            margin-top: 2em;
            text-align: center;
        }

        #wrapper .payment-info .instructions {
            padding: 1em 2em;
            margin-top: 1em;
        }

        #wrapper .footer .disclaimer {
            font-size: 10px;
            line-height: 10px;
        }

        #wrapper .footer a {
            text-decoration: none;
            font-weight: bold;
            color: inherit;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <div class="header">
            <img src="https://environmentms.ceytechsystemsolutions.com/dist/img/uilogo.png" alt=""
                class="logo-image" />
            <h2>Environment Authority North Western Province</h2>
        </div>
        <div class="content">
            @yield('content')

            <div class="footer">
                <p>
                    Provincial Environmental Authority of North Western Province <br />
                    <small>Dambulla road, Kurunegala.</small> <br />
                    <small>
                        Tel: <a href="tel:+94372225236">037-22-25-236</a> | Fax:
                        037-22-29-688
                    </small>
                    <br />
                    <small>
                        <a href="mailto:pentanwp@gmail.com">pentanwp@gmail.com</a>
                    </small>
                </p>
                <small class="disclaimer">
                    The content of this email is confidential and intended for the
                    recipient specified in message only. It is strictly forbidden to share
                    any part of this message with any third party, without a written consent
                    of the sender. If you received this message by mistake, please contact
                    us so that we can ensure such a mistake does not occur in the future.
                </small>
            </div>
        </div>
    </div>

</body>

</html>
