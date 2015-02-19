CHANGELOG
=========

0.5.0 (2015-02-19)
------------------

* Improved Traffic Management and Message Management constructors to allow either a HTTP client instance or a HTTP client configuration array to be supplied to the constructor, instead of just a HTTP client instance
* Fixed bug where zone getAllRecords() call was returning an array with duplicated key names (thanks @BillKeenan)
* Fixed bug where a user-supplied HTTP client instance was ignored by the Traffic Management constructor (thanks @BillKeenan)

0.4.1 (2014-11-4)
------------------

* Fixed a bug where the serial_style was not supplied to the API when creating new zones (thanks @fogeytron)
* Ensured API client's last response variable is nulled before each new API request

0.4.0 (2014-08-15)
------------------

* Added support for new Message Management send parameters

0.3.0 (2014-08-07)
------------------

* Added support for all Message Management endpoints

0.2.0 (2014-07-22)
------------------

* Added HTTP Redirect support
* Added Dynamic DNS support

0.1.0 (2014-07-18)
------------------

* Initial release with create/update/delete DNS records and zone functionality
