<?php


/*
 * View log files from FileMaker Server
 * 
 * @author Mike Duncan
 * @copyright 2019-02-06
 * 
 */

// CONFIGURATION: Edit these variables to your own needs
// set credentials
$username = "admin";
$password = "admin";

// set page name, if you want to rename this file
$filename = "log-viewer.php";

// END CONFIGURATION

ini_set('log_errors', 1);
ini_set('display_errors', 1);

ini_set('memory_limit', 10000000000) ;
session_start();



if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'logout') {
    // log out.
    session_destroy();
    session_start();
    $_SESSION['login'] = 0;
    // do the redirect
    header('Location: ' . $filename);
} elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'login') {

    //compare entered credentials with what is set above
    if ($_REQUEST['username'] == $username && $_REQUEST['password'] === $password) {
        //log the user in
        $_SESSION['login'] = 1;

        // check for logs to load
        if (isset($_REQUEST['view_event']) && $_REQUEST['view_event'] == '1') {
            $_SESSION['view_event'] = 1;
        } else {
            $_SESSION['view_event'] = 0;
        }
        if (isset($_REQUEST['view_access']) && $_REQUEST['view_access'] == '1') {
            $_SESSION['view_access'] = 1;
        } else {
            $_SESSION['view_access'] = 0;
        }
        if (isset($_REQUEST['view_wpe']) && $_REQUEST['view_wpe'] == '1') {
            $_SESSION['view_wpe'] = 1;
        } else {
            $_SESSION['view_wpe'] = 0;
        }
        if (isset($_REQUEST['view_top']) && $_REQUEST['view_top'] == '1') {
            $_SESSION['view_top'] = 1;
        } else {
            $_SESSION['view_top'] = 0;
        }

        // do the redirect
        header('Location: ' . $filename);
    } else {
        //no entry
        session_destroy();
        session_start();
        $_SESSION['login'] = 0;
    }
}

