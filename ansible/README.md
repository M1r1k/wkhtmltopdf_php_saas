CIBox (Continuous Integration Box)
=====

[RoadMap for CIBOX](https://github.com/propeoplemd/cibox/wiki/RoadMap)

Wiki https://github.com/propeoplemd/cibox/wiki

Introduction video http://youtu.be/EJZcqTcycf0
TIP:
Don't forget to setup HIPCHAT settings with CHANGE_ME... placeholders to be able meet project requirements

This repo consists basically from two playbooks
- CI server installation/provisioning jenkinsbox.yml
- github.yml repo builder with drupal, vagrant, puppet, drupal pp installation profile, scripts for reinstalling and sniffing with sniffers

You have to use *64bit* Ubuntu 12.04 LTS or 14.04 LTS systems for CI server

Common and base apps and packages
=====
cibox-misc role contains all basic packages required for cibox and vagrant installation.

Possible variations
=====

Currently jenkinsbox.yml playbook powered with tags, so you can run only part of it.

Install SOLR only
=====

```sh
ansible-playbook jenkinsbox.yml --tags "ansible-jetty-solr"
```

Install php stack.
=====

```sh
ansible-playbook jenkinsbox.yml --tags "php-stack"
```

Other tags self-explained
=====

run them as
```sh
ansible-playbook jenkinsbox.yml --tags "TAGNAME"
```

- ansible-jenkins
- ansible-composer
- ansible-php-pear
- ansible-php-xhprof
- ansible-sniffers
- apache
- mysql
- cibox-mysql-config
- cibox-swap
- cibox-ssl-config


OpenVZ support
=====

If your system build on OpenVZ stack and swap is disabled you may bypass
it with using fakeswap.sh file within files/fakeswap directory

for use this script run on remote system console
```sh
chmod a+x fakeswap.sh
```
and
```sh
sh ./fakeswap.sh 4086
```
for adding 4086MB swap size


Roles not used by default
=====

Within a roles/ subfolder there are roles, been imported from some projects but
not used by default

- cibox-phpdaemon: - role from HP project for installing phpdaemon
- ansible-role-php-pecl: - role, originally developed by geerlingguy but without
 dependency from his php playbook. Can be used for installing pecl packages.

