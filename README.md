FileMaker Server Log Viewer
==================================

FileMaker Server keeps log files on the server machine, and are not always convenient to download and view. This solution uses PHP to load those log files in a viewable web page for easier server monitoring and troubleshooting.

This is written for FileMaker Server running on Windows OS servers. OS X may work, with modification to the file paths where web root and log files are located.

To use this file, simply enable PHP that comes included with FileMaker Server, and place the file in the following location:

[FileMaker Server Folder]/HTTPServer/conf/

You will want to edit the configuration variables by opening the PHP file in a text editor. Set the username and password to what you want. Optionally, if you change the file name of the PHP file, update that as a variable as well, otherwise leave that set to the default value.

Then load the file in your web browser. Select the log files you would like to view by checking those you would like to load. If Top Call Statistics are enabled in FileMaker Server, you can view those as well.

Use at your own risk. Loading log files may impact performance of your server when processing and serving large log files.