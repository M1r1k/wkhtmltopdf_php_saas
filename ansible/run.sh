#!/bin/sh
export PYTHONUNBUFFERED=1
ansible-playbook -vvvv server-playbook.yml -M ./library/ansible-xml/library/