if (isset ( $_SESSION['login'] ) && $_SESSION['login'] == '1') {
// user is logged in, get the log files to display

    if ($_SESSION['view_event'] == 1) {
        ob_start();
        include '../../Logs/Event.log';
        $event = ob_get_contents();
        ob_end_clean();
    }

    if ($_SESSION['view_access'] == 1) {
        ob_start();
        include '../../Logs/Access.log';
        $access = ob_get_contents();
        ob_end_clean();
    }

    if ($_SESSION['view_wpe'] == 1) {
        ob_start();
        include '../../Logs/wpe0.log';
        $wpe = ob_get_contents();
        ob_end_clean();
    }

    if ($_SESSION['view_top'] == 1) {
        ob_start();
        include '../../Logs/TopCallStats.log';
        $topcallstats = ob_get_contents();
        ob_end_clean();
    }
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>FileMaker Server Log Viewer</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            <script>
                $(function () {
                    $("#tabs").tabs();
                });
            </script>
            <style>
                root, body {
                    margin: 0;
                    padding: 0;
                }
                body {
                    font-family: 'Lucida Grande', 'Helvetica Neue', sans-serif;
                    font-size: 13px;
                }
                #wrapper {
                    width: 100%;
                    min-height: 500px;
                    margin: 0;
                    padding: 0;
                    padding-top: 10px;
                    padding-bottom: 20px;
                }
                #content{
                    width: 90%;
                    margin-left: auto;
                    margin-right: auto;
                }
                .boxed {
                    border: 1px solid #000000;
                    padding: 1px;
                    margin-top: 10px;
                    margin-bottom: 10px;
                    background-color: #ffffff;
                    overflow: scroll;
                    height: auto;
                    max-height: 75vh;
                }
                #loginform {
                    display: none;
                    margin-left: auto;
                    margin-right: auto;
                    border: 1px solid #000000;
                    width: 250px;
                    padding: 30px;
                    padding-top: 10px;
                    padding-bottom: 10px;
                    margin-top: 10px;
                    margin-bottom: 5px;
                    background-color: #ffffff;
                }
                .button {
                    display: inline-block;
                    background-color: #f5f5f5;
                    background-image: -webkit-linear-gradient(top,#f5f5f5,#f1f1f1);
                    background-image: -moz-linear-gradient(top,#f5f5f5,#f1f1f1);
                    background-image: -ms-linear-gradient(top,#f5f5f5,#f1f1f1);
                    background-image: -o-linear-gradient(top,#f5f5f5,#f1f1f1);
                    background-image: linear-gradient(top,#f5f5f5,#f1f1f1);
                    color: #444;
                    border: 1px solid #dcdcdc;
                    -webkit-border-radius: 2px;
                    -moz-border-radius: 2px;
                    border-radius: 2px;
                    cursor: default;
                    font-size: 14px;
                    font-weight: bold;
                    text-align: center;
                    line-height: 27px;
                    min-width: 54px;
                    padding: 10px 8px 10px 8px;
                    text-decoration: none;
                }
                .button:hover {
                    background-color: #F8F8F8;
                    background-image: -webkit-linear-gradient(top,#f8f8f8,#f1f1f1);
                    background-image: -moz-linear-gradient(top,#f8f8f8,#f1f1f1);
                    background-image: -ms-linear-gradient(top,#f8f8f8,#f1f1f1);
                    background-image: -o-linear-gradient(top,#f8f8f8,#f1f1f1);
                    background-image: linear-gradient(top,#f8f8f8,#f1f1f1);
                    border: 1px solid #C6C6C6;
                    color: #333;
                    -webkit-box-shadow: 0px 1px 1px rgba(0,0,0,.1);
                    -moz-box-shadow: 0px 1px 1px rgba(0,0,0,.1);
                    box-shadow: 0px 1px 1px rgba(0,0,0,.1);
                }
                .button.blue {
                    background-color: #4D90FE;
                    background-image: -webkit-linear-gradient(top,#4d90fe,#4787ed);
                    background-image: -moz-linear-gradient(top,#4d90fe,#4787ed);
                    background-image: -ms-linear-gradient(top,#4d90fe,#4787ed);
                    background-image: -o-linear-gradient(top,#4d90fe,#4787ed);
                    background-image: linear-gradient(top,#4d90fe,#4787ed);
                    border: 1px solid #3079ED;
                    color: white;
                }
                .button.blue:hover {
                    border: 1px solid #2F5BB7;
                    background-color: #357AE8;
                    background-image: -webkit-linear-gradient(top,#4d90fe,#357ae8);
                    background-image: -moz-linear-gradient(top,#4d90fe,#357ae8);
                    background-image: -ms-linear-gradient(top,#4d90fe,#357ae8);
                    background-image: -o-linear-gradient(top,#4d90fe,#357ae8);
                    background-image: linear-gradient(top,#4d90fe,#357ae8);
                    -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.1);
                    -moz-box-shadow: 0 1px 1px rgba(0,0,0,.1);
                    box-shadow: 0 1px 1px rgba(0,0,0,.1);
                }
            </style>
    </head>
    <body>
        <div id="wrapper">
            <div id="content">
                <?php if (isset($_SESSION['login']) && $_SESSION['login'] == '1') { ?>
                    <p>
                        <a href="?action=logout">Log Out</a> | <a href="?action=refresh">Refresh</a>
                    </p>
					
                    <div id="tabs">
                        <ul>
                            <?php if ($_SESSION['view_event'] == 1) { ?>
                                <li><a href="#content_event">Event Log</a></li>
                            <?php } ?>
                            <?php if ($_SESSION['view_access'] == 1) { ?>
                                <li><a href="#content_access">Access Log</a></li>
                            <?php } ?>
                            <?php if ($_SESSION['view_wpe'] == 1) { ?>
                                <li><a href="#content_wpe">WPE Log</a></li>
                            <?php } ?>
                            <?php if ($_SESSION['view_top'] == 1) { ?>
                                <li><a href="#content_topcallstats">Top Call Stats</a></li>
                            <?php } ?>
                        </ul>
                        <?php if ($_SESSION['view_event'] == 1) { ?>
                            <div id="content_event" class="boxed">
                                <pre><?php print_r($event); ?></pre>
                            </div>
                        <?php } ?>
                        <?php if ($_SESSION['view_access'] == 1) { ?>
                            <div id="content_access" class="boxed">
                                <pre><?php print_r($access); ?></pre>
                            </div>
                        <?php } ?>
                        <?php if ($_SESSION['view_wpe'] == 1) { ?>
                            <div id="content_wpe" class="boxed">
                                <pre><?php print_r($wpe); ?></pre>
                            </div>
                        <?php } ?>
                        <?php if ($_SESSION['view_top'] == 1) { ?>
                            <div id="content_topcallstats" class="boxed">
                                <pre><?php print_r($topcallstats); ?></pre>
                            </div>
                        <?php } ?>
                    </div>

                    <p>
                        &copy; <?php echo date('Y'); ?> <a href="https://www.soliantconsulting.com">Soliant Consulting</a>
                    </p>

                <?php } else { ?>
                    <div id="loginform">
                        <p>
                            <b>FileMaker Server Log Viewer</b>
                        </p>
                        <p>
                            Please log in.
                        </p>
                        <form action="<?php echo $filename; ?>" method="POST">
                            <table align="center">
                                <tr>
                                    <td>User: </td><td><input type="text" id="username" name="username" value="" /></td>
                                </tr>
                                <tr>
                                    <td>Password: </td><td><input type="password" name="password" value="" /></td>
                                </tr>
                                <tr>
                                    <td valign="top">Log Files: </td><td>
                                        <input type="checkbox" name="view_event" value="1" checked /> Event Log<br />
                                        <input type="checkbox" name="view_access" value="1" checked /> Access Log<br />
                                        <input type="checkbox" name="view_wpe" value="1" checked /> WPE Log<br />
                                        <input type="checkbox" name="view_top" value="1" checked /> Top Call Stats<br />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><br /><input type="submit" name="action" value="login" class="button blue" style="width: 100%;" /></td>
                                </tr>
                            </table>
                        </form>

                        <p>
                            &copy; <?php echo date('Y'); ?> <a href="https://www.soliantconsulting.com">Soliant Consulting</a>
                        </p>

                    </div>

                    <script language="javascript">
                        <!-- // Begin
                        $('#loginform').fadeIn(1600);
                        document.getElementById("username").focus();
                        // -->
                    </script>

                <?php } ?>


            </div>
        </div>
</html>