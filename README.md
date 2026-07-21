# Webserv Demo

This repository contains **demo website content and config templates** used with the [`webserv`](https://github.com/s-t-e-v/webserv) project.

Its goal is simple: provide a ready-to-use playground for testing `webserv` features (static files, routes, CGI, uploads, redirects, error pages) without mixing demo assets into the server codebase.

## Why this exists

- Keep `webserv` (server implementation) and `www` (demo/template content) separated.
- Make demo updates independent from server code changes.
- Provide reproducible config templates for local environments.

## Config templates

Inside `config/`, files are provided as templates:

- `webserv.conf.template`
- `website1.conf.template`
- `website2.conf.template`

They are meant to be transformed into local `.conf` files by replacing `__PROJECT_ROOT__` with your local absolute path (done by `make www` in the `webserv` repository through `scripts/apply_www_root.sh`).

## About the config syntax

The template configuration format is based on the `webserv` program configuration syntax.  
If a directive or structure looks unfamiliar, check the `webserv` repo documentation and parser behavior first.

## Relationship with webserv

- Build/run instructions live in the `webserv` repository.
- This repository provides the demo assets and config templates consumed by `webserv`.

Reference:
- webserv repository: https://github.com/s-t-e-v/webserv
