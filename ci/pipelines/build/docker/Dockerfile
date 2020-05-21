FROM docker-registry.test.etribes.de:5000/shopware-6:6.1.5-2

ADD src /sw6

USER root

RUN apk add composer yarn
RUN chown sw6:sw6 -R /sw6

USER sw6
