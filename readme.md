# Delta Flyer

Journey logging and checkin client that posts to a server using the ActivityPub client-to-server protocol... Sort of. 

## Run

```
docker run --rm --interactive --tty \
  --volume $PWD:/app \
  --volume ${COMPOSER_HOME:-$HOME/.composer}:/tmp \
  composer install
```

## Todo

* [x] Replace to and from text inputs with maps
* [ ] Get current location to populate from
* [ ] Autofill summary
* [ ] Get a dropdown for from and to from existing places in backend
* [ ] Make tags URI base configurable