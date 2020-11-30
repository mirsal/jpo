# Installation

**[⬆ back to readme](../README.md)**


## Requirements

Install the latest version of docker:
 - [Debian](https://docs.docker.com/engine/install/debian/)
 - [Ubuntu](https://docs.docker.com/engine/install/ubuntu/)
 - [MacOS](https://docs.docker.com/docker-for-mac/install/)
 - [Windows](https://docs.docker.com/docker-for-windows/install/)


## Enable the docker swarm mode

To enabled the swarm:
```
$ docker swarm init
```
To disable:
```
$ docker swarm leave
```


## Traefik (Mandatory)

Run the traefik reverse proxy _(If you don't have a reverse proxy running on your machine)_
```
$ docker network create --scope swarm --driver overlay traefik_reverse_proxy
$ docker stack deploy -c .docker/traefik/docker-compose.yml traefik
```
To remove the traefik stack:
```
$ docker stack rm traefik
```
Once traefik run, open your browser at 127.0.0.1:8080


## Portainer (Optional)

This tool allows you to easily manage your docker container environment using web interfaces.
To install this tool using docker:
```
$ docker stack deploy -c .docker/portainer/docker-compose.yml portainer
```
To remove the portainer stack:
```
$ docker stack rm portainer
```

Add a DNS entry in your local hosts file:
```
127.0.0.1 portainer.docker
```
Then open your browser and enjoy portainer web interfaces !


## MPP (Mandatory)

Build php-fpm docker image:
```
$ make build-image
```
Then deploy the mpp stack:
```
$ docker stack deploy -c .docker/jpo/docker-compose.yml jpo
```
To remove the mpp stack:
```
$ docker stack rm jpo
```

Add the following DNS entries in your local hosts file:
```
# Mpp
127.0.0.1	jpo.docker
127.0.0.1	redis-commander.jpo.docker
```


## Install Symfony vendors

```
$ make composer-install
```


## For windows users only

Every docker command lines inside of the makefile doesn't accept double quotes.
So don't forget to remove it at any line like this :
```
docker exec -i $(php_container_id)
```