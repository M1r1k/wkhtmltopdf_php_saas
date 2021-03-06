WKHtmlToPDF as Service via PHP REST API built with Silex framework
=====

REST service to generate PDF files of given URL(s).

What is inside:
* [wkhtmltopdf](http://wkhtmltopdf.org) tool to generate PDF from HTML
* [phpwkhtmltopdf](https://github.com/mikehaertl/phpwkhtmltopdf) PHP class-wrapper for wkhtmltopdf CLI
* [Silex](http://silex.sensiolabs.org) PHP mini-framework to build REST API service
* [Ansible](http://docs.ansible.com) Vagrant/Server provision scripts

Local development
=====

```
git clone git@github.com:M1r1k/wkhtmltopdf_php_saas.git
cd wkhtmltopdf_php_saas
vagrant up
```

Add "192.168.150.250 wkhtmltopdf.dev" to /etc/hosts.

Then make POST to generate Google frontpage.

`
curl -H "Content-Type: application/json" -X POST -d '{"url":"https://www.google.com/"}' http://wkhtmltopdf.dev/rest/pdf/generate > test.pdf
`

Deploying to server (Digital Ocean example)
=====

Create Droplet on DO

Change hosts file IP to your new server


`
sh run.sh
`

Add "YOUR_DROPLET_IP wkhtmltopdf.prod" to /etc/hosts.

**!!!BINGOOOO!!!**