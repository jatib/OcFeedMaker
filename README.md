# OcFeedMaker for Open Cart.

## To do a feed file to use with Google Merchant.

This program has been maked to do a feed file compatible with the Google Merchant center. It's not an extension nor module right now, but _**furter in the future will be**_.
 

**Actually it's under develop.**

## How to install (OcFeedMaker 0.0.1).

Update the files **feed.php** and **functions.php** (from **src**) to your host at the root of your Opencart installation, e.g. at http://www.shop.com/ (or where you copy and paste the **upload** folder)

### How to do a Feed.

Do a _feed_ is quite easy, only go to http://www.shop.com/feed.php in your browser, and automatically you will been redirect to the feed file on your browser to verify that the information it's there.

### Enable test mode

If you have any problem, you can enable the test mode to view the information it's correctly feeded to the file. For this, only change the value of **$test** in **feed.php:**

    $test = 1
You can view some relevant data adding the **1** value to the function **totalElements()**

    totalElements($key,1);
#### Directories structure.
- docs: Documentation
- src: Files of the operative versions
- test: Tests and examples
- wip: Work in Progress

#### Authors:

- [Raúl Ramírez](https://github.com/jatib "jatib")

if you want to contribute please send a mail to: [jatib@ciencias.uanm.mx](to:jatib@ciencias.uanm.mx)

