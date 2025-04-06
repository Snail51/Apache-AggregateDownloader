#!/bin/bash

find /mnt/hdd/web/control/aggrDownload/tmp_download -type f -mmin +60 -delete
find /var/www/html/control/aggrDownload/tmp_download -type f -mmin +60 -delete
