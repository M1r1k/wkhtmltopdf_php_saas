WKHtmlToPDF as Service via PHP REST API built with Silex framework
=====

What is inside:
[wkhtmltopdf](http://wkhtmltopdf.org) tool to generate PDF from HTML
[phpwkhtmltopdf](https://github.com/mikehaertl/phpwkhtmltopdf) PHP class-wrapper for wkhtmltopdf CLI
[Silex](http://silex.sensiolabs.org) PHP mini-framework to build REST API service
[Ansible](http://docs.ansible.com) Vagrant/Server provision scripts

Local development
=====

`
git clone git@github.com:M1r1k/wkhtmltopdf_php_saas.git
cd wkhtmltopdf_php_saas
vagrant up
`

Add "192.168.1.2 wkhtmltopdf.dev" to /etc/hosts.

Then make POST to generate Google frontpage.
`
curl -H "Content-Type: application/json" -X POST -d '{"url":"https://www.google.com/"}' http://wkhtmltopdf.dev/rest/generate
`

Deploying to server (Digital Ocean example)
=====

