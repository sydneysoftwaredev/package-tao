# Newrelic

```shell
export $(cat .env | xargs)
docker run \
    -d \
    --name newrelic-infra \
    --network=host \
    --cap-add=SYS_PTRACE \
    --privileged \
    --pid=host \
    -v "/:/host:ro" \
    -v "/var/run/docker.sock:/var/run/docker.sock" \
    -e NRIA_LICENSE_KEY=${NEW_RELIC_LICENCE_KEY} \
    newrelic/infrastructure:latest
```
