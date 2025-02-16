# Apache AggregateDownloader

## Purpose
 In an Apache webserver, there are default "autoindex" pages. These pages display the filesystem where the webserver is in an HTML format.
 This autoindex page does not have a way for users to recursively download all files, so this bundle of files creates one.

## Implementation
 `index.conf` is an Apache configuration file. It tells the server to insert `/control/autoindex/autoindex.php` to every autoindex page, and to execute that php script before delivery. That php script does the following:
 1. Loads and populates `/control/autoindex/metatags.hml` to add page metadata.
 2. Inserts `/control/aggrDonwload/aggrDownloadHeader.html` to modify the table to have a new element that will launch `/control/aggrDownload/aggregateDownload.html` with a URI parameter to the current directory.
 
 `aggregateDownload.html` is the main page that when visited makes a fetch request to `/control/aggrDownload/aggregateDownload.php`, which starts creating the archive in `/control/aggrDownload/tmp_download` and returns the name of the file to the webpage. The webpage then polls this file location until response.ok == true (Response 2XX) and then opens that page to start the download.

## Security Concerns
This program does its best to address the issue of people being able to download other people's aggregate downloads by placing them in a special folder that is hidden from end users. Without the link to the files in this folder, you can't know what they are. The script also deleted previous aggregate downloads that are older than 1 hour.

## Timeout Issues
By default, Apache will time out after only a few minutes. If it takes a while to download a file, you will need to use `mod_proxy` to extend the connection timeout. This is configured in the `index.conf`. This behavior can be enabled by doing `a2enconf proxy`.
