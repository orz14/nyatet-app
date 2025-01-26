<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="dark" />
    <meta name="supported-color-schemes" content="dark" />
    <title>{{ $subject }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            border: 0;
            box-sizing: border-box;
        }
    </style>
</head>

<body
    style="
      width: 100%;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
      font-size: 16px;
      background-color: #030712;
      color: #f9fafb;
      padding: 0;
      line-height: 1.45;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    ">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center">
                <div style="width: 100%; background-color: #4f46e5; padding: 40px 1rem">
                    <div style="width: 100%; max-width: 700px; text-align: left">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td align="left">
                                    <a href="{{ config('app.frontend_url') }}" target="_blank">
                                        <img src="https://cdn.jsdelivr.net/gh/orz14/orzcode@main/img/logo-nyatet-app-white.png"
                                            alt="{{ config('app.name') }}" style="width: 130px; height: auto" />
                                    </a>
                                </td>
                                <td align="right">
                                    <a href="{{ config('app.frontend_url') }}"
                                        style="color: #f9fafb; text-decoration: none"
                                        target="_blank">nyatet.orzverse.com</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div style="width: 100%; padding: 0 1rem; margin-top: 1.5rem">
                    <div style="width: 100%; max-width: 700px; text-align: left">
                        <div
                            style="width: 100%; background-color: #030712; border: 1px solid #111827; border-radius: 0.5rem; padding: 1rem">
                            @yield('content')
                        </div>
                        <div
                            style="width: 100%; background-color: #4f46e5; border-radius: 0.5rem; font-size: 12px; text-align: center; padding: 1.5rem 0; margin: 1rem 0">
                            <span style="color: #f9fafb">&copy; {{ date('Y') }} <a href="https://orzverse.com"
                                    style="color: #fff; text-decoration: none" target="_blank">ORZVERSE</a>. All rights
                                reserved.</span>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
