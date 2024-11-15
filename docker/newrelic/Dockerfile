ARG IMAGE_NAME
FROM ${IMAGE_NAME}

ARG NEW_RELIC_AGENT_VERSION
ARG NEW_RELIC_LICENCE_KEY
ARG NEW_RELIC_APPNAME

RUN curl -L https://download.newrelic.com/php_agent/archive/${NEW_RELIC_AGENT_VERSION}/newrelic-php5-${NEW_RELIC_AGENT_VERSION}-linux.tar.gz | tar -C /tmp -zx \
    && export NR_INSTALL_USE_CP_NOT_LN=1 \
    && export NR_INSTALL_SILENT=1 \
    && /tmp/newrelic-php5-${NEW_RELIC_AGENT_VERSION}-linux/newrelic-install install \
    && rm -rf /tmp/newrelic-php5-* /tmp/nrinstall*

RUN sed -i \
  -e "s/newrelic.license[[:space:]]*=[[:space:]]*.*/newrelic.license = ${NEW_RELIC_LICENCE_KEY}/" \
  -e "s/newrelic.appname[[:space:]]*=[[:space:]]*.*/newrelic.appname = ${NEW_RELIC_APPNAME}/" \
  -e "\$a newrelic.daemon.address=newrelic-php-daemon:31339" \
  -e "s/;newrelic.transaction_events.attributes.include = \"\"/newrelic.transaction_events.attributes.include = \"request.parameters.*\"/" \
  -e "s/;newrelic.transaction_tracer.attributes.include = \"\"/newrelic.transaction_tracer.attributes.include = \"request.parameters.*\"/" \
  -e "s/;newrelic.error_collector.attributes.include = \"\"/newrelic.error_collector.attributes.include = \"request.parameters.*\"/" \
  -e "s/;newrelic.browser_monitoring.attributes.enabled = false/newrelic.browser_monitoring.attributes.enabled = true/" \
  -e "s/;newrelic.browser_monitoring.attributes.include = \"\"/newrelic.browser_monitoring.attributes.include = \"request.parameters.*\"/" \
  /usr/local/etc/php/conf.d/newrelic.ini
